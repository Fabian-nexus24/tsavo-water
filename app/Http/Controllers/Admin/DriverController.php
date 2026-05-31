<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DriverProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = User::where('role', 'driver')
            ->with('driverProfile')
            ->withCount('deliveriesAsDriver')
            ->latest()
            ->paginate(15);

        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'national_id' => 'required|string|unique:driver_profiles',
            'vehicle_type' => 'required|string',
            'vehicle_plate' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'driver',
            'status' => 'active',
        ]);
        
        $user->assignRole('driver');

        DriverProfile::create([
            'user_id' => $user->id,
            'national_id' => $request->national_id,
            'vehicle_type' => $request->vehicle_type,
            'vehicle_plate' => $request->vehicle_plate,
            'availability' => 'offline',
        ]);

        return redirect()->route('admin.drivers.index')->with('success', 'Driver registered successfully.');
    }

    public function show(User $driver)
    {
        if ($driver->role !== 'driver') abort(404);

        $driver->load(['driverProfile', 'deliveriesAsDriver.order.user']);
        
        $recentDeliveries = $driver->deliveriesAsDriver()->latest()->limit(10)->get();
        $totalDelivered = $driver->deliveriesAsDriver()->where('status', 'delivered')->count();

        return view('admin.drivers.show', compact('driver', 'recentDeliveries', 'totalDelivered'));
    }

    public function edit(User $driver)
    {
        if ($driver->role !== 'driver') abort(404);
        $driver->load('driverProfile');
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, User $driver)
    {
        if ($driver->role !== 'driver') abort(404);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'national_id' => ['required', 'string', Rule::unique('driver_profiles')->ignore($driver->driverProfile->id)],
            'vehicle_type' => 'required|string',
            'vehicle_plate' => 'required|string',
        ]);

        $driver->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        $driver->driverProfile->update([
            'national_id' => $request->national_id,
            'vehicle_type' => $request->vehicle_type,
            'vehicle_plate' => $request->vehicle_plate,
        ]);

        return redirect()->route('admin.drivers.index')->with('success', 'Driver profile updated.');
    }

    public function updateStatus(Request $request, User $driver)
    {
        if ($driver->role !== 'driver') abort(404);

        $request->validate(['status' => 'required|in:active,suspended']);
        $driver->update(['status' => $request->status]);

        return back()->with('success', 'Driver status updated.');
    }
}
