<div class="p-6 max-w-6xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-bold text-[#0D1F3F] dark:text-white">Операції виїзду</h2>
        @if(!$actionView)
        <div class="w-1/3">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Пошук гостя або номеру..." 
                class="w-full rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-4 py-2 bg-white dark:bg-[#0b1a36]"
            >
        </div>
        @endif
    </div>

    @if(!$actionView)
        <!-- Active Bookings List -->
        <div class="bg-white dark:bg-[#1a2c4e] rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-[#0b1a36] border-b border-gray-200 dark:border-[#2a3c5e]">
                            <th class="py-4 px-6 font-semibold text-gray-600 dark:text-gray-300">Номер</th>
                            <th class="py-4 px-6 font-semibold text-gray-600 dark:text-gray-300">Гість</th>
                            <th class="py-4 px-6 font-semibold text-gray-600 dark:text-gray-300">Очікуваний виїзд</th>
                            <th class="py-4 px-6 font-semibold text-gray-600 dark:text-gray-300 text-right">Дії</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-[#2a3c5e]">
                        @forelse($activeBookings as $booking)
                            @php
                                $isDue = \Carbon\Carbon::parse($booking->end_date)->isToday() || \Carbon\Carbon::parse($booking->end_date)->isPast();
                            @endphp
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-[#0f2042] transition-colors {{ $isDue ? 'bg-red-50/30' : '' }}">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-[#0D1F3F] dark:text-white">{{ $booking->apartment->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->apartment->room_class ?: 'Стандарт' }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium dark:text-gray-200">{{ $booking->user->name }}</div>
                                    <div class="text-sm text-gray-500 font-mono">{{ $booking->user->passport_data ?: 'Немає паспорта' }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium {{ $isDue ? 'text-rose-500 font-bold' : 'text-gray-700 dark:text-gray-300' }}">
                                        {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                                        @if($isDue) <span class="ml-2 text-xs uppercase tracking-wider bg-rose-100 text-rose-700 px-2 py-0.5 rounded-full">Сьогодні</span> @endif
                                    </div>
                                    <div class="text-sm text-gray-400">Заїзд: {{ \Carbon\Carbon::parse($booking->start_date)->format('M d') }}</div>
                                </td>
                                <td class="py-4 px-6 text-right space-x-2">
                                    <button wire:click="selectAction('checkout', {{ $booking->id }})" class="px-3 py-1.5 bg-[#0D1F3F] text-white text-sm font-bold rounded-lg hover:bg-[#1a3a6e] transition-colors">Вибрати</button>
                                    <button wire:click="selectAction('delay', {{ $booking->id }})" class="px-3 py-1.5 border border-[#D4AF37] text-[#D4AF37] text-sm font-bold rounded-lg hover:bg-[#D4AF37] hover:text-white transition-colors">Затримка</button>
                                    @if(!$isDue)
                                    <button wire:click="selectAction('early_checkout', {{ $booking->id }})" class="px-3 py-1.5 text-rose-500 text-sm font-bold hover:underline transition-colors">Достроково</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                    Активних бронювань не знайдено.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @elseif($actionView === 'checkout')
        <!-- Standard Check Out Confirmation -->
        <div class="bg-white dark:bg-[#1a2c4e] rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e] p-8 max-w-2xl mx-auto text-center">
            <div class="w-16 h-16 bg-blue-100 text-[#0D1F3F] rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-[#0D1F3F] dark:text-white mb-2">Оформити стандартний виїзд?</h3>
            <p class="text-gray-500 mb-6">Гість <b>{{ $selectedBooking->user->name }}</b> звільняє номер <b>{{ $selectedBooking->apartment->title }}</b>.</p>
            
            <div class="flex justify-center space-x-4">
                <button wire:click="cancelAction" class="px-6 py-2 border border-gray-300 text-gray-600 rounded-xl hover:bg-gray-50 font-bold transition-colors">Скасувати</button>
                <button wire:click="processCheckout" class="px-6 py-2 bg-[#0D1F3F] text-white rounded-xl hover:bg-[#1a3a6e] font-bold transition-colors">Підтвердити та звільнити номер</button>
            </div>
        </div>

    @elseif($actionView === 'delay')
        <!-- Delay / Extension -->
        <div class="bg-white dark:bg-[#1a2c4e] rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e] p-8 max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-[#0D1F3F] dark:text-white">Продовжити проживання (Затримка)</h3>
                <button wire:click="cancelAction" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <form wire:submit.prevent="processDelay" class="space-y-6">
                <div class="p-4 bg-gray-50 dark:bg-[#0b1a36] rounded-xl border border-gray-200 dark:border-[#2a3c5e]">
                    <p class="text-sm text-gray-500 mb-2">Поточний виїзд: <b>{{ \Carbon\Carbon::parse($selectedBooking->end_date)->format('M d, Y') }}</b></p>
                    <p class="text-sm text-gray-500">Ціна номеру: <b>${{ number_format($selectedBooking->apartment->price / 100, 2) }} / ніч</b></p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Нова дата виїзду</label>
                    <input type="date" wire:model.defer="newEndDate" class="w-full mt-2 rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-4 py-3 bg-white dark:bg-[#0b1a36]">
                    @error('newEndDate') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-3 bg-[#D4AF37] text-[#0D1F3F] font-bold rounded-xl hover:bg-[#b39025] transition-all">Оформити продовження та оплатити</button>
                </div>
            </form>
        </div>

    @elseif($actionView === 'early_checkout')
        <!-- Early Check out -->
        <div class="bg-white dark:bg-[#1a2c4e] rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e] p-8 max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-rose-500">Достроковий виїзд</h3>
                <button wire:click="cancelAction" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <form wire:submit.prevent="processEarlyCheckout" class="space-y-6">
                <div class="p-4 bg-rose-50 rounded-xl border border-rose-100">
                    <p class="text-sm text-rose-700 mb-2">Початкова дата закінчення: <b>{{ \Carbon\Carbon::parse($selectedBooking->end_date)->format('M d, Y') }}</b></p>
                    <p class="text-sm text-rose-700">Дні дострокового виїзду будуть відшкодовані по <b>${{ number_format($selectedBooking->apartment->price / 100, 2) }} / ніч</b>.</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Фактична дата виїзду (Сьогодні або раніше)</label>
                    <input type="date" wire:model.defer="newEndDate" class="w-full mt-2 rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-4 py-3 bg-white dark:bg-[#0b1a36]">
                    @error('newEndDate') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-3 bg-rose-500 text-white font-bold rounded-xl hover:bg-rose-600 transition-all">Оформити достроковий виїзд</button>
                </div>
            </form>
        </div>

    @elseif($actionView === 'receipt')
        <!-- Action Receipt -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden" id="printable-receipt">
            <div class="bg-{{ $receiptType === 'refund' ? 'rose-600' : ($receiptType === 'delay' ? 'amber-500' : '[#0D1F3F]') }} p-8 text-white flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold tracking-wider {{ $receiptType === 'delay' ? 'text-white' : 'text-[#D4AF37]' }}">SOBOOKING</h2>
                    <p class="text-sm opacity-90 mt-1 font-semibold uppercase">{{ $receipt['title'] }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-mono opacity-90">Реф №{{ str_pad($receipt['booking_id'], 6, '0', STR_PAD_LEFT) }}-{{ strtoupper(substr($receiptType, 0, 3)) }}</p>
                    <p class="text-sm opacity-90">{{ \Carbon\Carbon::parse($receipt['date_issued'])->format('M d, Y h:i A') }}</p>
                </div>
            </div>
            
            <div class="p-8 text-gray-800">
                <div class="grid grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-200">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold mb-1">ГІСТЬ</p>
                        <p class="font-bold text-lg">{{ $receipt['guest_name'] }}</p>
                        <p class="text-sm mt-1">Номер: {{ $receipt['room_title'] }} ({{ $receipt['room_class'] }})</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 font-semibold mb-1">ДАТИ</p>
                        <p class="text-sm">Початково: {{ \Carbon\Carbon::parse($receipt['original_start'])->format('M d') }} - {{ \Carbon\Carbon::parse($selectedBooking->end_date ?? $receipt['new_end'])->format('M d') }}</p>
                        <p class="font-bold text-lg">Кінцева дата: {{ \Carbon\Carbon::parse($receipt['new_end'])->format('M d, Y') }}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 mb-8 flex justify-between items-center">
                    <div>
                        <h4 class="font-bold text-lg">
                            @if($receiptType === 'delay')
                                Потрібна додаткова оплата
                            @elseif($receiptType === 'refund')
                                Відшкодування гостю
                            @else
                                Баланс погашено
                            @endif
                        </h4>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-bold {{ $receiptType === 'refund' ? 'text-rose-500' : ($receiptType === 'delay' ? 'text-amber-500' : 'text-emerald-500') }}">
                            ${{ number_format($receipt['difference_amount'], 2) }}
                        </span>
                    </div>
                </div>

                <div class="text-right text-sm text-gray-500">
                    Загальна вартість проживання: ${{ number_format($receipt['total_amount'], 2) }}
                </div>
            </div>
            
            <div class="bg-gray-50 p-6 flex justify-between items-center border-t border-gray-200">
                <button wire:click="cancelAction" class="text-[#0D1F3F] font-bold hover:underline">Повернутися до списку</button>
                <button onclick="window.print()" class="px-6 py-2 bg-[#0D1F3F] text-white font-bold rounded-lg hover:bg-[#1a3a6e] transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Друк квитанції
                </button>
            </div>
        </div>
        
        <style>
            @media print {
                body * { visibility: hidden; }
                #printable-receipt, #printable-receipt * { visibility: visible; }
                #printable-receipt { position: absolute; left: 0; top: 0; width: 100%; border: none; box-shadow: none; }
                button { display: none !important; }
            }
        </style>
    @endif
</div>
