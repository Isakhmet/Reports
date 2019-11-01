<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now()
                      ->format('Y-m-d H:i:s')
        ;
        DB::table('users')
          ->insert(
              [
                  [
                      'id'         => 1,
                      'name'       => 'Root',
                      'email'      => 'root@prodengi.kz',
                      'password'   => bcrypt('rootreport'),
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 2,
                      'name'       => 'Fedor Dorofeev',
                      'email'      => 'f.dorofeev@kredit24.kz',
                      'password'   => bcrypt('adminreport'),
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 3,
                      'name'       => 'Nickolay Babich',
                      'email'      => 'n.babich@prodengi.kz',
                      'password'   => bcrypt('adminreport'),
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 4,
                      'name'       => 'Bek Isakhmet',
                      'email'      => 'b.isakhmet@prodengi.kz',
                      'password'   => bcrypt('adminreport'),
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 5,
                      'name'       => 'Yerldaulet Bagdaulet',
                      'email'      => 'y.bagdaulet@prodengi.kz',
                      'password'   => bcrypt('adminreport'),
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
              ]
          )
        ;
    }
}
