<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStaffRequest;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class StaffController extends Controller
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
    public function create()
    {
        return Inertia::render('CreateStaff');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStaffRequest $request)
    {
        $data = $request->validated();

        if (Staff::firstWhere('email', $data['email'])) {
            return to_route('staff.create')->withErrors(['Staff member with that email already exists!']);
        }

        try {
            Staff::create($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return to_route('staff.create')->withErrors(['Failed creating staff member']);
        }

        return to_route('staff.create')->with('success', 'Staff member created successfully.');
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
