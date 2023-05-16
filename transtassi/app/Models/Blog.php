<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $table = 'blog';

  protected $fillable = [
    'id',
    'title',
    'subtitle',
    'text',
    'description_text',
    'category',
    'level',
    'statusNews',
    'textNavigation',
    'image',
    'created_at',
    'update_at'
  ];
}
