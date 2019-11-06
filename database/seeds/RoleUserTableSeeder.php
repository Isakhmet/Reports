<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')
          ->insert(
              [
                  [
                      'user_id' => 1,
                      'role_id' => 7,
                  ],
                  [
                      'user_id' => 2,
                      'role_id' => 1,
                  ],
                  [
                      'user_id' => 3,
                      'role_id' => 1,
                  ],
                  [
                      'user_id' => 4,
                      'role_id' => 1,
                  ],
                  [
                      'user_id' => 5,
                      'role_id' => 1,
                  ],
                  [
                      'user_id' => 6,
                      'role_id' => 6,
                  ],
              ]
          )
        ;
    }
}
