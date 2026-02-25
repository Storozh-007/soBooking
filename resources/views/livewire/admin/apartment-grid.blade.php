<div class="p-6 space-y-8">
    <!-- Quick Create -->
    <div class="bg-white dark:bg-[#1a2c4e] rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e] p-6">
        <h3 class="text-lg font-bold text-[#0D1F3F] dark:text-white mb-4">Додати новий номер</h3>
        <form wire:submit.prevent="createApartment" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="col-span-1">
                <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Назва</label>
                <input wire:model.defer="form.title" class="w-full mt-2 rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-3 py-2 bg-white dark:bg-[#0b1a36]" placeholder="Назва номеру">
                @error('form.title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="col-span-1">
                <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Ціна за ніч (USD)</label>
                <input type="number" wire:model.defer="form.price" class="w-full mt-2 rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-3 py-2 bg-white dark:bg-[#0b1a36]" placeholder="500">
                @error('form.price') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="col-span-1">
                <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Місткість</label>
                <input type="number" wire:model.defer="form.capacity" class="w-full mt-2 rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-3 py-2 bg-white dark:bg-[#0b1a36]" placeholder="2">
                @error('form.capacity') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="col-span-1">
                <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Клас номеру</label>
                <input type="text" wire:model.defer="form.room_class" class="w-full mt-2 rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-3 py-2 bg-white dark:bg-[#0b1a36]" placeholder="Стандарт, Люкс...">
                @error('form.room_class') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="col-span-1 md:col-span-2">
                <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Опис</label>
                <textarea wire:model.defer="form.description" rows="2" class="w-full mt-2 rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-3 py-2 bg-white dark:bg-[#0b1a36]" placeholder="Короткий опис"></textarea>
                @error('form.description') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="col-span-1 md:col-span-2">
                <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">URL головного зображення</label>
                <input wire:model.defer="form.image_url" class="w-full mt-2 rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-3 py-2 bg-white dark:bg-[#0b1a36]" placeholder="https://...">
                @error('form.image_url') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="col-span-1 md:col-span-2">
                <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">URL додаткових зображень (через кому)</label>
                <input wire:model.defer="form.extra_images" class="w-full mt-2 rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-3 py-2 bg-white dark:bg-[#0b1a36]" placeholder="https://img1, https://img2">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Статус</label>
                <select wire:model.defer="form.status" class="w-full mt-2 rounded-xl border border-gray-200 dark:border-[#2a3c5e] px-3 py-2 bg-white dark:bg-[#0b1a36]">
                    <option value="free">Вільний (Free)</option>
                    <option value="taken">Зайнятий (Taken)</option>
                    <option value="cleaning">Прибирання (Cleaning)</option>
                </select>
                @error('form.status') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-[#0D1F3F] text-white font-bold rounded-xl hover:bg-[#1a3a6e] transition-all">Створити</button>
            </div>
            @if (session()->has('created'))
                <p class="col-span-full text-emerald-500 text-sm font-semibold">{{ session('created') }}</p>
            @endif
        </form>
    </div>

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" wire:poll.5s>
        @foreach($apartments as $apartment)
            <div class="bg-white dark:bg-[#1a2c4e]/80 backdrop-blur-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100 dark:border-[#2a3c5e] overflow-hidden group">
                <div class="relative h-64 overflow-hidden">
                    <img 
                        src="{{ $apartment->image_url ?? 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=2070&auto=format&fit=crop' }}" 
                        onerror=\"this.src='https://images.unsplash.com/photo-1502005229766-3c6227c46d83?auto=format&fit=crop&w=1600&q=80';\" 
                        alt="{{ $apartment->title }}" 
                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-80"></div>
                    <div class="absolute top-4 right-4">
                        <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold rounded-full shadow-sm">
                            ${{ number_format($apartment->price / 100, 2) }}
                        </span>
                    </div>
                    <div class="absolute bottom-4 left-4 right-4">
                        <h3 class="text-xl font-bold text-white leading-tight drop-shadow-md">{{ $apartment->title }}</h3>
                        <p class="text-sm text-gray-200 mt-1 drop-shadow-md">{{ $apartment->room_class ?: 'Standard' }} • {{ $apartment->capacity }} {{ Str::plural('Гостей', $apartment->capacity) }}</p>
                    </div>
                </div>
                
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-6 line-clamp-2 leading-relaxed font-light">
                        {{ $apartment->description }}
                    </p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-white/10">
                        <div class="flex items-center space-x-2.5">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 
                                    {{ $apartment->status === 'free' ? 'bg-emerald-400' : '' }}
                                    {{ $apartment->status === 'taken' ? 'bg-rose-400' : '' }}
                                    {{ $apartment->status === 'cleaning' ? 'bg-amber-400' : '' }}
                                "></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 
                                    {{ $apartment->status === 'free' ? 'bg-emerald-500' : '' }}
                                    {{ $apartment->status === 'taken' ? 'bg-rose-500' : '' }}
                                    {{ $apartment->status === 'cleaning' ? 'bg-amber-500' : '' }}
                                "></span>
                            </span>
                            <span class="text-xs font-semibold tracking-wide uppercase text-gray-500 dark:text-gray-400">
                                {{ $apartment->status }}
                            </span>
                        </div>
                        
                        <button 
                            wire:click="toggleStatus({{ $apartment->id }})"
                            class="text-xs font-semibold text-[#D4AF37] hover:text-[#b39025] uppercase tracking-wider transition-colors focus:outline-none"
                        >
                            Оновити статус
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
