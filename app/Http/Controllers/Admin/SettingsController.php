<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    // Settings are stored as a simple JSON file in storage
    private function getSettingsPath()
    {
        return storage_path('app/settings.json');
    }

    private function getSettings()
    {
        $path = $this->getSettingsPath();
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }
        return $this->defaults();
    }

    private function defaults()
    {
        return [
            'company_name'    => 'Tsavo Water',
            'company_email'   => 'support@tsavowater.com',
            'company_phone'   => '+254 700 000 000',
            'company_address' => 'Nairobi, Kenya',
            'currency'        => 'KES',
            'min_order'       => 500,
            'enable_mpesa'    => false,
            'enable_sms'      => false,
            'enable_email'    => false,
        ];
    }

    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name'    => 'required|string|max:255',
            'company_email'   => 'required|email|max:255',
            'company_phone'   => 'required|string|max:30',
            'company_address' => 'required|string|max:500',
            'currency'        => 'required|string|max:10',
            'min_order'       => 'required|numeric|min:0',
        ]);

        $settings = [
            'company_name'    => $request->company_name,
            'company_email'   => $request->company_email,
            'company_phone'   => $request->company_phone,
            'company_address' => $request->company_address,
            'currency'        => $request->currency,
            'min_order'       => $request->min_order,
            'enable_mpesa'    => $request->boolean('enable_mpesa'),
            'enable_sms'      => $request->boolean('enable_sms'),
            'enable_email'    => $request->boolean('enable_email'),
        ];

        file_put_contents($this->getSettingsPath(), json_encode($settings, JSON_PRETTY_PRINT));

        return back()->with('success', 'Settings saved successfully.');
    }
}
