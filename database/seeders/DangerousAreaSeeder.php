<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DangerousArea;

class DangerousAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            [
                'latitude' => -6.9084338974766,
                'longitude' => 107.60271253379,
                'disaster_category_id' => 1
            ],
            [
                'latitude' => -6.9328680197594,
                'longitude' => 107.58445962096,
                'disaster_category_id' => 1
            ],
            [
                'latitude' => -7.039975444530159,
                'longitude' => 107.49249038158673,
                'disaster_category_id' => 1
            ], // earthquake
            [
                'latitude' => -6.9253246375566,
                'longitude' => 107.5385685846,
                'disaster_category_id' => 2
            ], 
            [
                'latitude' => -6.9394489762626,
                'longitude' => 107.72050265189,
                'disaster_category_id' => 2
            ], // flooding
            [
                'latitude' => -7.431601456211783,
                'longitude' => 107.1147244727949,
                'disaster_category_id' => 6
            ], 
            [
                'latitude' => -6.324904207914682,
                'longitude' => 108.3436259686627,
                'disaster_category_id' => 6
            ], // tsunami
            [
                'latitude' => -7.975342592065792,
                'longitude' => 112.92511020059585,
                'disaster_category_id' => 7
            ], 
            [
                'latitude' => -6.112998866169692,
                'longitude' => 105.42027585199236,
                'disaster_category_id' => 7
            ] // volcanic eruption
        ];  

        foreach($areas as $area){
            DangerousArea::create($area);
        }
    }
}
