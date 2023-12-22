<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Leave extends Model
{
    use HasFactory;
    use LogsActivity;
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'start_date',
        'end_date',
        'leavetype_id',
        'reason',
    ];

    protected static $recordEvents = ['deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'deleted_at', 'user.name']);

        // Chain fluent methods for configuration options
    }

    public function leavetype()
    {
        return $this->belongsTo(Leavetype::class);

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
