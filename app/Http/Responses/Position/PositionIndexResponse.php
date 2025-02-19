<?php

namespace App\Http\Responses\Position;

use App\Models\Position;
use Illuminate\Contracts\Support\Responsable;

final class PositionIndexResponse implements Responsable
{
    public function toResponse($request)
    {
        $units = Position::paginate($request->input('per_page', 10));
        return response()->json($units);
    }
}
