<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->delete();

        DB::table('menus')->insert([
            'title' => 'Главная',
            'path' => '/',
            'parent_id' => 0,
        ]);

        DB::table('menus')->insert([
            'title' => 'Блог',
            'path' => 'articles',
            'parent_id' => 0,
        ]);

        DB::table('menus')->insert([
            'title' => 'О нас',
            'path' => 'o_nas',
            'parent_id' => 0,
        ]);

        DB::table('menus')->insert([
            'title' => 'Компьютеры',
            'path' => 'computers',
            'parent_id' => 2,
        ]);

        DB::table('menus')->insert([
            'title' => 'Интересное',
            'path' => 'interesting',
            'parent_id' => 2,
        ]);

        DB::table('menus')->insert([
            'title' => 'Советы',
            'path' => 'soveti',
            'parent_id' => 4,
        ]);

        DB::table('menus')->insert([
            'title' => 'Портфолио',
            'path' => 'portfolio',
            'parent_id' => 3,
        ]);

        DB::table('menus')->insert([
            'title' => 'Контакты',
            'path' => 'contacts',
            'parent_id' => 3,
        ]);

        DB::table('menus')->insert([
            'title' => 'Вкладка1',
            'path' => 'vkl1',
            'parent_id' => 8,
        ]);

        DB::table('menus')->insert([
            'title' => 'Вкладка2',
            'path' => 'vkl2',
            'parent_id' => 9,
        ]);

        DB::table('menus')->insert([
            'title' => 'Вкладка3',
            'path' => 'vkl3',
            'parent_id' => 10,
        ]);

        DB::table('menus')->insert([
            'title' => 'PregReplace',
            'path' => 'pregtest',
            'parent_id' => 0,
        ]);


    }
}
