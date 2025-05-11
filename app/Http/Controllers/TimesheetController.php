<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\TimesheetRequest;
use App\Models\Staff;
use App\Models\TimeEntries;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class TimesheetController extends Controller
{
    private Carbon $date;

    private ?Staff $staff;
    
    public function index(TimesheetRequest $request)
    {
        $data = $request->validated();

        $staffId = Arr::get($data, 'staff');
        $this->staff = $staffId ? Staff::find($staffId) : Staff::first();

        $month = Arr::get($data, 'month') ?? now()->monthName;
        $year = Arr::get($data, 'year') ?? now()->year;

        $date = Carbon::createFromFormat('F Y', "$month $year")->startOfMonth();

        return Inertia::render('Timesheet', [
            'timesheet' => $this->loadTimesheet($date->year, $date->month),
            'years' => $this->getYears(),
            'months' => $this->getMonths(),
            'staff' => Staff::all()->toArray(),
            'selectedStaff' => request('user', $this->staff->id),
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

        for ($month = $startMonth; $month <= $endMonth; $month++) {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $days = [];
            $paddingDays = [];

            // Iterate over each day in the current month
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $this->date = Carbon::createFromDate($year, $month, $day);

                // If the first day of the month isn't a Monday, backfill the data so we generate a clean calendar
                if ($day === 1) {
                    while ($this->date->dayOfWeek !== 1) {
                        $this->date = (clone($this->date))->subDay();
                        $paddingDays[] = $this->createDayElement(['timesheet-day-disabled'], true);
                    }

                    foreach (array_reverse($paddingDays) as $paddingDay) {
                        $days[] = $paddingDay;
                    }

                    unset($paddingDays);
                }

                // Reset the date otherwise we might be looking at the wrong month
                $this->date = Carbon::createFromDate($year, $month, $day);
                $days[] = $this->createDayElement();

                // If the last day of the month isn't a Sunday, fill the data so we generate a clean calendar
                if ($day === $daysInMonth) {
                    while ($this->date->dayOfWeek !== 0) {
                        $this->date = $this->date->addDays(1);
                        $days[] = $this->createDayElement(['timesheet-day-disabled'], true);
                    }
                }
            }

            $timesheet[Carbon::create()->month($month)->monthName] = $days;
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

        if ($this->staff) {
            $timeEntry = TimeEntries::forStaffOnDate($this->staff, $this->date->format('Y-m-d'))->first();
        } else {
            $timeEntry = null;
        }

        return [
            'custom_classes' => implode(' ', $classes),
            'day' => $this->date->day,
            'date' => $this->date->format('Y-m-d'),
            'disabled' => $disabled,
            'weekend' => $this->date->isWeekend(),
            'clocked_in' => $timeEntry?->clocked_in,
            'clocked_out' => $timeEntry?->clocked_out,
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