<?php

namespace App\Http\Controllers;

use App\Helpers\APIHelper;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function deleteImage($id){
        try{
            $image = Image::find($id);
            if(!$image){
                return APIHelper::makeAPIResponse(false, "Image not found", null, 400);
            }
            $imageable = $image->imageable()->first();
            $image->delete();
            $existing_images = $imageable->images()->get();

            if($existing_images){
                return APIHelper::makeAPIResponse(true, "Image Deleted Successfully", $existing_images, 200);
            }
        } catch (Exception $e) {
            return APIHelper::makeAPIResponse(false, "Internal Server Error", null, 500);
        }
    }
}
