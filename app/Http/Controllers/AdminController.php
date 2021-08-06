<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public static function CheckPrivileges() : bool
    {
        return !auth()->check();
    }
}
