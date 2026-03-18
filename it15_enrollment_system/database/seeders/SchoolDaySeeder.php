<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolDay;
use Carbon\Carbon;

class SchoolDaySeeder extends Seeder
{
    /**
     * Seed academic calendar with school days, holidays, and events
     * Academic Year 2026
     */
    public function run()
    {
        $academicYear = '2026-2027';
        
        // School day data with holidays and events
        $schoolDays = [];

        // Define holidays for Philippine academic calendar 2026-2027
        $holidays = [
            // New Year's holidays
            ['date' => '2026-01-01', 'type' => 'holiday', 'description' => 'New Year\'s Day'],
            ['date' => '2026-01-02', 'type' => 'holiday', 'description' => 'New Year Holiday'],
            
            // Chinese New Year
            ['date' => '2026-02-17', 'type' => 'holiday', 'description' => 'Chinese New Year'],
            ['date' => '2026-02-18', 'type' => 'holiday', 'description' => 'Chinese New Year Holiday'],
            
            // EDSA Revolution Day
            ['date' => '2026-02-25', 'type' => 'holiday', 'description' => 'EDSA Revolution Anniversary'],
            
            // Holy Week
            ['date' => '2026-04-09', 'type' => 'holiday', 'description' => 'Maundy Thursday'],
            ['date' => '2026-04-10', 'type' => 'holiday', 'description' => 'Good Friday'],
            ['date' => '2026-04-11', 'type' => 'holiday', 'description' => 'Black Saturday'],
            ['date' => '2026-04-12', 'type' => 'holiday', 'description' => 'Easter Sunday'],
            
            // Araw ng Kagitingan
            ['date' => '2026-04-09', 'type' => 'holiday', 'description' => 'Araw ng Kagitingan'],
            
            // Labor Day
            ['date' => '2026-05-01', 'type' => 'holiday', 'description' => 'Labor Day'],
            
            // Independence Day
            ['date' => '2026-06-12', 'type' => 'event', 'description' => 'Independence Day'],
            
            // Eid al-Fitr
            ['date' => '2026-05-24', 'type' => 'holiday', 'description' => 'Eid\'l Fitr'],
            ['date' => '2026-05-25', 'type' => 'holiday', 'description' => 'Eid\'l Fitr Holiday'],
            
            // Araw ng Kagitingan
            ['date' => '2026-04-09', 'type' => 'holiday', 'description' => 'Day of Valor'],
            
            // Founding Anniversary of Ateneo
            ['date' => '2026-06-16', 'type' => 'event', 'description' => 'Founding Anniversary'],
            
            // Eid al-Adha
            ['date' => '2026-07-07', 'type' => 'holiday', 'description' => 'Eid\'l Adha'],
            
            // National Heroes Day
            ['date' => '2026-08-21', 'type' => 'holiday', 'description' => 'National Heroes Day'],
            
            // Feast of San Luis Rey de Francia
            ['date' => '2026-08-25', 'type' => 'holiday', 'description' => 'Feast of San Luis Rey de Francia'],
            
            // All Saints Day
            ['date' => '2026-11-01', 'type' => 'holiday', 'description' => 'All Saints Day'],
            
            // All Souls Day
            ['date' => '2026-11-02', 'type' => 'holiday', 'description' => 'All Souls Day'],
            
            // Bonifacio Day
            ['date' => '2026-11-30', 'type' => 'holiday', 'description' => 'Bonifacio Day'],
            
            // Feast of the Immaculate Conception
            ['date' => '2026-12-08', 'type' => 'holiday', 'description' => 'Feast of the Immaculate Conception'],
            
            // Christmas holiday
            ['date' => '2026-12-24', 'type' => 'holiday', 'description' => 'Christmas Eve'],
            ['date' => '2026-12-25', 'type' => 'holiday', 'description' => 'Christmas Day'],
            ['date' => '2026-12-26', 'type' => 'holiday', 'description' => 'Additional Special Day off'],
            ['date' => '2026-12-30', 'type' => 'holiday', 'description' => 'Rizal Day'],
            ['date' => '2026-12-31', 'type' => 'holiday', 'description' => 'New Year\'s Eve'],
        ];

        // Special academic events
        $events = [
            ['date' => '2026-06-01', 'type' => 'event', 'description' => '1st Semester Begins'],
            ['date' => '2026-09-15', 'type' => 'event', 'description' => 'Midterm Examinations Start'],
            ['date' => '2026-10-10', 'type' => 'event', 'description' => '1st Semester Ends / Finals Start'],
            ['date' => '2026-10-16', 'type' => 'event', 'description' => '1st Semester Finals End'],
            ['date' => '2026-10-19', 'type' => 'event', 'description' => '2nd Semester Begins'],
            ['date' => '2026-12-01', 'type' => 'event', 'description' => 'Midterm Examinations Start'],
            ['date' => '2027-01-15', 'type' => 'event', 'description' => '2nd Semester Ends / Finals Start'],
            ['date' => '2027-01-22', 'type' => 'event', 'description' => '2nd Semester Finals End'],
            ['date' => '2027-02-01', 'type' => 'event', 'description' => 'Summer Classes Begin'],
            ['date' => '2027-03-30', 'type' => 'event', 'description' => 'Summer Classes End'],
        ];

        // Generate all school days for the academic year
        $startDate = Carbon::create(2026, 6, 1); // Start from June 1, 2026
        $endDate = Carbon::create(2027, 5, 31); // End from May 31, 2027

        $currentDate = $startDate->clone();

        // Create holiday lookup for quick access
        $holidayLookup = [];
        foreach ($holidays as $holiday) {
            $holidayLookup[$holiday['date']] = [
                'type' => $holiday['type'],
                'description' => $holiday['description']
            ];
        }

        // Create event lookup for quick access
        $eventLookup = [];
        foreach ($events as $event) {
            $eventLookup[$event['date']] = [
                'type' => $event['type'],
                'description' => $event['description']
            ];
        }

        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('Y-m-d');
            $dayOfWeek = $currentDate->dayOfWeek;

            $isWeekend = $dayOfWeek === Carbon::SATURDAY || $dayOfWeek === Carbon::SUNDAY;

            if (isset($holidayLookup[$dateString])) {
                $schoolDays[] = [
                    'date' => $dateString,
                    'day_type' => 'holiday',
                    'description' => $holidayLookup[$dateString]['description'],
                    'is_school_day' => false,
                    'academic_year' => $academicYear,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } elseif (isset($eventLookup[$dateString])) {
                $schoolDays[] = [
                    'date' => $dateString,
                    'day_type' => 'event',
                    'description' => $eventLookup[$dateString]['description'],
                    'is_school_day' => true,
                    'academic_year' => $academicYear,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } elseif ($isWeekend) {
                $schoolDays[] = [
                    'date' => $dateString,
                    'day_type' => 'weekend',
                    'description' => $currentDate->format('l'),
                    'is_school_day' => false,
                    'academic_year' => $academicYear,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } else {
                // Regular school day
                $schoolDays[] = [
                    'date' => $dateString,
                    'day_type' => 'regular',
                    'description' => 'Regular school day',
                    'is_school_day' => true,
                    'academic_year' => $academicYear,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $currentDate->addDay();
        }

        // Insert in batches for performance
        $batchSize = 100;
        for ($i = 0; $i < count($schoolDays); $i += $batchSize) {
            SchoolDay::insert(array_slice($schoolDays, $i, $batchSize));
        }
    }
}
