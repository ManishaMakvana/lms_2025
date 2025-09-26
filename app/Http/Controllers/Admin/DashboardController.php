<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TinkeringModule;
use App\Models\TinkeringModuleSubActivity;
use App\Models\KitActivationCode;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalModules = TinkeringModule::count();
        $totalActivities = TinkeringModuleSubActivity::count();
        $totalKitCodes = KitActivationCode::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalModules', 
            'totalActivities',
            'totalKitCodes'
        ));
    }

    /**
     * Display reports page.
     */
    public function reports()
    {
        return view('admin.reports');
    }

    /**
     * Display usage report.
     */
    public function usageReport()
    {
        // Implementation for usage report
        return view('admin.reports.usage');
    }

    /**
     * Display progress report.
     */
    public function progressReport()
    {
        // Implementation for progress report
        return view('admin.reports.progress');
    }
}
