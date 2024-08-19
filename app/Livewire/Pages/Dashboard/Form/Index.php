<?php

namespace App\Livewire\Pages\Dashboard\Form;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Config;
use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;
use App\Helpers\PDFPart;
use App\Helpers\PDFMimeType;
use App\Models\AnalysisHistory;
use App\Models\GenerateHistory;
use App\Models\Cv;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Index extends Component
{
    use WithFileUploads;

    public $analysisType = 'analyst';
    public $jobPosition = '';
    public $jobDescription = '';
    public $file;
    public $buttonStatus = 'disabled';

    public function mount()
    {
        $this->checkGenerateLimit();
    }

    public function render()
    {
        return view('livewire.pages.dashboard.form.index');
    }

    public function setAnalysisType($type)
    {
        $this->analysisType = $type;
    }

    public function submitForm()
    {
        // if user has reached the daily limit for CV analysis
        if ($this->buttonStatus === 'disabled') {
            $this->addError('form', 'You have reached the daily limit for CV analysis.');
            return;
        }

        $validationRules = [
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ];

        if ($this->analysisType === 'analyst_with_job_position') {
            $validationRules['jobPosition'] = 'required|string|max:255';
        } elseif ($this->analysisType === 'analyst_with_job_description') {
            $validationRules['jobDescription'] = 'required|string';
        }

        $this->validate($validationRules);

        if (!$this->file) {
            $this->addError('form', 'CV PDF is required');
            return;
        }

        if ($this->analysisType === 'analyst_with_job_position' && !$this->jobPosition) {
            $this->addError('form', 'Job position is required for this analysis type');
            return;
        }

        if ($this->analysisType === 'analyst_with_job_description' && !$this->jobDescription) {
            $this->addError('form', 'Job description is required for this analysis type');
            return;
        }

        $pdfContent = $this->file->get();
        $base64Pdf = base64_encode($pdfContent);

        $prompt = $this->getCVAnalysisPrompt();

        $geminiApiKey = Config::get('gemini.api_key');
        $client = new Client($geminiApiKey);

        try {
            $response = $client->geminiProFlash1_5()->generateContent(
                new TextPart($prompt),
                new PDFPart(PDFMimeType::PDF, $base64Pdf)
            );

            $cleanedResponse = $this->cleanJsonResponse($response->text());
            $decodedResponse = json_decode($cleanedResponse, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON response from API');
            }

            // Save CV path to DB
            $cvId = $this->saveCvPath();

            // Save to DB to generate history
            $this->saveAnalysisHistory($decodedResponse, $cvId);
            $this->dispatch('analysisCompleted', $decodedResponse);

            // Check generate limit after successful submission
            $this->checkGenerateLimit();
        } catch (\Exception $e) {
            $this->addError('form', 'An error occurred while processing your request: ' . $e->getMessage());
        }

        // Reset the form after submission
        $this->reset(['jobPosition', 'jobDescription', 'file']);
    }

    private function getCVAnalysisPrompt(): string
    {
        $prompt = <<<EOT
        You are a CV Analysis expert. Analyze the following CV
        EOT;

        if ($this->analysisType === 'analyst') {
            $prompt .= "and provide a general evaluation. ";
        } elseif ($this->analysisType === 'analyst_with_job_position') {
            $prompt .= "based on the given job position: {$this->jobPosition}. ";
        } elseif ($this->analysisType === 'analyst_with_job_description') {
            $prompt .= "based on the following job description: {$this->jobDescription}. ";
        }

        $prompt .= <<<EOT
        Provide a JSON response with the structure:
        {
            "name": "<Candidate Name>",
            "score": "<Overall Score>",
            "criteria-detail": [
            {
                "criteria": "<Criteria Name>",
                "score": "<Criteria Score>",
                "description": "<Description of the evaluation>"
            },
            ...
            ]
        }

        EOT;

        if ($this->analysisType !== 'analyst') {
            $prompt .= "Criteria:\n";
            $criteria = [
                'workExperience' => 'Relevant work experience',
                'skills' => 'Required skills',
                'education' => 'Educational background',
                'certifications' => 'Certifications',
                'achievements' => 'Achievements',
            ];

            foreach ($criteria as $key => $label) {
                if (!empty($this->$key)) {
                    $prompt .= "- {$label}: {$this->$key}\n";
                }
            }
        }

        $prompt .= <<<EOT

        Use scale 1-100 for the scores and provide a brief description for each criteria.
        EOT;

        return $prompt;
    }

    private function cleanJsonResponse(string $response): string
    {
        return preg_replace('/```(json)?\n?/', '', $response);
    }

    private function saveCvPath(): string
    {
        try {
            $originalFileName = $this->file->getClientOriginalName();
            $path = $this->file->storeAs('cvs', $originalFileName);
            $cv = Cv::create([
                'path' => $path,
                'file_name' => $originalFileName,
                'user_id' => Auth::id(),
            ]);
            return $cv->id;
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            Log::error('Error saving CV: ' . $e->getMessage());
            throw $e; // Re-throw the exception if you want to handle it at a higher level
        }
    }

    private function saveAnalysisHistory(array $analysisResult, string $cvId): void
    {
        try {
            $ipAddress = $this->getIpAddress();

            DB::transaction(function () use ($analysisResult, $ipAddress, $cvId) {
                $data = [
                    'user_ip_address' => $ipAddress,
                    'job_position' => $this->jobPosition,
                    'job_description' => $this->jobDescription,
                    'result' => json_encode($analysisResult),
                    'analysis_type' => $this->analysisType,
                    'cv_id' => $cvId,
                ];

                if (Auth::check()) {
                    $data['user_id'] = Auth::id();
                }

                GenerateHistory::create($data);
            });
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            Log::error('Error saving analysis history: ' . $e->getMessage());
            throw $e; // Re-throw the exception if you want to handle it at a higher level
        }
    }

    private function getIpAddress(): string
    {
        return request()->ip() ?? '0.0.0.0';
    }

    private function checkGenerateLimit()
    {
        $today = Carbon::today();
        $ipAddress = $this->getIpAddress();

        if (Auth::check()) {
            $userId = Auth::id();
            $generateCount = GenerateHistory::where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->count();
            $limit = 5;
        } else {
            $generateCount = GenerateHistory::where('user_ip_address', $ipAddress)
                ->whereDate('created_at', $today)
                ->count();
            $limit = 2;
        }

        $this->buttonStatus = $generateCount >= $limit ? 'disabled' : 'enabled';
    }
}
