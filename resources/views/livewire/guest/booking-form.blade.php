<div class="bg-white dark:bg-[#1a2c4e] rounded-2xl shadow-xl border border-gray-100 dark:border-[#2a3c5e] overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-[#0b1a36]/50">
        <div class="flex items-end justify-between">
            <div class="text-[#0D1F3F] dark:text-white">
                <span class="text-2xl font-bold">${{ number_format($apartment->price / 100, 0) }}</span>
                <span class="text-gray-500 dark:text-gray-400 text-sm">/ ніч</span>
            </div>
            <div class="flex items-center text-sm text-[#D4AF37] font-semibold">
                <svg class="w-4 h-4 mr-1 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                4.92 · 18 відгуків
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="p-6">
        @if (session()->has('message'))
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl p-3 mb-4 flex items-center">
                <svg class="w-5 h-5 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <div class="text-emerald-700 dark:text-emerald-300 text-sm font-medium">{{ session('message') }}</div>
            </div>
        @endif

        <form wire:submit="book" class="space-y-4">
            <div class="grid grid-cols-2 gap-2 border border-gray-200 dark:border-[#2a3c5e] rounded-xl overflow-hidden">
                <div class="p-3 border-r border-gray-200 dark:border-[#2a3c5e] hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                    <label for="startDate" class="block text-[10px] font-bold text-[#0D1F3F] dark:text-white uppercase tracking-wider mb-1">Заїзд</label>
                    <input 
                        type="date" 
                        id="startDate" 
                        wire:model.live="startDate" 
                        class="w-full p-0 border-none bg-transparent text-gray-700 dark:text-gray-300 text-sm focus:ring-0 cursor-pointer"
                    >
                </div>
                <div class="p-3 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                    <label for="endDate" class="block text-[10px] font-bold text-[#0D1F3F] dark:text-white uppercase tracking-wider mb-1">Виїзд</label>
                    <input 
                        type="date" 
                    <input 
                        type="date" 
                        id="endDate" 
                        wire:model.live="endDate" 
                        class="w-full p-0 border-none bg-transparent text-gray-700 dark:text-gray-300 text-sm focus:ring-0 cursor-pointer"
                    >
                </div>
            </div>

            <div class="border border-gray-200 dark:border-[#2a3c5e] rounded-xl overflow-hidden p-3 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                <label for="phone" class="block text-[10px] font-bold text-[#0D1F3F] dark:text-white uppercase tracking-wider mb-1">Номер телефону</label>
                <input 
                    type="tel" 
                    id="phone" 
                    wire:model="phone" 
                    class="w-full p-0 border-none bg-transparent text-gray-700 dark:text-gray-300 text-sm focus:ring-0"
                    placeholder="+1 234 567 8900"
                >
            </div>
            
            @if($errors->any())
                <div class="text-rose-500 text-xs">
                    @error('startDate') <p>{{ $message }}</p> @enderror
                    @error('endDate') <p>{{ $message }}</p> @enderror
                    @error('phone') <p>{{ $message }}</p> @enderror
                </div>
            @endif

            <button 
                type="submit" 
                class="w-full py-3.5 bg-gradient-to-r from-[#0D1F3F] to-[#1a3a6e] hover:from-[#1a3a6e] hover:to-[#0D1F3F] text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm"
            >
                Забронювати
            </button>
        </form>

        @if($this->startDate && $this->endDate)
            <div class="mt-6 space-y-3 pt-6 border-t border-gray-100 dark:border-white/5">
                <div class="flex justify-between text-gray-600 dark:text-gray-400 text-sm">
                    <span>${{ number_format($apartment->price / 100, 0) }} x {{ $this->totalPrice / $apartment->price }} ночей</span>
                    <span>${{ number_format($this->totalPrice / 100, 0) }}</span>
                </div>
                <div class="flex justify-between text-[#0D1F3F] dark:text-white font-bold text-lg pt-3 border-t border-gray-100 dark:border-white/5">
                    <span>Разом</span>
                    <span>${{ number_format($this->totalPrice / 100, 0) }}</span>
                </div>
            </div>
        @else
            <div class="mt-4 text-center">
                <p class="text-xs text-gray-400">Гроші поки не зніматимуться</p>
            </div>
        @endif
    </div>
</div>
