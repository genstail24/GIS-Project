<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DangerousArea extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function disasterCategory(){
        return $this->belongsTo(DisasterCategory::class, 'disaster_category_id');
    }

    public function scopeIsWithinMaxDistance($query, $location, $radius = 25) {
        // return $location;
        $haversine = "(6371 * acos(cos(radians({$location['latitude']})) 
                     * cos(radians(dangerous_areas.latitude)) 
                     * cos(radians(dangerous_areas.longitude) 
                     - radians({$location['longitude']})) 
                     + sin(radians({$location['latitude']})) 
                     * sin(radians(dangerous_areas.latitude))))";
        return $query
        ->select('*') //pick the columns you want here.
        ->selectRaw("{$haversine} AS distance")
        ->whereRaw("{$haversine} < ?", [$radius]);    
    }

    public function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {  
      $earth_radius = 6371;

      $dLat = deg2rad($latitude2 - $latitude1);  
      $dLon = deg2rad($longitude2 - $longitude1);  

      $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
      $c = 2 * asin(sqrt($a));  
      $d = $earth_radius * $c;  

      return $d;  
    }
}
