<div class="min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] p-6 lg:p-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] p-6 lg:p-8">
            <h1 class="text-2xl font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-6">
                Select an Event
            </h1>

            @if ($loading)
                <div class="flex items-center justify-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#f53003]"></div>
                    <span class="ml-3 text-[#706f6c] dark:text-[#A1A09A]">Loading events...</span>
                </div>
            @elseif ($error)
                <div class="bg-[#fff2f2] dark:bg-[#1D0002] border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
                    <p class="text-[#f53003] dark:text-[#FF4433]">{{ $error }}</p>
                </div>
            @else
                <form wire:submit="viewBorderel">
                    <div class="mb-6">
                        <label for="event" class="block text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] mb-2">
                            Choose an event to view its borderel
                        </label>
                        <select
                            wire:model.live="selectedEventId"
                            id="event"
                            class="w-full px-4 py-3 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] focus:outline-none focus:ring-2 focus:ring-[#f53003] focus:border-transparent transition-colors"
                        >
                            <option value="">-- Select an event --</option>
                            @foreach ($events as $event)
                                <option value="{{ $event['id'] }}">
                                    {{ $event['name'] }}
                                    @if ($event['startts'])
                                        ({{ $event['startts'] }})
                                    @endif
                                    @if ($event['locationname'])
                                        - {{ $event['locationname'] }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button
                        type="submit"
                        @if (!$selectedEventId) disabled @endif
                        class="w-full px-5 py-3 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-lg font-medium transition-colors hover:bg-black dark:hover:bg-white disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        View Borderel
                    </button>
                </form>

                @if (count($events) === 0)
                    <p class="text-center text-[#706f6c] dark:text-[#A1A09A] mt-4">
                        No events found.
                    </p>
                @endif
            @endif
        </div>
    </div>
</div>
