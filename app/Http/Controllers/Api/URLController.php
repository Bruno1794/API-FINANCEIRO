<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\URLS;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class URLController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $urls = URLS::get();
        return response()->json([
            'status' => true,
            'urls' => $urls
        ], 200);
    }
}
