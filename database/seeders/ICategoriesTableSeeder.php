<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ICategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('i_categories')->insert([
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 1,
                'name' => '肉',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 2,
                'name' => '魚介',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 3,
                'name' => '乳製品',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 4,
                'name' => '野菜',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 5,
                'name' => 'きのこ類',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 6,
                'name' => '豆類',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 7,
                'name' => '麺類',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 8,
                'name' => '酒類',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 9,
                'name' => '調味料',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 10,
                'name' => 'ソース類',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 11,
                'name' => 'その他',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
