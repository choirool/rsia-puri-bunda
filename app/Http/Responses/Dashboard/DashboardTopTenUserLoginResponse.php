<?php

namespace App\Http\Responses\Dashboard;

use App\Models\User;
use Illuminate\Contracts\Support\Responsable;

final class DashboardTopTenUserLoginResponse implements Responsable
{
    public function toResponse($request)
    {
        return response()->json([
            'data' => $this->data($request)
        ]);
    }

    protected function data($request)
    {
        return User::whereIn(
            'id',
            function ($query) use ($request) {
                $query->select('user_id')
                    ->from('login_histories')
                    ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                        $query->whereBetween('login_at', [$request->start_date, $request->end_date]);
                    })
                    ->groupBy('user_id')
                    ->havingRaw('COUNT(*) > 25')
                    ->orderByRaw('COUNT(*) DESC')
                    ->limit(10);
            }
        )
            ->withCount('loginHistories')
            ->orderBy('login_histories_count', 'desc')
            ->get();
    }
}
