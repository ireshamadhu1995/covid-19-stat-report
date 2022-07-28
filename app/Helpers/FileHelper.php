<?php


namespace App\Helpers;


use App\Models\Image;
use Illuminate\Support\Str;

class FileHelper
{
    public static function saveFile($file, $destination_path): string
    {
        //$fileName = $file->hashName();

        $fileName = str_replace(" ", "-", $file->getClientOriginalName());
        $fileName = preg_replace("/[^a-z0-9\_\-\.]/i", '', $fileName);

        $extension_pos = strrpos($fileName, '.');
        $fileName = substr($fileName, 0, $extension_pos) . '_' . date('m-d-Y_hisa') . substr($fileName, $extension_pos);

        $file->move($destination_path, $fileName);
        $saved_path = $destination_path . '/' . $fileName;
        // dd($fileName, $saved_path);

        return $saved_path;
    }

    public static function saveImages($images,$model,$path){
        foreach($images as $image_file) {
            $image = new Image();
            $image->path = self::saveFile($image_file, $path);
            $model->images()->save($image);
        }
    }
}
