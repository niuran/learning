<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usertests extends Model
{
    protected $fillable = [
      'userid', 'testpageid', 'testpage_updated_at', 'user_choice',
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