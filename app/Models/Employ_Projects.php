<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employ_Projects extends Model
{
    use HasFactory;
    protected $table = 'project_employ';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
