<x-layouts.app>
    <div class="py-16 bg-gray-50 dark:bg-[#0b1a36]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-[#0D1F3F] dark:text-white mb-4 tracking-tight">
                    Ексклюзивні Колекції
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto font-light leading-relaxed">
                    Відкрийте для себе нашу ретельно відібрану колекцію преміальних апартаментів, створених для найвимогливіших мандрівників.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($apartments as $apartment)
                    <div class="group bg-white dark:bg-[#1a2c4e] rounded-3xl shadow-[0_20px_50px_rgba(8,_112,_184,_0.07)] hover:shadow-[0_20px_50px_rgba(8,_112,_184,_0.15)] transition-all duration-500 overflow-hidden flex flex-col h-full border border-gray-100 dark:border-white/5">
                        <div class="relative h-72 overflow-hidden">
                            <img 
                                src="{{ $apartment->image_url ?? 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=2070&auto=format&fit=crop' }}" 
                                alt="{{ $apartment->title }}" 
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000 ease-in-out"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0D1F3F]/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <div class="absolute top-6 right-6 z-10">
                                <span class="px-4 py-2 bg-white/90 backdrop-blur-md text-[#0D1F3F] text-sm font-bold rounded-full shadow-lg">
                                    ${{ number_format($apartment->price / 100, 0) }} <span class="font-normal text-xs text-gray-500">/ ніч</span>
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="text-2xl font-bold text-[#0D1F3F] dark:text-white mb-3 tracking-tight group-hover:text-[#D4AF37] transition-colors">
                                {{ $apartment->title }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-6 line-clamp-3 leading-relaxed font-light flex-grow">
                                {{ $apartment->description }}
                            </p>
                            
                            <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-100 dark:border-white/5">
                                <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm font-medium">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    {{ $apartment->capacity }} Гостей
                                </div>
                                
                                <a href="{{ route('guest.apartments.show', $apartment) }}" class="inline-flex items-center text-[#D4AF37] font-semibold hover:text-[#b39025] transition-colors group/link">
                                    Переглянути деталі
                                    <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
