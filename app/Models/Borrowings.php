<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $guarded = ['id'];
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function borrowingDetails()
    {
        return $this->hasMany(BorrowingDetails::class);
    }           
}
