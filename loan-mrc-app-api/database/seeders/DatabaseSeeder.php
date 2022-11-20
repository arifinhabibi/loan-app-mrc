<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Borrower;
use App\Models\GoodsCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Borrower::create([
            'name' => 'Muhammad Arifin Habibi',
            'id_card' => '1319178859'
        ]);

        User::create([
            'username' => 'admin',
            'password' => bcrypt('admin')
        ]);

        $goodsCategories = [
            [
                'name_category' => 'notebook dan netbook'
            ],
            [
                'name_category' => 'tools dan barang lainnya'
            ],
            
            [
                'name_category' => 'lcd projector'
            ],
            [
                'name_category' => 'Tablet'
            ]
        ];

        foreach ($goodsCategories as $goodsCategory) {
            GoodsCategory::create($goodsCategory);
        }
    }
}
