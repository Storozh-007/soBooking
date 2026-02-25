<div class="mb-12 space-y-8">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <h2 class="text-3xl font-bold text-[#0D1F3F] dark:text-white">Статистика</h2>
        <div class="flex items-center gap-3">
            <button 
                wire:click="exportRevenueCsv"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-[#1a2c4e] border border-gray-200 dark:border-[#2a3c5e] rounded-xl shadow-sm text-sm font-semibold hover:-translate-y-0.5 transition-all"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5 5 5-5M12 15V3m-7 8v6a2 2 0 002 2h10a2 2 0 002-2v-6"></path></svg>
                Експорт доходів у CSV
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-[#1a2c4e] p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e] flex items-center">
            <div class="p-4 rounded-xl bg-emerald-100 text-emerald-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Загальний дохід</p>
                <p class="text-2xl font-bold text-[#0D1F3F] dark:text-white">${{ number_format($totalRevenue / 100) }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-[#1a2c4e] p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e] flex items-center">
            <div class="p-4 rounded-xl bg-blue-100 text-blue-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Всього бронювань</p>
                <p class="text-2xl font-bold text-[#0D1F3F] dark:text-white">{{ $totalBookings }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-[#1a2c4e] p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e] flex items-center">
            <div class="p-4 rounded-xl bg-purple-100 text-purple-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 001 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Активні номери</p>
                <p class="text-2xl font-bold text-[#0D1F3F] dark:text-white">{{ $activeListings }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-[#1a2c4e] p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e] flex items-center">
            <div class="p-4 rounded-xl bg-amber-100 text-amber-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Унікальні гості</p>
                <p class="text-2xl font-bold text-[#0D1F3F] dark:text-white">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>

    <!-- Operational Snapshot -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-[#1a2c4e] p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e]">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-semibold text-gray-500">Дохід цього місяця</p>
                <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 text-emerald-600">МТД</span>
            </div>
            <p class="text-3xl font-bold text-[#0D1F3F] dark:text-white">${{ number_format($revenueThisMonth / 100, 0) }}</p>
            <p class="text-xs text-gray-500 mt-2">Середнє бронювання: ${{ number_format(($averageBookingValue ?? 0) / 100, 0) }}</p>
        </div>
        <div class="bg-white dark:bg-[#1a2c4e] p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e]">
            <p class="text-sm font-semibold text-gray-500 mb-3">Зайнятість</p>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-[#0D1F3F] dark:text-white">{{ $inventory['occupancy_rate'] }}%</p>
                    <p class="text-xs text-gray-500">Зайнято: {{ $inventory['taken'] }} / {{ $inventory['total'] }}</p>
                </div>
                <div class="h-16 w-16 rounded-full bg-gradient-to-br from-[#D4AF37] to-[#0D1F3F] flex items-center justify-center text-white font-bold shadow-inner">
                    {{ $inventory['available_rate'] }}%
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-[#1a2c4e] p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e]">
            <p class="text-sm font-semibold text-gray-500 mb-3">Номери</p>
            <div class="grid grid-cols-3 gap-2 text-center text-xs">
                <div class="p-3 rounded-xl bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200">
                    <p class="font-bold text-lg">{{ $inventory['free'] }}</p>
                    <p>Вільні</p>
                </div>
                <div class="p-3 rounded-xl bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-200">
                    <p class="font-bold text-lg">{{ $inventory['taken'] }}</p>
                    <p>Зайняті</p>
                </div>
                <div class="p-3 rounded-xl bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-200">
                    <p class="font-bold text-lg">{{ $inventory['cleaning'] }}</p>
                    <p>Прибирання</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <div class="bg-white dark:bg-[#1a2c4e] p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e]">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-[#0D1F3F] dark:text-white">Тенденція доходів</h3>
                <span class="text-xs text-gray-500">Останні 12 місяців</span>
            </div>
            <div class="relative h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-[#1a2c4e] p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e]">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-[#0D1F3F] dark:text-white">Тижневі бронювання</h3>
                <span class="text-xs text-gray-500">Останні 7 днів</span>
            </div>
            <div class="relative h-64">
                <canvas id="bookingsChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const chartConfig = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' } },
                    x: { grid: { display: false } }
                }
            };

            // Revenue Chart
            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: @json($chartData['months']),
                    datasets: [{
                        label: 'Revenue ($)',
                        data: @json($chartData['monthlyRevenue']),
                        borderColor: '#10B981', // Emerald 500
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10B981',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    },{
                        label: 'Bookings',
                        data: @json($chartData['monthlyBookings']),
                        borderColor: '#0D1F3F',
                        backgroundColor: 'rgba(13, 31, 63, 0.08)',
                        borderWidth: 2,
                        tension: 0.35,
                        yAxisID: 'y1',
                        pointRadius: 0
                    }]
                },
                options: {
                    ...chartConfig,
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                        y1: {
                            position: 'right',
                            beginAtZero: true,
                            grid: { display: false },
                            ticks: { color: '#0D1F3F' },
                        },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Bookings Chart
            new Chart(document.getElementById('bookingsChart'), {
                type: 'bar',
                data: {
                    labels: @json($chartData['days']),
                    datasets: [{
                        label: 'Bookings',
                        data: @json($chartData['dailyBookings']),
                        backgroundColor: '#D4AF37', // Gold
                        borderRadius: 6,
                        barThickness: 24
                    }]
                },
                options: chartConfig
            });
        });
    </script>


    <!-- Recent Activity & Top Apartments -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Bookings -->
        <div class="lg:col-span-2 bg-white dark:bg-[#1a2c4e] rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e] overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5">
                <h3 class="font-bold text-[#0D1F3F] dark:text-white">Останні бронювання</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                    <thead class="bg-gray-50 dark:bg-[#0b1a36] text-xs uppercase font-semibold text-gray-500">
                        <tr>
                            <th class="px-6 py-4">Гість</th>
                            <th class="px-6 py-4">Номер</th>
                            <th class="px-6 py-4">Статус</th>
                            <th class="px-6 py-4 text-right">Разом</th>
                            <th class="px-6 py-4 text-right">Дії</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @foreach($recentBookings as $booking)
                            <tr class="hover:bg-gray-50 dark:hover:bg-[#2a3c5e]/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-[#0D1F3F] dark:text-white">{{ $booking->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->phone }}</div>
                                </td>
                                <td class="px-6 py-4">{{ Str::limit($booking->apartment->title, 15) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-bold 
                                        {{ $booking->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ $booking->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $booking->status === 'rejected' ? 'bg-rose-100 text-rose-700' : '' }}
                                    ">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-[#0D1F3F] dark:text-white">
                                    ${{ number_format($booking->total_price / 100, 0) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($booking->status === 'pending')
                                        <div class="flex justify-end space-x-2">
                                            <button wire:click="updateBookingStatus({{ $booking->id }}, 'approved')" class="p-1 text-emerald-600 hover:bg-emerald-50 rounded transition-colors" title="Approve">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                            <button wire:click="updateBookingStatus({{ $booking->id }}, 'rejected')" class="p-1 text-rose-600 hover:bg-rose-50 rounded transition-colors" title="Reject">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Performing Apartments -->
        <div class="lg:col-span-1 bg-white dark:bg-[#1a2c4e] rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e] overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5">
                <h3 class="font-bold text-[#0D1F3F] dark:text-white">Найкращі номери</h3>
            </div>
            <div class="p-4 space-y-4">
                @foreach($topApartments as $apartment)
                    <div class="flex items-center space-x-4">
                        <img 
                            src="{{ $apartment->image_url ?? 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=2070&auto=format&fit=crop' }}" 
                            class="w-12 h-12 rounded-lg object-cover shadow-sm"
                            alt="{{ $apartment->title }}"
                        >
                        <div class="flex-grow min-w-0">
                            <p class="text-sm font-bold text-[#0D1F3F] dark:text-white truncate">{{ $apartment->title }}</p>
                            <p class="text-xs text-gray-500">{{ $apartment->bookings_count ?? 0 }} бронювань</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-[#D4AF37]">${{ number_format(($apartment->bookings_sum_total_price ?? 0) / 100, 0) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
