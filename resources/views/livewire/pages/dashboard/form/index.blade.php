<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <div class="mt-3">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">CV Analyst Form</h3>
        <div class="mb-6 flex justify-center space-x-4">
            <div class="mb-6 flex justify-center space-x-4" x-data="{ selected: @entangle('analysisType') }">
                <button type="button" wire:click="setAnalysisType('analyst')"
                    :class="{ 'bg-blue-600 text-white': selected === 'analyst', 'bg-gray-300 text-gray-700 dark:bg-gray-600 dark:text-gray-300': selected !== 'analyst' }"
                    class="focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Analyst
                </button>
                @auth
                <button type="button" wire:click="setAnalysisType('analyst_with_job_position')"
                    :class="{ 'bg-green-600 text-white': selected === 'analyst_with_job_position', 'bg-gray-300 text-gray-700 dark:bg-gray-600 dark:text-gray-300': selected !== 'analyst_with_job_position' }"
                    class="focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Analyst with Job Position
                </button>
                <button type="button" wire:click="setAnalysisType('analyst_with_job_description')"
                    :class="{ 'bg-purple-600 text-white': selected === 'analyst_with_job_description', 'bg-gray-300 text-gray-700 dark:bg-gray-600 dark:text-gray-300': selected !== 'analyst_with_job_description' }"
                    class="focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Analyst with Job Description
                </button>
                @endauth
            </div>
        </div>
        <form wire:submit.prevent="submitForm" enctype="multipart/form-data" class="max-w-lg md:max-w-full mx-auto">
            @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($analysisType === 'analyst_with_job_position')
            <div class="mb-4">
                <label for="job_position" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Job
                    Position</label>
                <input type="text" id="job_position" wire:model="jobPosition"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Enter job position" required>
            </div>
            @endif
            @if($analysisType === 'analyst_with_job_description')
            <div class="mb-4">
                <label for="job_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Job
                    Description</label>
                <textarea id="job_description" wire:model="jobDescription"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Enter job description" rows="4" required></textarea>
            </div>
            @endif

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_upload">Upload
                    PDF</label>
                <input wire:model="file"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    id="file_upload" type="file" accept=".pdf" required>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_upload_help">Please upload a PDF file
                    for
                    your application</p>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                    :disabled="buttonStatus === 'disabled'">
                    <span wire:loading.remove>Submit</span>
                    <span wire:loading wire:target="submitForm">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>