<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimesheetController extends Controller
{
    private Carbon $date;
    
    
    public function index(Request $request)
    {
        $month = request('month') ?? now()->monthName;
        $year = request('year') ?? now()->year;

        $date = Carbon::createFromFormat('F Y', "$month $year")->startOfMonth();

        return Inertia::render('Timesheet', [
            'timesheet' => $this->loadTimesheet($date->year, $date->month),
            'years' => $this->getYears(),
            'months' => $this->getMonths(),
            'staff' => Staff::all()->toArray(),
            'selectedStaff' => request('user'),
            'selectedMonth' => $month,
            'selectedYear' => $year,
        ]);
    }

    private function loadTimesheet($year = null, $month = null): array
    {
        $year = $year ?? now()->year;
        $startMonth = $month ?? 1;
        $endMonth = $month ?? 12;

        $timesheet = [];

        for ($i = $startMonth; $i <= $endMonth; $i++) {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $i, $year);
            $days = [];
            $paddingDays = [];

            $days[] = ''; // Set first key (0) as blank, we unset this later to force the array to start at 1

            // Iterate over each day in the current month
            for ($x = 1; $x <= $daysInMonth; $x++) {
                $this->date = Carbon::createFromDate($year, $i, $x);

                $monthName = $this->date->monthName;

                // If the first day of the month isn't a Monday, backfill the data so we generate a clean calendar
                if ($x === 1) {
                    while ($this->date->dayOfWeek !== 1) {
                        $this->date = $this->date->subDay();
                        $paddingDays[] = $this->createDayElement(['timesheet-day-disabled'], true);
                    }
                    foreach (array_reverse($paddingDays) as $paddingDay) {
                        $days[] = $paddingDay;
                    }
                }

                // Reset the date otherwise we might be looking at the wrong month
                $this->date = Carbon::createFromDate($year, $i, $x);
                $days[] = $this->createDayElement();

                // If the last day of the month isn't a Sunday, fill the data so we generate a clean calendar
                if ($x === $daysInMonth) {
                    while ($this->date->dayOfWeek !== 0) {
                        $this->date = $this->date->addDays(1);
                        $days[] = $this->createDayElement(['timesheet-day-disabled'], true);
                    }
                }
            }

            unset($days[0]); // Force array keys to start at 1
            $timesheet[$monthName] = $days;
        }

        return $timesheet;
    }

    private function createDayElement(array $classes = [], bool $disabled = false): array
    {
        if ($this->date->isToday()) {
            $classes[] = 'today';
        }

        if ($this->date->isWeekend()) {
            $classes[] = 'timesheet-day-disabled';
        }

        // TODO - check existing time entry

        return [
            'custom_classes' => implode(' ', $classes),
            'day' => $this->date->day,
            'date' => $this->date->format('Y-m-d'),
            'disabled' => $disabled,
            'weekend' => $this->date->isWeekend(),
        ];
    }

    private function getMonths(): array
    {
        $months = [];

        for ($x = 0; $x < 3; $x++) {
            $months[] = now()->subMonths($x)->monthName;
        }

        return $months;
    }

    private function getYears(): array
    {
        $years = [];

        for ($x = 0; $x < 3; $x++) {
            $years[] = now()->subYears($x)->year;
        }

        return $years;
    }
}