<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Carbon\Carbon;


class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // ステータスの表示を変更 (0 → 無効、1 → 有効)
    public function getStatusTextAttribute()
    {
        switch($this->attributes['status']) {
            case 1:
                return '有効';
            case 0:
                return '無効';
            default:
                return '??';
        }
    }

    // 日付の表示を変更 (2000-01-01 → 2000/01/01)
    public function getCreatedDueDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('Y/m/d H:i:s');
    }
    public function getUpdatedDueDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['updated_at'])->format('Y/m/d H:i:s');
    }

}