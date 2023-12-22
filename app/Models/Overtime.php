<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Overtime extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    protected static $recordEvents = ['deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'deleted_at', 'user.name']);
    }
    protected $fillable = [
        'date',
        'start_hour',
        'end_hour',
        'reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comlists()
    {
        return $this->hasMany(Comlist::class);
    }
}
