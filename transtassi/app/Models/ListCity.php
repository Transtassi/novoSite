<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListCity extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $table = 'list_city';

  protected $fillable = [
    'id',
    'uf',
    'city',
  ];
}
