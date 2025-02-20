<?php

namespace App\Http\Responses\User;

use App\Models\User;
use Illuminate\Contracts\Support\Responsable;

final class UserIndexResponse implements Responsable
{
    public function toResponse($request)
    {
        $users = User::query()
            ->with(['unit', 'positions'])
            ->paginate($request->input('per_page', 10));

        return response()->json($users);
    }
}
