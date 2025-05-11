<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTimeEntryRequest;
use App\Models\Staff;
use App\Models\TimeEntries;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TimeEntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'date' => 'date|required',
            'staff' => 'numeric|required|exists:staff,id',
        ]);

        $staffMember = Staff::find($data['staff']);

        $carbonDate = Carbon::parse($data['date']);

        $timesheetLink = route('timesheet.index', [
            'staff' => $staffMember->id,
            'month' => $carbonDate->monthName,
            'year' => $carbonDate->year,
        ]);

        return Inertia::render('CreateTimeEntry', [
            'staff' => $staffMember,
            'date' => $data['date'],
            'formattedDate' => $carbonDate->format('M jS Y'),
            'timeEntry' => TimeEntries::forStaffOnDate($staffMember, $data['date'])->first(),
            'timesheetLink' => $timesheetLink,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTimeEntryRequest $request)
    {
        $data = $request->validated();

        try {
            TimeEntries::updateOrCreate([
                'date' => $data['selectedDate'],
                'staff_id' => $data['staff_id'],
            ], [
                'clocked_in' => $data['clocked_in'],
                'clocked_out' => $data['clocked_out'],
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors(['Unable to save time entry']);
        }

        return back()->with('success', 'Time entry was created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
