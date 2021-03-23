<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['username','email','name','age','biography','img','password'];

    protected $hidden = ['password'];

    public function getImgAttribute(){
        // $avg = (int) Client::avg('age');
        // if(($this->attributes['age']) > 10){
        //     return Image::make(
        //         storage_path('app/public/uploads/images/clients/'.($this->attributes['img']))
        //     )->greyscale();
        // }
        return asset('storage/uploads/images/clients/'.($this->attributes['img']));
    }
}
