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

        // Get recent data for CRUD sections
        $recentModules = TinkeringModule::with('creator')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $recentActivities = TinkeringModuleSubActivity::with('module')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $recentKitCodes = KitActivationCode::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalModules', 
            'totalActivities',
            'totalKitCodes',
            'recentModules',
            'recentActivities',
            'recentUsers',
            'recentKitCodes'
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
