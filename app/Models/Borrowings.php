<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrowing_code',
        'member_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date'
    ];

    
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

 
    public function details()
    {
        return $this->hasMany(BorrowingDetail::class);
    }

   
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($borrowing) {
            if (!$borrowing->borrowing_code) {
                $borrowing->borrowing_code = 'BRW' . date('Ymd') . str_pad(Borrowing::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}