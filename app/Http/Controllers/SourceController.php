<?php

namespace App\Http\Controllers;

use App\Models\Source;

class SourceController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSources()
    {
        $sources = Source::get();

        return response()->json([
            'sources' => $sources,
        ]);
    }
}
