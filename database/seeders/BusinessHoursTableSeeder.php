<?php

namespace Database\Seeders;

use App\Models\Core\BusinessHour;
use App\Models\Core\Listing;
use Illuminate\Database\Seeder;

class BusinessHoursTableSeeder extends Seeder
{
    public function run()
    {
        $listings = Listing::all();

        foreach ($listings as $listing) {
            $days = [
                'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
            ];

            foreach ($days as $day) {
                $closed = $day === 'sunday' ? rand(0, 1) : rand(0, 5) === 0;

                BusinessHour::create([
                    'listing_id' => $listing->id,
                    'day' => $day,
                    'open_time' => $closed ? null : '08:00:00',
                    'close_time' => $closed ? null : '18:00:00',
                    'closed' => $closed,
                    'special_note' => $day === 'sunday' ? 'Horário especial' : null,
                ]);
            }
        }
    }
}
