<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferMainCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offer_main_categories')->insert([
            'id' => 1,
            'name_en' => 'Medical',
        ]);
        DB::table('offer_main_categories')->insert([
            'id' => 2,
            'name_en' => 'Education',
        ]);
        DB::table('offer_main_categories')->insert([
            'id' => 3,
            'name_en' => 'Travel & Transport',
        ]);
        DB::table('offer_main_categories')->insert([
            'id' => 4,
            'name_en' => 'Natural Disaster',
        ]);
        DB::table('offer_main_categories')->insert([
            'id' => 5,
            'name_en' => 'Living',
        ]);
        DB::table('offer_main_categories')->insert([
            'id' => 6,
            'name_en' => 'Event',
        ]);
        DB::table('offer_main_categories')->insert([
            'id' => 7,
            'name_en' => 'Other',
        ]);
    }
}
