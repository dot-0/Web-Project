<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Album extends Model
{
    //
    protected $collection = 'albums';
}
