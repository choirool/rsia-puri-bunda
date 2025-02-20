<?php

namespace App\Http\Responses\User;

use App\Models\Unit;
use App\Models\User;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Responsable;

final class UserUpdateResponse implements Responsable
{
    public function toResponse($request)
    {
        $user = DB::transaction(function () use ($request) {
            $user = User::findOrFail($request->route()->parameter('user'));
            $this->updateUser($user, $request);
            $this->attachPositions($user, $request);

            return $user;
        });

        return response()->json([
            'message' => 'User created successfully.',
            'data' => $user,
        ], 201);
    }

    protected function updateUser($user, $request): void
    {
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->joining_date = $request->joining_date;
        $user->unit_id = $this->getUnit($request);

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
    }

    protected function attachPositions(User $user, $request): void
    {
        $positions = collect($request->positions)
            ->map(function ($position) {
                return (int) $position;
            });

        $newPositions = collect($request->positions)
            ->filter(function ($position) {
                return !is_integer($position);
            });

        foreach ($newPositions as $newPosition) {
            $positions->push(
                Position::create(['name' => $newPosition])->id
            );
        }

        $user->positions()->sync($positions->toArray());
    }

    protected function getUnit($request): int
    {
        if (is_integer($request->unit)) {
            return $request->unit;
        }

        return Unit::create(['name' => $request->unit])->id;
    }
}
