<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class AddUsers
 *
 * Класс добавляет стандартных
 * пользователей для отчетной системы
 */
class AddUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
                  ],
                  [
                      'id'         => 2,
                      'name'       => 'Fedor Dorofeev',
                      'email'      => 'f.dorofeev@kredit24.kz',
                      'password'   => bcrypt('adminreport'),
                      'created_at' => $date,
                      'updated_at' => $date,
                  ],
                  [
                      'id'         => 3,
                      'name'       => 'Nickolay Babich',
                      'email'      => 'n.babich@prodengi.kz',
                      'password'   => bcrypt('adminreport'),
                      'created_at' => $date,
                      'updated_at' => $date,
                  ],
                  [
                      'id'         => 4,
                      'name'       => 'Bek Isakhmet',
                      'email'      => 'b.isakhmet@prodengi.kz',
                      'password'   => bcrypt('adminreport'),
                      'created_at' => $date,
                      'updated_at' => $date,
                  ],
                  [
                      'id'         => 5,
                      'name'       => 'Yerldaulet Bagdaulet',
                      'email'      => 'y.bagdaulet@prodengi.kz',
                      'password'   => bcrypt('adminreport'),
                      'created_at' => $date,
                      'updated_at' => $date,
                  ],
                  [
                      'id'         => 6,
                      'name'       => 'Reat Khabukhayev',
                      'email'      => 'r.khabukhayev@prodengi.kz',
                      'password'   => bcrypt('adminreport'),
                      'created_at' => $date,
                      'updated_at' => $date,
                  ],
              ]
          )
        ;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')
          ->where('id', '<=', 6)
          ->delete()
        ;
    }
}
