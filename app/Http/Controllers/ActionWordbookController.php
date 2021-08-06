<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class ActionWordbookController extends Controller
{
    public static function buildContent($s)
    {
        $s = strip_tags($s, ["<spoiler>"]);
        $s = str_replace("\n", "<br />", $s);
        $s = str_replace("<spoiler>", "<br/><span style='display: block; font-weight: bold; margin: auto'> Spoiler: </span><spoiler>", $s);
        $s = preg_replace('/(?:^|\s)#(\w+)/', ' <a href="' . URL::to('/') . '/wordbook/entry/$1">#$1</a>', $s);
        $s = preg_replace('/(?:^|\s)@(\w+)/', ' <a href="' . URL::to('/') . '/u/$1">@$1</a>', $s);
        return $s;
    }
    public static function replies($entry, $limit = 5): ?array
    {
        $results = array();
        $rows = DB::table("wordbook_reply")->limit($limit)
            ->where("wordbook_reply.entry_id", $entry)
            ->join("users", "users.id", "=", "wordbook_reply.user_id")
            ->join("wordbook_entry", "wordbook_entry.id", "=", "wordbook_reply.entry_id")
            ->select("wordbook_reply.*", "users.name as userName", "users.username as userUserName", "users.avatar as userAvatar")
            ->orderBy("wordbook_reply.id", "asc")
            ->get();
        if ($rows ) foreach($rows  as $row) array_push($results, $row);
        return !empty($results) ? $results : null;
    }
    public static function topAuthor($limit = 10): ?array
    {
        $results = array();
        $rows = DB::select("SELECT DISTINCT(a.user_id), u.username, u.avatar, b.TotalCount FROM wordbook_reply a
INNER JOIN (SELECT user_id, COUNT(*) totalCount FROM wordbook_reply GROUP BY user_id) b ON  a.user_id = b.user_id
INNER JOIN users u ON u.id = a.user_id
ORDER BY b.TotalCount DESC, a.ID ASC");
        if ($rows ) foreach($rows  as $row) array_push($results, $row);
        return !empty($results) ? $results : null;
    }
    public static function tagQuery($start = 0, $limit = 10): ?array
    {
        $results = array();
        $rows = DB::table("wordbook_tags")->limit($limit)->skip($start)
            ->orderBy("entry_count", "desc")
            ->get();
        if ($rows ) foreach($rows  as $row) array_push($results, $row);
        return !empty($results) ? $results : null;
    }
    public static function entry($id)
    {
        return DB::table("wordbook_entry")->where("wordbook_entry.id", $id)
            ->join("users", "users.id", "=", "wordbook_entry.user_id")
            ->select("wordbook_entry.*", "users.name as userName", "users.username as userUserName", "users.avatar as userAvatar")
            ->first();
    }
    public static function entryFromTitle($title)
    {
        return DB::table("wordbook_entry")->where("wordbook_entry.title_seo", $title)
            ->join("users", "users.id", "=", "wordbook_entry.user_id")
            ->select("wordbook_entry.*", "users.name as userName", "users.username as userUserName", "users.avatar as userAvatar")
            ->first();
    }
    public static function trends($tag = null, $limit = 15): ?array
    {
        $results = array();
        if($tag) {
            $rows = DB::select("SELECT  DISTINCT (c.title), c.id, c.user_id, c.title_seo, c.entry_tag, c.views, c.updated_at, c.created_at, u.name as userName, u.username as userUserName, u.avatar as userAvatar FROM wordbook_reply a
INNER JOIN (SELECT entry_id, COUNT(*) totalCount FROM wordbook_reply GROUP BY entry_id) b ON a.entry_id = b.entry_id
INNER JOIN wordbook_entry c ON c.id = a.entry_id
INNER JOIN users u ON u.id = c.user_id
WHERE c.entry_tag={$tag}
ORDER BY b.TotalCount DESC, a.ID ASC");
        } else {
            $rows = DB::select("SELECT  DISTINCT (c.title), b.totalCount, c.id, c.user_id, c.title_seo, c.entry_tag, c.views, c.updated_at, c.created_at, u.name as userName, u.username as userUserName, u.avatar as userAvatar FROM wordbook_reply a
INNER JOIN (SELECT entry_id, COUNT(*) totalCount FROM wordbook_reply GROUP BY entry_id) b ON a.entry_id = b.entry_id
INNER JOIN wordbook_entry c ON c.id = a.entry_id
INNER JOIN users u ON u.id = c.user_id
ORDER BY b.TotalCount DESC, a.ID ASC");
        }
        if ($rows ) foreach($rows  as $row) array_push($results, $row);
        return !empty($results) ? $results : null;
    }
    public static function randomEntries($q = null, $limit = 20, $author = null): ?array
    {
        $results = array();
        if($author) {
            $rows = DB::table("wordbook_entry")->limit($limit)->where("title", "like", "%{$q}%")
                ->where("user_id", $author)
                ->join("users", "users.id", "=", "wordbook_entry.user_id")
                ->select("wordbook_entry.*", "users.name as userName", "users.username as userUserName", "users.avatar as userAvatar")
                ->orderByRaw("RAND()")
                ->get();
        } else {
            $rows = DB::table("wordbook_entry")->limit($limit)->where("title", "like", "%{$q}%")
                ->join("users", "users.id", "=", "wordbook_entry.user_id")
                ->select("wordbook_entry.*", "users.name as userName", "users.username as userUserName", "users.avatar as userAvatar")
                ->orderByRaw("RAND()")
                ->get();
        }

        if ($rows ) foreach($rows  as $row) array_push($results, $row);
        return !empty($results) ? $results : null;
    }
    public static function entryQuery($q = null, $limit = 20, $author = null): ?array
    {
        $results = array();
        if($author) {
            $rows = DB::table("wordbook_entry")->limit($limit)->where("title", "like", "%{$q}%")
                ->where("user_id", $author)
                ->join("users", "users.id", "=", "wordbook_entry.user_id")
                ->select("wordbook_entry.*", "users.name as userName", "users.username as userUserName", "users.avatar as userAvatar")
                ->orderBy("wordbook_entry.id", "desc")
                ->get();
        } else {
            $rows = DB::table("wordbook_entry")->limit($limit)->where("title", "like", "%{$q}%")
                ->join("users", "users.id", "=", "wordbook_entry.user_id")
                ->select("wordbook_entry.*", "users.name as userName", "users.username as userUserName", "users.avatar as userAvatar")
                ->orderBy("wordbook_entry.id", "desc")
                ->get();
        }

        if ($rows ) foreach($rows  as $row) array_push($results, $row);
        return !empty($results) ? $results : null;
    }
}
