<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DisasterCategory;

class DisasterCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $disasterCategories = [
            'Natural disaster', //bencana alam
            'Earthquake', //banjir
            'flooding', //Banjir
            'Hurricane', // Angin topan
            'Storm', // Badai
            'Sandstorm', // Badai Pasir
            'Tsunami', //Tsunami
            'Volcanic Eruption', // Letusan Gunung Berapi
        ];

        foreach($disasterCategories as $category){
            disasterCategory::create([
                'name' => $category
            ]);
        }
    }
}
