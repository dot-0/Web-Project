<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Demo extends Eloquent
{
    protected $collection = 'demo_collection';
    public $fillable = ['name','details'];
}
