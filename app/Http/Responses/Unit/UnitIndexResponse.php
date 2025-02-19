<?php

namespace App\Http\Responses\Unit;

use App\Models\Unit;
use Illuminate\Contracts\Support\Responsable;

final class UnitIndexResponse implements Responsable
{
    public function toResponse($request)
    {
        $units = Unit::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            });

        if ($request->has('pagination') && (int) $request->pagintion === 0) {
            $positions = $units->get();
        } else {
            $positions = $units->paginate($request->input('per_page', 10));
        }

        return response()->json($positions);
    }
}
