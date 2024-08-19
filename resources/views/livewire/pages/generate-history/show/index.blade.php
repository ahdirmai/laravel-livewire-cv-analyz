<div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
            Analysis Result
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
            Generated on {{ $generateHistory->created_at->format('Y-m-d H:i:s') }}
        </p>
    </div>
    <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:p-0">
        <dl class="sm:divide-y sm:divide-gray-200 dark:sm:divide-gray-700">
            @if($generateHistory->job_position)
            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Job Position
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                    {{ $generateHistory->job_position }}
                </dd>
            </div>
            @endif

            @if($generateHistory->job_description)
            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Job Description
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                    {{ $generateHistory->job_description }}
                </dd>
            </div>
            @endif
            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Analysis Type
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                    {{ strtoupper($generateHistory->analysis_type) }}
                </dd>
            </div>
            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Result
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                    <div class="mb-4">
                        <h4 class="font-semibold">{{ $result['name'] }}</h4>
                        <p class="mt-2">Overall Score: {{ $result['score'] }}</p>
                    </div>

                    @foreach($result['criteria-detail'] as $criteria)
                    <div class="mb-4">
                        <h4 class="font-semibold">{{ $criteria['criteria'] }}</h4>
                        <p class="mt-1">Score: {{ $criteria['score'] }}</p>
                        <p class="mt-1">{{ $criteria['description'] }}</p>
                    </div>
                    @endforeach
                </dd>
            </div>
            {{-- <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    CV File
                </dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                    <div class="embed-responsive aspect-w-16 aspect-h-9">
                        <embed src="{{ $generateHistory->cv->path }}" type="application/pdf" width="100%"
                            height="600px" />
                    </div>
                </dd>
            </div> --}}
        </dl>
    </div>
</div>