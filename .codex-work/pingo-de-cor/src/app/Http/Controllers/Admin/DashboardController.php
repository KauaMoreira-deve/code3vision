<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $resources = config('admin_resources');
        $totals = [];

        foreach ($resources as $slug => $resource) {
            $totals[$slug] = $resource['model']::query()->count();
        }

        return view('admin.dashboard', compact('resources', 'totals'));
    }
}
