<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDataMapping extends Model
{
    protected $table = 'user_data_mapping'; 
    protected $fillable = ['user_id', 'data_plan_id', 'subs_date'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dataPlan()
    {
        return $this->belongsTo(DataPlan::class);
    }
    use HasFactory;
}
