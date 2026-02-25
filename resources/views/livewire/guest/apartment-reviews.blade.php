<div class="mt-16">
    <h3 class="text-2xl font-bold text-[#0D1F3F] dark:text-white mb-8">Відгуки гостей</h3>

    <!-- List -->
    <div class="space-y-6 mb-12">
        @forelse($reviews as $review)
            <div class="bg-gray-50 dark:bg-[#1a2c4e] p-6 rounded-2xl border border-gray-100 dark:border-[#2a3c5e]">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-[#0D1F3F] text-white flex items-center justify-center font-bold">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-[#0D1F3F] dark:text-white">{{ $review->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex text-[#D4AF37]">
                        @for($i=1; $i<=5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 italic mb-4">"{{ $review->comment }}"</p>
                @if($review->image_url)
                    <img src="{{ $review->image_url }}" alt="Review photo" class="w-full max-w-md rounded-xl shadow-md cursor-pointer hover:opacity-95 transition-opacity">
                @endif
            </div>
        @empty
            <p class="text-gray-500 italic">Поки що немає відгуків. Поділіться своїм досвідом першим!</p>
        @endforelse
    </div>

    <!-- Form -->
    @auth
        <div class="bg-white dark:bg-[#1a2c4e] p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-[#2a3c5e]">
            <h4 class="text-lg font-bold text-[#0D1F3F] dark:text-white mb-6">Залишити відгук</h4>
            
            @if (session()->has('message'))
                <div class="mb-4 text-emerald-500 text-sm font-bold">{{ session('message') }}</div>
            @endif

            <form wire:submit="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Оцінка</label>
                    <div class="flex space-x-2">
                        @foreach([1, 2, 3, 4, 5] as $score)
                            <button type="button" wire:click="$set('rating', {{ $score }})" class="focus:outline-none transition-transform hover:scale-110">
                                <svg class="w-8 h-8 {{ $score <= $rating ? 'text-[#D4AF37] fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </button>
                        @endforeach
                    </div>
                    @error('rating') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="comment" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Коментар</label>
                    <textarea 
                        id="comment" 
                        wire:model="comment" 
                        rows="4" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#2a3c5e] dark:bg-[#0b1a36] dark:text-white focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent outline-none transition-all resize-none"
                        placeholder="Поділіться своїм досвідом..."
                    ></textarea>
                    @error('comment') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <button 
                    type="submit" 
                    class="px-8 py-3 bg-[#0D1F3F] hover:bg-[#1a3a6e] text-white font-bold rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5 active:translate-y-0"
                >
                    Надіслати відгук
                </button>
            </form>
        </div>
    @else
        <div class="bg-gray-100 dark:bg-[#1a2c4e] p-6 rounded-xl text-center">
            <p class="text-gray-600 dark:text-gray-400 mb-4">Будь ласка, увійдіть, щоб залишити відгук.</p>
            <a href="{{ route('login') }}" class="text-[#D4AF37] font-bold hover:underline">Увійти</a>
        </div>
    @endauth
</div>
