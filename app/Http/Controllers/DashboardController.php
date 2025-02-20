<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use App\Models\Position;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use App\Http\Responses\Dashboard\DashboardTopTenUserLoginResponse;

class DashboardController extends Controller
{
    public function totalUsers(Request $request)
    {
        $user = User::query()
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('joinin_date', [$request->start_date, $request->end_date]);
            })
            ->count();

        return response()->json([
            'data' => $user
        ]);
    }

    public function totalUnits()
    {
        return response()->json([
            'data' => Unit::count()
        ]);
    }

    public function totalPostions()
    {
        return response()->json([
            'data' => Position::count()
        ]);
    }

    public function totalLoginHistory(Request $request)
    {
        $data = LoginHistory::query()
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('login_at', [$request->start_date, $request->end_date]);
            })
            ->count();

        return response()->json([
            'data' => $data
        ]);
    }

    public function topTenUserLogin()
    {
        return new DashboardTopTenUserLoginResponse;
    }
}
