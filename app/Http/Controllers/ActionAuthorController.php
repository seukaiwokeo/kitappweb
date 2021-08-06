<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActionAuthorController extends Controller
{
    public static function author($id)
    {
        return DB::table("authors")->where("id", $id)->first();
    }
    public static function randomAuthors($limit = 5): ?array
    {
        $results = array();
        $rows = DB::table("authors")->limit($limit)
            ->orderByRaw('RAND()')
            ->get();
        if ($rows ) foreach($rows  as $row) array_push($results, $row);
        return !empty($results) ? $results : null;
    }
}
