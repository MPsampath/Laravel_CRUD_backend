<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;
    protected $table = 'employes';
    protected $primaryKey = 'id';
    protected $fillable = ['emp_name','emp_address'];
    public $incrementing = false;
}
