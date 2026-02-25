<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class GuestDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('uk_UA'); 
        $apartments = Apartment::all();
        
        if ($apartments->isEmpty()) {
            return;
        }

        // Create 30 random guests
        for ($i = 0; $i < 30; $i++) {
            $user = new User();
            $user->name = $faker->name;
            $user->email = $faker->unique()->safeEmail;
            $user->password = Hash::make('password');
            $user->role = 'guest';
            $user->email_verified_at = now();
            // Generate passport like АВ123456
            $user->passport_data = $faker->regexify('[А-Я]{2}[0-9]{6}');
            $user->save();

            // Create 1-3 bookings for each guest
            $numBookings = rand(1, 3);
            for ($b = 0; $b < $numBookings; $b++) {
                $apartment = $apartments->random();
                
                $scenario = rand(1, 10);
                
                if ($scenario <= 4) {
                    // Past booking
                    $start = Carbon::now()->subDays(rand(10, 60));
                    $end = clone $start;
                    $end->addDays(rand(1, 5));
                    $status = 'completed';
                } elseif ($scenario <= 7) {
                    // Future booking
                    $start = Carbon::now()->addDays(rand(2, 30));
                    $end = clone $start;
                    $end->addDays(rand(1, 5));
                    $status = 'confirmed';
                } else {
                    // Active (Currently checked in)
                    $start = Carbon::now()->subDays(rand(0, 3));
                    $end = clone $start;
                    $end->addDays(rand(1, 4));
                    $status = 'confirmed';
                }

                $nights = $start->diffInDays($end) ?: 1;
                $totalPrice = $nights * $apartment->price;

                Booking::create([
                    'user_id' => $user->id,
                    'apartment_id' => $apartment->id,
                    'start_date' => $start,
                    'end_date' => $end,
                    'total_price' => $totalPrice,
                    'status' => $status,
                    'phone' => $faker->phoneNumber,
                ]);
            }
        }
    }
}
