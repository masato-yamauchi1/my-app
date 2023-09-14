<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('logics')->insert(
            [
              [
                'title' => 'テスト1',
                'graph_img_name' => 'test1.gif',
                'result_img_name' => 'test10.gif',
                'main_indicator_id' => '1',
                'sub_indicator_id' => '4',
                'logics_body' => 'ああああああああああああああああああああああ',
                'last_user' => 'user1',
                'created_at' => now(),
                'updated_at' => now(),
              ],
              [
                'title' => 'テスト2',
                'graph_img_name' => 'test2.gif',
                'result_img_name' => 'test20.gif',
                'main_indicator_id' => '2',
                'sub_indicator_id' => '5',
                'logics_body' => 'いいいいいいいいいいいいいいいいいいいい',
                'last_user' => 'user2',
                'created_at' => now(),
                'updated_at' => now(),
              ],
              [
                'title' => 'テスト3',
                'graph_img_name' => 'test3.gif',
                'result_img_name' => 'test30.gif',
                'main_indicator_id' => '3',
                'sub_indicator_id' => '6',
                'logics_body' => 'ううううううううううううううううううう',
                'last_user' => 'user3',
                'created_at' => now(),
                'updated_at' => now(),
              ],
            ]
          );
    }
}
