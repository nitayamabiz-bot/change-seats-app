<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\SeatLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SeatLayoutController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rows' => ['required', 'integer', 'min:1', 'max:255'],
            'cols' => ['required', 'integer', 'min:1', 'max:255'],
            'class_size' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]);

        SeatLayout::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'rows' => $validated['rows'],
                'cols' => $validated['cols'],
                'class_size' => $validated['class_size'] ?? null,
            ]
        );

        return redirect()->route('settings');
    }
}
