<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = ['id'];
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
