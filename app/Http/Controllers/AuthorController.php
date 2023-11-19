<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorFilterRequest;
use App\Models\Author;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    /**
     * @param AuthorFilterRequest $request
     * @return JsonResponse
     */
    public function getAuthors(AuthorFilterRequest $request)
    {
        $authors = Author::query();
        $req = $request->validated();

        if (isset($req['name'])) {
            $authors->where('name', 'like', '%' . $req['name'] . '%');
        }

        $authors = $authors->paginate(20);

        return response()->json([
            'authors' => $authors,
        ]);
    }
}
