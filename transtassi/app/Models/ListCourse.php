<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListCourse extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $table = 'list_course';

  protected $fillable = [
    'id',
    'course',
  ];
}
