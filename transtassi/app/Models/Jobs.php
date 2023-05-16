<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $table = 'jobs';

  protected $fillable = [
    'id',
    'name',
    'city',
    'uf',
    'department',
    'description',
    'status',
    'created_at',
    'update_at',
  ];

  public function relJobs()
  {
    return $this->hasMany('App\Models\Clients', 'id_job');
  }
}
