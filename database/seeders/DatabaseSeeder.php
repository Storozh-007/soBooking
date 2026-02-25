<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        User::query()->delete();
        Apartment::query()->delete();

        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@sofa.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Guest User
        User::create([
            'name' => 'Guest User',
            'email' => 'guest@sofa.com',
            'password' => Hash::make('password'),
            'role' => 'guest',
            'email_verified_at' => now(),
        ]);

        // Apartments with Real Images
        $apartments = [
            [
                'title' => 'Odesa Pearl: Sea View Penthouse',
                'description' => 'A stunning penthouse in the heart of Arkadia, Odesa. Enjoy the Black Sea breeze from your private terrace. Features floor-to-ceiling windows and Italian furniture.',
                'image_url' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=2070&auto=format&fit=crop', // Luxury hotel vibe
                'price' => 50000,
                'capacity' => 2,
                'status' => 'free',
            ],
            [
                'title' => 'The Royal Ritz Suite',
                'description' => 'Experience world-class luxury in this expansive suite. Marble bathrooms, gold accents, and a personal butler service make this the ultimate getaway.',
                'image_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1974&auto=format&fit=crop', // Dark rich interior
                'price' => 85000,
                'capacity' => 2,
                'status' => 'free',
            ],
            [
                'title' => 'Modern Minimalist Loft',
                'description' => 'Designed for the modern traveler. A clean, Apple-esque aesthetic with smart home integration, polished concrete floors, and panoramic city views.',
                'image_url' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?q=80&w=1980&auto=format&fit=crop', // Clean minimalist apartment
                'price' => 25000,
                'capacity' => 2,
                'status' => 'cleaning',
            ],
            [
                'title' => 'Grand Family Villa',
                'description' => 'A spacious retreat for the whole family. Includes a private pool, garden, and three master bedrooms. Located in a quiet, exclusive neighborhood.',
                'image_url' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?q=80&w=2071&auto=format&fit=crop', // Modern villa
                'price' => 45000,
                'capacity' => 6,
                'status' => 'taken',
            ],
             [
                'title' => 'Skyline Executive Apartment',
                'description' => 'High above the city noise. This executive apartment offers a dedicated workspace, lightning-fast fiber internet, and a Nespresso machine.',
                'image_url' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=2070&auto=format&fit=crop', // Bright apartment
                'price' => 18000,
                'capacity' => 2,
                'status' => 'free',
            ],
            [
                'title' => 'Historic Center Boutique Room',
                'description' => 'Step back in time with modern comforts. Located in the historic center, walking distance to the Opera House.',
                'image_url' => 'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?q=80&w=2070&auto=format&fit=crop', // Boutique bedroom
                'price' => 12000,
                'capacity' => 2,
                'status' => 'free',
            ],
        ];

        foreach ($apartments as $apt) {
            Apartment::create($apt);
        }

        $this->call(ReviewSeeder::class);
        $this->call(ApartmentImageSeeder::class);
        $this->call(GuestDataSeeder::class);
    }
}
