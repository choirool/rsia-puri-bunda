<?php

namespace App\Http\Responses\User;

use App\Models\Unit;
use App\Models\User;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Responsable;

final class UserDestroyResponse implements Responsable
{
    public function toResponse($request)
    {
        DB::transaction(function () use ($request) {
            $user = User::findOrFail($request->route()->parameter('user'));
            $user->positions()->detach();
            $user->delete();
        });

        return response()->json(null, 204);
    }
}
