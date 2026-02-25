<div class="p-6 space-y-8" 
    x-data="{ showModal: false }" 
    @open-guest-modal.window="showModal = true" 
    @close-guest-modal.window="showModal = false">
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-bold text-[#0D1F3F] dark:text-white">Список гостей</h2>
        <div class="w-1/3">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Пошук за ім'ям, email, телефоном, паспортом або номером..." 
                class="w-full rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-4 py-2 bg-white dark:bg-[#0b1a36]"
            >
        </div>
    </div>

    <div class="bg-white dark:bg-[#1a2c4e] rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#0b1a36] border-b border-gray-200 dark:border-[#2a3c5e]">
                        <th class="py-4 px-6 font-semibold text-gray-600 dark:text-gray-300">Дані гостя</th>
                        <th class="py-4 px-6 font-semibold text-gray-600 dark:text-gray-300">Паспортні дані</th>
                        <th class="py-4 px-6 font-semibold text-gray-600 dark:text-gray-300">Останнє бронювання</th>
                        <th class="py-4 px-6 font-semibold text-gray-600 dark:text-gray-300">Заїзд / Виїзд</th>
                        <th class="py-4 px-6 font-semibold text-gray-600 dark:text-gray-300 text-right">Дії</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#2a3c5e]">
                    @forelse($guests as $guest)
                        @php
                            $latestBooking = $guest->bookings->first();
                        @endphp
                        <tr wire:key="guest-row-{{ $guest->id }}" class="hover:bg-gray-50/50 dark:hover:bg-[#0f2042] transition-colors">
                            <td class="py-4 px-6">
                                <div class="font-bold text-[#0D1F3F] dark:text-white">{{ $guest->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $guest->email }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 font-mono">{{ $latestBooking?->phone ?? 'N/A' }}</div>
                            </td>
                            <td class="py-4 px-6 font-mono text-sm">
                                {{ $guest->passport_data ?: 'Не вказано' }}
                            </td>
                            <td class="py-4 px-6">
                                @if($latestBooking)
                                    <div class="font-semibold text-[#D4AF37]">{{ $latestBooking->apartment->title }}</div>
                                    <div class="text-xs text-gray-500 uppercase tracking-widest mt-1">{{ $latestBooking->status }}</div>
                                @else
                                    <span class="text-gray-400 italic">Немає бронювань</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-sm">
                                @if($latestBooking)
                                    <div><span class="text-gray-500 mr-2">Заїзд:</span> {{ $latestBooking->start_date->format('M d, Y') }}</div>
                                    <div><span class="text-gray-500 mr-2">Виїзд:</span> <span class="{{ $latestBooking->end_date->isPast() ? 'text-gray-400' : 'font-bold text-emerald-500' }}">{{ $latestBooking->end_date->format('M d, Y') }}</span></div>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button type="button" wire:key="btn-guest-{{ $guest->id }}" wire:click="viewGuest({{ $guest->id }})" class="text-[#D4AF37] hover:bg-[#D4AF37] hover:bg-opacity-10 px-3 py-1.5 rounded-lg font-bold transition-colors">Деталі</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                Гостей не знайдено. <a href="{{ route('admin.checkin') }}" class="text-[#D4AF37] hover:underline">Зареєструвати гостя</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-[#2a3c5e]">
            {{ $guests->links() }}
        </div>
    </div>
    <!-- Modal Container (No teleport to preserve Livewire DOM diff stability) -->
    <div x-show="showModal" style="display: none;" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm">
        
        <div @click.away="$wire.closeGuest()" class="bg-white dark:bg-[#1a2c4e] rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden flex flex-col transform transition-all m-4 relative">
            
            @if($selectedGuest)
                <div class="p-6 border-b border-gray-100 dark:border-[#2a3c5e] flex justify-between items-center bg-gray-50 dark:bg-[#0b1a36]">
                    <h3 class="text-2xl font-bold text-[#0D1F3F] dark:text-white">
                        Профіль: {{ $selectedGuest->name }}
                    </h3>
                    <div class="flex items-center space-x-2">
                        @if($isEditing)
                            <button type="button" wire:click="saveGuest" class="text-white bg-[#D4AF37] hover:bg-[#b39025] px-4 py-2 rounded-xl transition-colors font-bold text-sm">
                                Зберегти
                            </button>
                            <button type="button" wire:click="toggleEdit" class="text-gray-600 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 px-4 py-2 rounded-xl transition-colors font-bold text-sm">
                                Скасувати
                            </button>
                        @else
                            <button type="button" wire:click="toggleEdit" class="text-[#D4AF37] bg-white border border-[#D4AF37] hover:bg-[#D4AF37] hover:text-white dark:bg-transparent dark:hover:bg-[#D4AF37] px-4 py-2 rounded-xl transition-colors font-bold text-sm">
                                Редагувати
                            </button>
                        @endif
                        <button type="button" wire:click="closeGuest" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors bg-white dark:bg-[#1a2c4e] shadow-sm rounded-full p-2 ml-2 border border-gray-200 dark:border-[#2a3c5e]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                @if(session()->has('message'))
                    <div class="bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 px-6 py-3 border-b border-emerald-100 dark:border-emerald-800 text-sm font-semibold flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('message') }}
                    </div>
                @endif
                
                <div class="p-6 overflow-y-auto space-y-6 flex-grow">
                    <div>
                        @if($isEditing)
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-sm text-gray-500 dark:text-gray-400">ПІБ гостя</label>
                                    <input type="text" wire:model="editName" class="w-full rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-4 py-2 bg-white dark:bg-[#0b1a36] text-gray-900 dark:text-white">
                                    @error('editName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Email</label>
                                    <input type="email" wire:model="editEmail" class="w-full rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-4 py-2 bg-white dark:bg-[#0b1a36] text-gray-900 dark:text-white">
                                    @error('editEmail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Номер телефону</label>
                                    <input type="text" wire:model="editPhone" class="w-full rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-4 py-2 bg-white dark:bg-[#0b1a36] text-gray-900 dark:text-white">
                                    <p class="text-xs text-gray-400 mt-1">Оновлює телефон у поточних бронюваннях</p>
                                    @error('editPhone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm text-gray-500 dark:text-gray-400">Паспортні дані</label>
                                    <input type="text" wire:model="editPassport" class="w-full rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-4 py-2 bg-white dark:bg-[#0b1a36] text-gray-900 dark:text-white font-mono">
                                    @error('editPassport') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @else
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 dark:bg-[#0b1a36] p-4 rounded-xl border border-gray-100 dark:border-[#2a3c5e]">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Email</p>
                                    <p class="font-bold dark:text-white">{{ $selectedGuest->email }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-[#0b1a36] p-4 rounded-xl border border-gray-100 dark:border-[#2a3c5e]">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Паспортні дані</p>
                                    <p class="font-bold font-mono dark:text-white">{{ $selectedGuest->passport_data ?: 'Не вказано' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div>
                        <h4 class="text-xl font-bold text-[#0D1F3F] dark:text-white mb-4">Історія бронювань ({{ $selectedGuest->bookings->count() }})</h4>
                        @if($selectedGuest->bookings->count() > 0)
                            <div class="space-y-4">
                                @foreach($selectedGuest->bookings as $booking)
                                    <div wire:key="booking-{{ $booking->id }}" class="border border-gray-200 dark:border-[#2a3c5e] rounded-xl p-4 flex justify-between items-center bg-white dark:bg-[#1a2c4e]">
                                        <div>
                                            <div class="font-bold text-[#D4AF37]">{{ $booking->apartment?->title ?? 'Апартаменти недоступні' }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $booking->start_date->format('M d, Y') }} — {{ $booking->end_date->format('M d, Y') }} 
                                                ({{ $booking->start_date->diffInDays($booking->end_date) ?: 1 }} ночей)
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs font-bold uppercase tracking-wider px-2 py-1 rounded-full inline-block
                                                {{ $booking->status === 'completed' ? 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' : 
                                                   ($booking->status === 'confirmed' || $booking->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700') }}">
                                                {{ $booking->status }}
                                            </div>
                                            <div class="font-bold text-gray-900 dark:text-white mt-1">
                                                ${{ number_format($booking->total_price / 100, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 outline-dashed outline-1 outline-gray-300 p-8 rounded-xl text-center">Немає історії бронювань.</p>
                        @endif
                    </div>
                </div>
            @else
                <div class="p-12 text-center text-gray-500">Завантаження...</div>
            @endif
        </div>
    </div>
</div>
