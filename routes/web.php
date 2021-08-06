<?php

use App\Http\Controllers\ActionAuthorController;
use App\Http\Controllers\ActionBookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JsonHelperController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
   return view("feed");
});

Route::get("library", function () {
   return view("library");
});

Route::get("wordbook", function () {
   return view("wordbook.feed");
});

Route::get("wordbook/entry/{title_seo}", function ($title_seo) {
    $entry = \App\Http\Controllers\ActionWordbookController::entryFromTitle($title_seo);
    if($entry != null)
        return view("wordbook.entry", ["entry" => $entry]);
    return redirect("wordbook");
});

Route::get("auth", function () {
    if(AuthController::Check())
        return redirect("/");

    return view("auth");
});

Route::post("auth", function () {
    if(AuthController::Check())
        return redirect("/");

    $data = request()->only(["uid", "password", "remember"]);
    if(!is_array($data) || !array_key_exists("uid", $data) || !array_key_exists("password", $data) || !array_key_exists("remember", $data))
        return redirect("/auth?failed=0");

    if(AuthController::Login($data["uid"], $data["password"], $data["remember"]))
        return redirect("/");

    return redirect("/auth?failed=1");
});

Route::get("register", function () {
    if(AuthController::Check())
        return redirect("/");

    return view("register");
});

Route::post("register", function () {
    if(AuthController::Check())
        return redirect("/");

    $data = request()->only(["username", "password", "email", "name", "gender"]);
    if(!is_array($data) || !array_key_exists("username", $data) || !array_key_exists("password", $data) || !array_key_exists("email", $data)
        || !array_key_exists("name", $data)  || !array_key_exists("gender", $data))
        return redirect("/register?failed=0");

    $result = AuthController::Register($data["username"], $data["email"], $data["password"], $data["name"], $data["gender"]);
    if($result == -1) return redirect("/");

    return redirect("/register?failed=$result");
});

Route::get("account", function() {
    if(!AuthController::Check())
        return redirect("/auth");

    return view("account");
});

Route::get("book/{id}", function ($id) {
    $book = ActionBookController::book($id);
    if($book != null) {
        if(ActionBookController::viewBook($id))
            $book->views++;
        return view("book", ["book" => $book]);
    }
    return redirect("/");
});

Route::get("author/{id}", function ($id) {
    $author = ActionAuthorController::author($id);
    if($author != null)
        return view("author", ["author" => $author]);

    return redirect("/");
});

Route::get("author/{id}/books", function($id) {
    $author = ActionAuthorController::author($id);
    if($author != null)
        return view("author.books", ["author" => $author]);

    return redirect("/");
});

Route::prefix("admin/action")->group(function() {
    Route::post("book", function () {
        $id = request()->input("q");
        if($id != null) {
            return JsonHelperController::JsonResponse(ActionBookController::book($id), "success", 200);
        }
        return JsonHelperController::JsonResponse(null, "bad request", 403);
    });
    Route::post("book_list", function () {
        $q = request()->input("q");
        if($q) return JsonHelperController::JsonResponse(ActionBookController::searchBook($q), "success", 200);
        return JsonHelperController::JsonResponse(ActionBookController::latestBooks(), "success", 200);
    });
    Route::post("book_add", function () {
        $result = ActionBookController::addBook($_POST);
        return JsonHelperController::JsonResponse( $result,  $result ? "success" : "failed",  $result ? 200 : 500);
    });
    Route::post("book_edit", function () {
        $result = ActionBookController::editBook($_POST);
        return JsonHelperController::JsonResponse( $result,  $result ? "success" : "failed",  $result ? 200 : 500);
    });
    Route::post("book_remove", function () {
        $id = request()->input("q");
        if($id != null) {
            $result = ActionBookController::removeBook($id);
            return JsonHelperController::JsonResponse($result, $result ? "success" : "failed", $result ? 200 : 500);
        }
        return JsonHelperController::JsonResponse(null, "bad request", 403);
    });
    Route::post("upload_cover", function () {
        $result = 0;
        if(!request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]))
            $result = 1;
        else {
            $imageName = time().'.'.request()->image->extension();
            request()->image->move(public_path('images'), $imageName);
            $result = "images/" . $imageName;
        }

        return JsonHelperController::JsonResponse( $result,  null,  200);
    });
});

Route::prefix("admin")->group(function() {
    if (!AdminController::CheckPrivileges())
        return response()->make("", 404);

    Route::get("/", function () {
        return view("admin.book");
    });

    return "b";
});
