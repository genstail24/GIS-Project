<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dangerousAreas(){
        return $this->hasMany(
            DangerousArea::class,
            'disaster_category_id'
        );
    }
}
