<?php

use App\Http\Middleware\AdminRoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/admin/calculations/{calculation}/download', function (App\Models\Calculation $calculation) {
    if (!$calculation->is_read) {
        $calculation->update(['is_read' => true]);
    }

    return redirect()->away(asset('storage/' . $calculation->pdf_path));
})
->name('admin.calculation.download')
->middleware(AdminRoleMiddleware::class);
