<?php

namespace App\Http\Responses\Position;

use App\Models\Position;
use Illuminate\Contracts\Support\Responsable;

final class PositionIndexResponse implements Responsable
{
    public function toResponse($request)
    {
        $positions = Position::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            });

        if ($request->has('pagination') && (int) $request->pagintion === 0) {
            $positions = $positions->get();
        } else {
            $positions = $positions->paginate($request->input('per_page', 10));
        }

        return response()->json($positions);
    }
}
