<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowingDetails extends Model
{
    protected $guarded = ['id'];
    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}
