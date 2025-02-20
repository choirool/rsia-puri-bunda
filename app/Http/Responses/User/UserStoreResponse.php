<?php

namespace App\Http\Responses\User;

use App\Models\Unit;
use App\Models\User;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Responsable;

final class UserStoreResponse implements Responsable
{
    public function toResponse($request)
    {
        $user = DB::transaction(function () use ($request) {
            $user = $this->createUser($request);
            $this->attachPositions($user, $request);

            return $user;
        });

        return response()->json([
            'message' => 'User created successfully.',
            'data' => $user,
        ], 201);
    }

    protected function createUser($request): User
    {
        return User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'joining_date' => $request->joining_date,
            'unit_id' => $this->getUnit($request),
        ]);
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

        $user->positions()->attach($positions);
    }

    protected function getUnit($request): int
    {
        if (is_integer($request->unit)) {
            return $request->unit;
        }

        return Unit::create(['name' => $request->unit])->id;
    }
}
