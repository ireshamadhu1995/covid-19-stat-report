<?php


namespace App\Helpers;


class CommonHelper
{
    public static function generateURL($path){
        if (!empty($path)){
            $path = explode('public/', $path);
            $file_path = end($path);
            return config('app.url').$file_path;
        }
        return null;
    }

    public static function isJoined($query, $table){
        $joins = collect($query->getQuery()->joins);
        return $joins->pluck('table')->contains($table);
    }
}
