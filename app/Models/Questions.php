<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $fillable = [
      'type', 'title', 'content', 'answer', 'sort',
    ];

    public function testpages()
    {
      return $this->belongsTo(Testpages::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
