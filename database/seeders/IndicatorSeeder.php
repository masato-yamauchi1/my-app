<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //追記

class IndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('indicators')->insert(
            [
                [
                  'indicator_name' => 'test1',
                  'indicator_body' => 'インジケーターああああああああああああああああああああああ',
                  'last_user' => 'user1',
                  'created_at' => now(),
                  'updated_at' => now(),
                  'active' => true,
                ],
                [
                  'indicator_name' => 'test2',
                  'indicator_body' => 'インジケーターいいいいいいいいいいいいいいいいいいいいいい',
                  'last_user' => 'user2',
                  'created_at' => now(),
                  'updated_at' => now(),
                  'active' => true,
                ],
                [
                  'indicator_name' => 'test3',
                  'indicator_body' => 'インジケーターいいいいいいいいいいいいいいいいいいいいいい',
                  'last_user' => 'user3',
                  'created_at' => now(),
                  'updated_at' => now(),
                  'active' => true,
                ],
              ]
          );
    }
}
