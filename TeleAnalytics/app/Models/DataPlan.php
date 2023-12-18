<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPlan extends Model
{
    protected $table = 'data_plan'; 
    protected $fillable = ['cost', 'validity', 'data_per_day','description','is_active'];
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_data_mapping', 'data_plan_id', 'user_id')
        ->withPivot(['subs_date']);
    }
    use HasFactory;
}
