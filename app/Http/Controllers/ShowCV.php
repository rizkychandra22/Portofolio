<?php

namespace App\Http\Controllers;

use App\Models\CurriculumVitae;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShowCV extends Controller
{
    public function showCV()
    {
        $cv = CurriculumVitae::query()
            ->where('is_active', true)
            ->latest('id')
            ->first() ?? CurriculumVitae::query()->latest('id')->first();

        if (! $cv || blank($cv->file_path)) {
            abort(404);
        }

        $normalizedPath = ltrim(str_replace('\\', '/', $cv->file_path), '/');
        $cvUrl = rescue(
            fn () => Storage::disk('cloudinary')->url($normalizedPath),
            report: false,
        );

        if (blank($cvUrl)) {
            abort(404);
        }

        return redirect()->away($cvUrl);
    }
}
