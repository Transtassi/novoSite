<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListUf extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $table = 'list_uf';

  protected $fillable = [
    'id',
    'name',
    'uf',
  ];
}
