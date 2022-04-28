<?php

namespace App\Models;

class UserPlan extends BaseModel
{
    protected $table = 'user_plans';

    protected $fillable = [
        'user_id',
        'plan_id',
        'progress',
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
