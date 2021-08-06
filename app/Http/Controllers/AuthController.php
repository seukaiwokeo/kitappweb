<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public static function Check(): bool
    {
        return auth()->check();
    }

    public static function Login($uid, $password, $remember): bool
    {
        if(strlen($uid) < 2 || strlen($password) < 3)
            return false;

        $result = DB::table("users")->where(function ($query) use ($uid) {
            $query->where("username", "=", $uid)->orWhere("email", "=", $uid);
        })->where("password", "=", md5($password))->first();

        if($result)
            if(!auth()->loginUsingId($result->id, $remember))
                return false;
            else
                return true;

        return false;
    }

    public static function Register($username, $email, $password, $name, $gender) : int
    {
        if(self::Check())
            return 0;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return 1;

        if(strlen($username) < 2 || strlen($password) < 3 || strlen($name) < 2 || $gender < 0 || $gender > 3)
            return 2;

        $has = DB::table("users")->where("username", "=", $username)->orWhere("email", "=", $email)->first();
        if(!$has) {
            $result = DB::table("users")->insert([
                "username" => $username,
                "password" => md5($password),
                "email" => $email,
                "name" => $name,
                "gender" => $gender
            ]);
            if($result) return -1;
            else return 4;
        }
        else return 3;
    }

    public static function Logout() : bool
    {
        if(self::Check())
        {
            auth()->logout();
            return true;
        }
        return false;
    }
}
