<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryZone;
use Illuminate\Http\Request;

class DeliveryZoneController extends Controller
{
    public function index()
    {
        $zones = DeliveryZone::withCount('orders')->orderBy('name')->get();
        return view('admin.zones.index', compact('zones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:delivery_zones,name',
            'description' => 'nullable|string|max:500',
            'base_fee'    => 'required|numeric|min:0',
            'per_km_rate' => 'nullable|numeric|min:0',
        ]);

        DeliveryZone::create([
            'name'        => $request->name,
            'description' => $request->description,
            'base_fee'    => $request->base_fee,
            'per_km_rate' => $request->per_km_rate ?? 0,
            'is_active'   => true,
        ]);

        return back()->with('success', 'Delivery zone created successfully.');
    }

    public function update(Request $request, $id)
    {
        $zone = DeliveryZone::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255|unique:delivery_zones,name,' . $zone->id,
            'description' => 'nullable|string|max:500',
            'base_fee'    => 'required|numeric|min:0',
            'per_km_rate' => 'nullable|numeric|min:0',
            'is_active'   => 'required|boolean',
        ]);

        $zone->update([
            'name'        => $request->name,
            'description' => $request->description,
            'base_fee'    => $request->base_fee,
            'per_km_rate' => $request->per_km_rate ?? 0,
            'is_active'   => $request->is_active,
        ]);

        return back()->with('success', 'Delivery zone updated successfully.');
    }

    public function destroy($id)
    {
        $zone = DeliveryZone::findOrFail($id);

        if ($zone->orders()->count() > 0) {
            return back()->with('error', 'Cannot delete a zone with existing orders.');
        }

        $zone->delete();
        return back()->with('success', 'Delivery zone deleted.');
    }
}
