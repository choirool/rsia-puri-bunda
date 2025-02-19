<?php

namespace App\Http\Responses\Unit;

use App\Models\Unit;
use Illuminate\Contracts\Support\Responsable;

final class UnitIndexResponse implements Responsable
{
    public function toResponse($request)
    {
        $units = Unit::paginate($request->input('per_page', 10));
        return response()->json($units);
    }
}
