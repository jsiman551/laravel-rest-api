<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
    protected $table = "confirmation";
    public $timestamps = false;
    use HasFactory;
}
