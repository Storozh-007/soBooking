<div class="min-h-[60vh] flex items-center justify-center">
    <div class="bg-white dark:bg-[#1a2c4e] p-8 rounded-xl shadow-xl border border-gray-200 dark:border-[#2a3c5e] w-full max-w-md">
        <h2 class="text-3xl font-bold text-[#0D1F3F] dark:text-white mb-6 text-center">Створити акаунт</h2>
        
        <form wire:submit="register" class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Повне ім'я</label>
                <input 
                    type="text" 
                    id="name" 
                    wire:model="name" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-[#2a3c5e] dark:bg-[#0D1F3F] dark:text-white focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent outline-none transition-all"
                    placeholder="Введіть ваше ім'я"
                >
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Електронна пошта</label>
                <input 
                    type="email" 
                    id="email" 
                    wire:model="email" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-[#2a3c5e] dark:bg-[#0D1F3F] dark:text-white focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent outline-none transition-all"
                    placeholder="Введіть вашу пошту"
                >
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Пароль</label>
                <input 
                    type="password" 
                    id="password" 
                    wire:model="password" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-[#2a3c5e] dark:bg-[#0D1F3F] dark:text-white focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent outline-none transition-all"
                    placeholder="Створіть пароль"
                >
                @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Підтвердіть пароль</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    wire:model="password_confirmation" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-[#2a3c5e] dark:bg-[#0D1F3F] dark:text-white focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent outline-none transition-all"
                    placeholder="Підтвердіть ваш пароль"
                >
            </div>

            <button 
                type="submit" 
                class="w-full py-3 bg-[#D4AF37] hover:bg-[#b39025] text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:translate-y-0"
            >
                Реєстрація
            </button>
        </form>
    </div>
</div>
