<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Artist extends Model
{
    //
    protected $collection = 'artists';
}
