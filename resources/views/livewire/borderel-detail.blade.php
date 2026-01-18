<div class="min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] p-6 lg:p-8">
    <div class="max-w-4xl mx-auto">
        <a
            href="{{ route('events.index') }}"
            class="inline-flex items-center gap-2 text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] mb-6 transition-colors"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Events
        </a>

        @if ($loading)
            <div class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] p-6 lg:p-8">
                <div class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#f53003]"></div>
                    <span class="ml-3 text-[#706f6c] dark:text-[#A1A09A]">Loading borderel...</span>
                </div>
            </div>
        @elseif ($error)
            <div class="bg-[#fff2f2] dark:bg-[#1D0002] border border-red-200 dark:border-red-800 rounded-lg p-6">
                <p class="text-[#f53003] dark:text-[#FF4433]">{{ $error }}</p>
            </div>
        @else
            <h1 class="text-3xl font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                Borderel
            </h1>
            <p class="text-[#706f6c] dark:text-[#A1A09A] mb-8">
                Event report and statistics
            </p>

            <div class="flex flex-col gap-6">
                <div class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] p-6 lg:p-8">
                    <h2 class="text-xl font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-6">
                        Event Information
                    </h2>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Event Name</dt>
                            <dd class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">{{ $eventData['name'] ?? 'N/A' }}</dd>
                        </div>

                        @if (!empty($eventData['subtitle']))
                            <div>
                                <dt class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Subtitle</dt>
                                <dd class="text-[#1b1b18] dark:text-[#EDEDEC]">{{ $eventData['subtitle'] }}</dd>
                            </div>
                        @endif

                        <div>
                            <dt class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Start Date</dt>
                            <dd class="text-[#1b1b18] dark:text-[#EDEDEC]">
                                {{ $eventData['startts'] ?? 'N/A' }}
                            </dd>
                        </div>

                        @if (!empty($eventData['endts']))
                            <div>
                                <dt class="text-sm text-[#706f6c] dark:text-[#A1A09A]">End Date</dt>
                                <dd class="text-[#1b1b18] dark:text-[#EDEDEC]">
                                    {{ $eventData['endts'] }}
                                </dd>
                            </div>
                        @endif

                        @if (!empty($eventData['locationname']))
                            <div>
                                <dt class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Location</dt>
                                <dd class="text-[#1b1b18] dark:text-[#EDEDEC]">{{ $eventData['locationname'] }}</dd>
                            </div>
                        @endif

                        <div>
                            <dt class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Status</dt>
                            <dd>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $eventData['currentstatus']->color() }}">
                                    {{ $eventData['currentstatus']->label() ?? 'N/A' }}
                                </span>
                            </dd>
                        </div>

                        @if (!empty($eventData['code']))
                            <div>
                                <dt class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Event Code</dt>
                                <dd class="text-[#1b1b18] dark:text-[#EDEDEC] font-mono text-sm">{{ $eventData['code'] }}</dd>
                            </div>
                        @endif
                    </dl>

                    @if (!empty($eventData['description']))
                        <div class="mt-6 pt-6 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                            <dt class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-2">Description</dt>
                            <dd class="text-[#1b1b18] dark:text-[#EDEDEC]">{!! nl2br(e($eventData['description'])) !!}</dd>
                        </div>
                    @endif
                </div>

                <div class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] p-6 lg:p-8">
                    <h2 class="text-xl font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-6">
                        Sales by Price Type
                    </h2>

                    @if (count($sales) > 0)
                        @php
                            $totalQty = $totals['total_qty'] ?? 0;
                            $totalGross = $totals['total_gross'] ?? 0;
                            $totalCost = $totals['total_cost'] ?? 0;
                            $totalNet = $totals['total_net'] ?? 0;
                            $totalCostPercentage = $totals['total_cost_percentage'] ?? 0;
                        @endphp

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                                        <th class="text-left py-3 px-2 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">Price Type</th>
                                        <th class="text-right py-3 px-2 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">Qty Sold</th>
                                        <th class="text-right py-3 px-2 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">Gross</th>
                                        <th class="text-right py-3 px-2 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">Cost Percentage</th>
                                        <th class="text-right py-3 px-2 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">Total Cost</th>
                                        <th class="text-right py-3 px-2 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">Net</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $sale)
                                        <tr class="border-b border-[#e3e3e0] dark:border-[#3E3E3A] hover:bg-[#FDFDFC] dark:hover:bg-[#0a0a0a]">
                                            <td class="py-3 px-2 text-[#1b1b18] dark:text-[#EDEDEC]">{{ $sale['pricetype_name'] }}</td>
                                            <td class="py-3 px-2 text-right text-[#1b1b18] dark:text-[#EDEDEC]">{{ number_format($sale['qty_sold']) }}</td>
                                            <td class="py-3 px-2 text-right text-[#1b1b18] dark:text-[#EDEDEC]">{{ number_format($sale['gross'], 2) }}</td>
                                            <td class="py-3 px-2 text-right text-[#1b1b18] dark:text-[#EDEDEC]">{{ number_format($sale['cost_percentage'] * 100, 2) }}%</td>
                                            <td class="py-3 px-2 text-right text-red-600 dark:text-red-400">-{{ number_format($sale['cost'], 2) }}</td>
                                            <td class="py-3 px-2 text-right text-green-600 dark:text-green-400 font-medium">{{ number_format($sale['net'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-[#FDFDFC] dark:bg-[#0a0a0a] font-semibold">
                                        <td class="py-3 px-2 text-[#1b1b18] dark:text-[#EDEDEC]">Total</td>
                                        <td class="py-3 px-2 text-right text-[#1b1b18] dark:text-[#EDEDEC]">{{ number_format($totalQty) }}</td>
                                        <td class="py-3 px-2 text-right text-[#1b1b18] dark:text-[#EDEDEC]">{{ number_format($totalGross, 2) }}</td>
                                        <td class="py-3 px-2 text-right text-[#1b1b18] dark:text-[#EDEDEC]">{{ number_format($totalCostPercentage * 100, 2) }}%</td>
                                        <td class="py-3 px-2 text-right text-red-600 dark:text-red-400">-{{ number_format($totalCost, 2) }}</td>
                                        <td class="py-3 px-2 text-right text-green-600 dark:text-green-400">{{ number_format($totalNet, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- make the 3 items in the first row and 2 in the second row stretching the first row to the width of the container -->
                        <div class="grid grid-cols-6 md:grid-cols-6 gap-4 mt-6">
                            <div class="bg-[#FDFDFC] dark:bg-[#0a0a0a] rounded-lg p-4 border border-[#e3e3e0] dark:border-[#3E3E3A] col-span-2">
                                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Total Tickets Sold</p>
                                <p class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ number_format($totalQty) }}</p>
                            </div>

                            <div class="bg-[#FDFDFC] dark:bg-[#0a0a0a] rounded-lg p-4 border border-[#e3e3e0] dark:border-[#3E3E3A] col-span-2">
                                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Gross Revenue</p>
                                <p class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">EUR {{ number_format($totalGross, 2) }}</p>
                            </div>

                            <div class="bg-[#FDFDFC] dark:bg-[#0a0a0a] rounded-lg p-4 border border-[#e3e3e0] dark:border-[#3E3E3A] col-span-2">
                                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Total Cost Percentage</p>
                                <p class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ number_format($totalCostPercentage * 100, 2) }}%</p>
                            </div>

                            <div class="bg-[#FDFDFC] dark:bg-[#0a0a0a] rounded-lg p-4 border border-[#e3e3e0] dark:border-[#3E3E3A] col-span-3">
                                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Total Costs</p>
                                <p class="text-2xl font-bold text-red-600 dark:text-red-400">EUR {{ number_format($totalCost, 2) }}</p>
                            </div>

                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800 col-span-3">
                                <p class="text-sm text-green-600 dark:text-green-400">Net Revenue</p>
                                <p class="text-2xl font-bold text-green-700 dark:text-green-300">EUR {{ number_format($totalNet, 2) }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-[#706f6c] dark:text-[#A1A09A] text-center py-8">No sales data available.</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
