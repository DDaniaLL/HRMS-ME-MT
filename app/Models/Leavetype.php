<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leavetype extends Model
{
    use HasFactory;
    protected $fillable = [
        'leavetype_id',
    ];

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function balances()
    {
        return $this->hasMany(Balance::class);
    }
}
