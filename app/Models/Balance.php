<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Balance extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    protected static $recordEvents = ['updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()

            ->logOnly(['name',
                'leavetype_id',
                'user_id',
                'user.name',
                'value'])->useLogName('Balanceupdate')->logOnlyDirty();
    }

    protected $fillable = [
        'leavetype_id',
        'name',
        'value',
    ];

    public function leavetype()
    {
        return $this->belongsTo(Leavetype::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
