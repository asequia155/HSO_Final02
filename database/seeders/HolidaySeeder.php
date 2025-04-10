<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Holiday;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startYear = 2025;
        $endYear = $startYear + 99; // 100 years from 2025

        // Fixed-date holidays
        $fixedHolidays = [
            ['name' => 'New Year’s Day', 'month' => 1, 'day' => 1],
            ['name' => 'Araw ng Kagitingan', 'month' => 4, 'day' => 9],
            ['name' => 'Labor Day', 'month' => 5, 'day' => 1],
            ['name' => 'Independence Day', 'month' => 6, 'day' => 12],
            ['name' => 'Bonifacio Day', 'month' => 11, 'day' => 30],
            ['name' => 'Christmas Day', 'month' => 12, 'day' => 25],
            ['name' => 'Rizal Day', 'month' => 12, 'day' => 30],
        ];

        // Fixed-date special holidays
        $specialHolidays = [
            ['name' => 'Chinese New Year', 'month' => 1, 'day' => 29],
            ['name' => 'EDSA People Power Revolution Anniversary', 'month' => 2, 'day' => 25],
            ['name' => 'Ninoy Aquino Day', 'month' => 8, 'day' => 21],
            ['name' => 'All Saints’ Day', 'month' => 11, 'day' => 1],
            ['name' => 'Feast of the Immaculate Conception of Mary', 'month' => 12, 'day' => 8],
            ['name' => 'Christmas Eve', 'month' => 12, 'day' => 24],
            ['name' => 'Last Day of the Year', 'month' => 12, 'day' => 31],
        ];


        // Insert holidays into the database for each year

        for ($year = $startYear; $year <= $endYear; $year++) {
            // Fixed-date holidays
            foreach ($fixedHolidays as $holiday) {
                Holiday::create([
                    'name' => $holiday['name'],
                    'date' => "$year-{$holiday['month']}-{$holiday['day']}",
                ]);
            }

            // Fixed-date special holidays
            foreach ($specialHolidays as $holiday) {
                Holiday::create([
                    'name' => $holiday['name'],
                    'date' => "$year-{$holiday['month']}-{$holiday['day']}",
                ]);
            }




        }
    }
}
