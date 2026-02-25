<div class="py-12 bg-gray-50 dark:bg-[#0b1a36]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="text-sm font-medium mb-8 text-gray-500 dark:text-gray-400">
            <a href="{{ route('guest.apartments') }}" class="hover:text-[#D4AF37]">Каталог</a>
            <span class="mx-2">/</span>
            <span class="text-[#0D1F3F] dark:text-white">{{ $apartment->title }}</span>
        </nav>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Left Column: Gallery & Details -->
            <div class="lg:col-span-2">
                <!-- Image Gallery (Bento Grid) -->
                <div class="grid grid-cols-4 grid-rows-2 gap-2 h-[450px] rounded-3xl overflow-hidden shadow-2xl mb-12">
                    @if($apartment->images->count() > 0)
                        <!-- Main Image -->
                        <div class="col-span-2 row-span-2 relative group cursor-pointer">
                            <img 
                                src="{{ $apartment->images->first()->image_url }}" 
                                alt="{{ $apartment->title }}" 
                                onerror=\"this.src='https://images.unsplash.com/photo-1502005229766-3c6227c46d83?auto=format&fit=crop&w=1600&q=80';\" 
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 bg-gray-200"
                            >
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                        </div>

                        <!-- Secondary Images -->
                        @foreach($apartment->images->skip(1)->take(4) as $image)
                            <div class="col-span-1 row-span-1 relative group cursor-pointer">
                                <img 
                                    src="{{ $image->image_url }}" 
                                    alt="Interior view" 
                                    onerror=\"this.src='https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1200&q=80';\" 
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 bg-gray-200"
                                >
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback Single Image -->
                        <div class="col-span-4 row-span-2 relative group">
                            <img 
                                src="{{ $apartment->image_url ?? 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=2070&auto=format&fit=crop' }}" 
                                alt="{{ $apartment->title }}" 
                                class="w-full h-full object-cover"
                            >
                        </div>
                    @endif
                </div>

                <!-- Title & Stats -->
                <div class="mb-8">
                    <h1 class="text-4xl md:text-5xl font-bold text-[#0D1F3F] dark:text-white mb-4">{{ $apartment->title }}</h1>
                    <div class="flex items-center space-x-6 text-sm font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> {{ $apartment->capacity }} Гостей</span>
                        <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg> 120м²</span>
                        <span class="flex items-center text-[#D4AF37]">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            4.92 (18 відгуків)
                        </span>
                    </div>
                </div>

                <!-- Description -->
                <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed text-lg">
                    <h3 class="text-2xl font-bold text-[#0D1F3F] dark:text-white mb-4">Про це житло</h3>
                    <p>{{ $apartment->description }}</p>
                    <p>Створені для комфорту та стилю, ці апартаменти пропонують першокласні зручності, серед яких швидкісний Wi-Fi, Smart TV, повністю обладнана кухня та розкішна мінікосметика. Ідеально підходить як для короткострокових, так і для тривалих поїздок.</p>
                </div>

                <!-- Amenities Mockup -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 py-8 border-y border-gray-100 dark:border-[#2a3c5e]">
                    <div class="flex items-center text-gray-600 dark:text-gray-400"><svg class="w-5 h-5 mr-2 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg> Швидкий Wi-Fi</div>
                    <div class="flex items-center text-gray-600 dark:text-gray-400"><svg class="w-5 h-5 mr-2 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg> Робоче місце</div>
                    <div class="flex items-center text-gray-600 dark:text-gray-400"><svg class="w-5 h-5 mr-2 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg> Кондиціонер</div>
                    <div class="flex items-center text-gray-600 dark:text-gray-400"><svg class="w-5 h-5 mr-2 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Smart TV</div>
                </div>

                <!-- Reviews Section -->
                <livewire:guest.apartment-reviews :apartment="$apartment" />
                
            </div>

            <!-- Right Column: Booking Card -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                     <livewire:guest.booking-form :apartment="$apartment" />
                </div>
            </div>
        </div>
    </div>
</div>
