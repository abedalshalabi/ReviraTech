<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Recent Activities
        </x-slot>

        <div class="space-y-3">
            @forelse($this->getActivities() as $activity)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @switch($activity->type)
                                @case('Product')
                                    bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @break
                                @case('News')
                                    bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @break
                                @case('User')
                                    bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @break
                                @case('Page View')
                                    bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                    @break
                                @default
                                    bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                            @endswitch
                        ">
                            {{ $activity->type }}
                        </span>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ Str::limit($activity->title, 50) }}
                            </p>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $activity->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <div class="text-center py-6">
                    <p class="text-gray-500 dark:text-gray-400">No recent activities found.</p>
                </div>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget>