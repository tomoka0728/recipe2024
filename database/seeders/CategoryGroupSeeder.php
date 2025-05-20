<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryGroupSeeder extends Seeder
{
    public function run()
    {
        // 肉グループ
        DB::table('r_categories')->whereIn('name', ['豚肉', '鶏肉', '牛肉', '鴨肉', '加工肉'])
            ->update(['group' => '肉']);

        // 魚介グループ
        DB::table('r_categories')->whereIn('name', ['鮭', '鯖', 'ぶり', '鯛', 'はんぺん', 'あさり'])
            ->update(['group' => '魚介']);

        // ご飯ものグループ
        DB::table('r_categories')->whereIn('name', ['丼もの', '炊き込み', '炒めもの', '雑炊'])
            ->update(['group' => 'ご飯もの']);

        // 麺グループ
        DB::table('r_categories')->whereIn('name', ['パスタ', 'うどん', 'やきそば', 'ラーメン', 'フォー', 'ビーフン'])
            ->update(['group' => '麺']);

        // サラダグループ
        DB::table('r_categories')->whereIn('name', ['温かいサラダ', '冷たいサラダ'])
            ->update(['group' => 'サラダ']);

        // スープグループ
        DB::table('r_categories')->whereIn('name', ['和風スープ', '中華スープ', 'コンソメスープ', 'トマトスープ', 'ポタージュ'])
            ->update(['group' => 'スープ']);

        // 副菜グループ
        DB::table('r_categories')->whereIn('name', ['ほうれん草', 'じゃがいも', 'きのこ', 'にんじん', '小松菜', '豆腐'])
            ->update(['group' => '副菜']);

        // パーティーグループ
        DB::table('r_categories')->whereIn('name', ['お祝い', '前菜', '大皿料理', 'おつまみ', 'お弁当'])
            ->update(['group' => 'パーティー']);
    }
}
