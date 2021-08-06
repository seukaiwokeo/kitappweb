<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsonHelperController extends Controller
{
    public static function JsonResponse($data, $message, $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json(["data" => $data, "message" => $message, "status" => $status], $status);
    }
}
