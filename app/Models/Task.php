<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  use HasFactory;

  protected $fillable = [
    'title', 'description', 'status',
  ];

  protected $appends = ['currentstatus'];

  public function getCurrentStatusAttribute() {
    $state = array(
                    "Cancelled",
                    "Completed",
                    "Pending",
                  );

    if($this->status){
      return $state[$this->status];
    }

  }
}
