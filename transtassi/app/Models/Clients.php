<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $table = 'client';

  protected $fillable = [
    'id',
    'id_job',
    'name',
    'email',
    'phone',
    'city',
    'uf',
    'areas_interest',
    'education',
    'course',
    'salary',
    'pcd',
    'description_client',
    'curriculum',
    'created_at',
    'update_at',
  ];

  public function relClient()
  {
    return $this->hasMany('App\Models\Jobs', 'id', 'id_job');
  }
}
