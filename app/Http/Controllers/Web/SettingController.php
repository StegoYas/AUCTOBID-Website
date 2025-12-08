<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Show settings page
     */
    public function index(): View
    {
        // Initialize defaults if not set
        Setting::initializeDefaults();

        $settings = Setting::all()->keyBy('key');

        return view('settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'commission_percentage' => 'required|numeric|min:0|max:50',
            'default_auction_duration' => 'required|integer|min:1|max:30',
            'minimum_bid_increment' => 'required|numeric|min:1000',
            'max_item_images' => 'required|integer|min:1|max:10',
        ]);

        Setting::setValue('commission_percentage', $request->commission_percentage, 'float', 'Commission percentage taken from winning bid');
        Setting::setValue('default_auction_duration', $request->default_auction_duration, 'integer', 'Default auction duration in days');
        Setting::setValue('minimum_bid_increment', $request->minimum_bid_increment, 'float', 'Default minimum bid increment in Rupiah');
        Setting::setValue('max_item_images', $request->max_item_images, 'integer', 'Maximum number of images per item');

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
