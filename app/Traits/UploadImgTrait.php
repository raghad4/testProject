<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Image;


Trait UploadImgTrait{
    private $basePath = "app\public\uploads\images";

    function saveImage($image,$folder){
        $ext = $image->extension();
        $file_name = "$folder-".time().".$ext";
        $img = Image::make($image)
                ->resize(256,256,function($constraint){
                    $constraint->aspectRatio();
                }); 

        $img->save(storage_path("$this->basePath\\$folder\\$file_name"));
        return $file_name;
    }
}
