<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActionBookController extends Controller
{
    public static function authorsBooks($id)
    {
        return DB::table("books")->orderBy("id", "desc")
            ->where("author", $id)
            ->limit(16)
            ->get();
    }
    public static function similarBooks($id, $limit = 10)
    {
        $book = self::book($id);
        if($book != null) {
            $jsonData = json_decode($book->categories);
            if($jsonData != null && isset($jsonData->categories)) {
                if (count($jsonData->categories) > 2) {
                    return DB::table("books")
                        ->WhereJsonContains("categories", ["categories" => $jsonData->categories[0]])
                        ->WhereJsonContains("categories", ["categories" => $jsonData->categories[1]])
                        ->join("authors", "books.author", "=", "authors.id")
                        ->select("books.*", "authors.name as authorName", "authors.id as authorId", "authors.avatar as authorAvatar")
                        ->get();
                } else {
                    return DB::table("books")
                        ->WhereJsonContains("categories", ["categories" => $jsonData->categories[0]])
                        ->join("authors", "books.author", "=", "authors.id")
                        ->select("books.*", "authors.name as authorName", "authors.id as authorId", "authors.avatar as authorAvatar")
                        ->get();
                }
            }
        }
        return null;
    }
    public static function viewBook($id)
    {
        if(session()->has("view_{$id}"))
            return false;

        session()->push("view_{$id}", 1);

        return DB::table("books")->where("id", $id)
            ->update(["views" => DB::raw("views+1")]);
    }
    public static function book($id)
    {
        return DB::table("books")->where("books.id", $id)
            ->join("authors", "books.author", "=", "authors.id")
            ->select("books.*", "authors.name as authorName", "authors.id as authorId", "authors.avatar as authorAvatar")
            ->first();
    }
    public static function latestBook()
    {
        return DB::table("books")->orderBy("id", "desc")
            ->join("authors", "books.author", "=", "authors.id")
            ->select("books.*", "authors.name as authorName", "authors.id as authorId", "authors.avatar as authorAvatar")
            ->first();
    }
    public static function randomBooks($limit = 5): ?array
    {
        $results = array();
        $rows = DB::table("books")->limit($limit)
            ->join("authors", "books.author", "=", "authors.id")
            ->select("books.*", "authors.name as authorName", "authors.id as authorId", "authors.avatar as authorAvatar")
            ->orderByRaw('RAND()')
            ->get();
        if ($rows ) foreach($rows  as $row) array_push($results, $row);
        return !empty($results) ? $results : null;
    }
    public static function bookQuery($q = null, $limit = 20, $author = null): ?array
    {
        $results = array();
        $rows = [];
        if($author) {
            $rows = DB::table("books")->limit($limit)->where("title", "like", "%{$q}%")
                ->where("author", $author)
                ->join("authors", "books.author", "=", "authors.id")
                ->select("books.*", "authors.name as authorName", "authors.id as authorId", "authors.avatar as authorAvatar")
                ->orderBy("books.like_count", "desc")
                ->get();
        } else {
            $rows = DB::table("books")->limit($limit)->where("title", "like", "%{$q}%")
                ->join("authors", "books.author", "=", "authors.id")
                ->select("books.*", "authors.name as authorName", "authors.id as authorId", "authors.avatar as authorAvatar")
                ->orderBy("books.like_count", "desc")
                ->get();
        }

        if ($rows ) foreach($rows  as $row) array_push($results, $row);
        return !empty($results) ? $results : null;
    }
    public static function latestBooks(): ?array
    {
        $results = array();
        $rows = DB::table("books")->limit(8)
            ->join("authors", "books.author", "=", "authors.id")
            ->select("books.*", "authors.name as authorName", "authors.id as authorId", "authors.avatar as authorAvatar")
            ->orderBy("books.id", "desc")
            ->get();
        if ($rows ) foreach($rows  as $row) array_push($results, $row);
        return !empty($results) ? $results : null;
    }
    public static function searchBook($q): ?array
    {
         $results = array();
        $rows = DB::table("books")->where("title", "like", "%{$q}%")
            ->join("authors", "books.author", "=", "authors.id")
            ->select("books.*", "authors.name as authorName", "authors.id as authorId", "authors.avatar as authorAvatar")
            ->orderBy("books.id", "desc")
            ->get();
        if ($rows ) foreach($rows  as $row) array_push($results, $row);
        return !empty($results) ? $results : null;
    }
    public static function addBook($data)
    {
        // api'den $_GET parametrelerini $data dizisine aktarıyorum ki api kısmında tek tek elle yazmayalım ve gerekli özelleştirmeleri fonksiyona göre yapabilelim
        $title = $data["title"] ?? null;
        $summary = $data["summary"] ?? null;
        $cover = $data["cover"] ?? null;
        $author = $data["author"] ?? null;
        $page_count = $data["page_count"] ?? 0;
        $publishing_date = $data["publishing_date"] ?? null;
        $market_link = $data["market_link"] ?? null;
        $market_price = $data["market_price"] ?? 0;
        if(strlen($market_price) == 0) $market_price = null;

        if(DB::table("books")->insert([
            "title" => $title,
            "summary" => $summary,
            "cover" => $cover,
            "author" => $author,
            "page_count" => $page_count,
            "publishing_date" => $publishing_date,
            "market_link" => $market_link,
            "market_price" => $market_price
        ]))
            return DB::getPdo()->lastInsertId();
        return null;
    }
    public static function editBook($data): bool
    {
        $id = $data["id"] ?? null;
        $title = $data["title"] ?? null;
        $summary = $data["summary"] ?? null;
        $cover = $data["cover"] ?? null;
        $author = $data["author"] ?? null;
        $page_count = $data["page_count"] ?? 0;
        $publishing_date = $data["publishing_date"] ?? null;
        $market_link = $data["market_link"] ?? null;
        $market_price = $data["market_price"] ?? 0;
        if(strlen($market_price) == 0) $market_price = null;

        if(DB::table("books")->where(["id" => $id])->update([
            "title" => $title,
            "summary" => $summary,
            "cover" => $cover,
            "author" => $author,
            "page_count" => $page_count,
            "publishing_date" => $publishing_date,
            "market_link" => $market_link,
            "market_price" => $market_price
        ]))
            return true;
        return false;
    }
    public static function removeBook($id) : bool
    {
        return DB::table("books")->delete($id);
    }
}
