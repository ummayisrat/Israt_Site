<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'body', 'image_url', 'image_alt'])]
class Story extends Model
{
    //
}
