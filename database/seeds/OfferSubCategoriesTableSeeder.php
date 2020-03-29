<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferSubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Surgey',
            'main_category_id' => 1,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Medicine',
            'main_category_id' => 1,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Equipment',
            'main_category_id' => 1,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Teaching',
            'main_category_id' => 2,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Books & Materials',
            'main_category_id' => 2,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Construction',
            'main_category_id' => 2,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Transport Goods',
            'main_category_id' => 3,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Lift to Passenger',
            'main_category_id' => 3,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Flood Support',
            'main_category_id' => 4,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Earth-Slip Support',
            'main_category_id' => 4,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Food',
            'main_category_id' => 5,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Home',
            'main_category_id' => 5,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Job',
            'main_category_id' => 5,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Buddhist Religious Event',
            'main_category_id' => 6,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Islam Religious Event',
            'main_category_id' => 6,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Hindu Religious Event',
            'main_category_id' => 6,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Fun Event',
            'main_category_id' => 6,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Educational Event',
            'main_category_id' => 6,
        ]);
        DB::table('offer_sub_categories')->insert([
            'name_en' => 'Other',
            'main_category_id' => 7,
        ]);
    }
}
