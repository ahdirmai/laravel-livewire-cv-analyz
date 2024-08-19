<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-3">
    <div class="mt-3">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Result</h3>
        @if($analysisResult)
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300">{{ $analysisResult['name'] }}</h4>
                <span
                    class="text-2xl font-bold {{ $analysisResult['score'] >= 70 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $analysisResult['score'] }}/100
                </span>
            </div>
            @foreach($analysisResult['criteria-detail'] as $criteria)
            <div class="border-t pt-4">
                <h5 class="text-md font-medium text-gray-600 dark:text-gray-400 mb-2">{{ $criteria['criteria'] }}</h5>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Score:</span>
                    <span
                        class="text-sm font-medium {{ $criteria['score'] >= 70 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $criteria['score'] }}/100
                    </span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $criteria['description'] }}</p>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-600 dark:text-gray-400">No analysis result available.</p>
        @endif
    </div>
</div>