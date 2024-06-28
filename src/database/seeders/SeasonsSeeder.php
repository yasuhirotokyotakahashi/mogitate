<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;

class SeasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データを挿入
        $seasonsData = [
            ['name' => '春'],
            ['name' => '夏'],
            ['name' => '秋'],
            ['name' => '冬'],
        ];

        // データをSeasonモデルに挿入
        foreach ($seasonsData as $data) {
            Season::create($data);
        }
    }
}
