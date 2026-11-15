<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'category', 'image_url', 'image_alt'])]
class GalleryItem extends Model
{
    //
}
