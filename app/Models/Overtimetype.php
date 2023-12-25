<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtimetype extends Model
{
    use HasFactory;
    protected $fillable = [
        'overtimetype_id',
    ];
    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }
}
