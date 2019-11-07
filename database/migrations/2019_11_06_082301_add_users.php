<?php

use Illuminate\Database\Migrations\Migration;
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
        DB::table('users')
          ->insert(
              [
                  [
                      'id'       => 1,
                      'name'     => 'Root',
                      'email'    => 'root@prodengi.kz',
                      'password' => bcrypt('rootreport'),
                  ],
                  [
                      'id'       => 2,
                      'name'     => 'Fedor Dorofeev',
                      'email'    => 'f.dorofeev@kredit24.kz',
                      'password' => bcrypt('adminreport'),
                  ],
                  [
                      'id'       => 3,
                      'name'     => 'Nickolay Babich',
                      'email'    => 'n.babich@prodengi.kz',
                      'password' => bcrypt('adminreport'),
                  ],
                  [
                      'id'       => 4,
                      'name'     => 'Bek Isakhmet',
                      'email'    => 'b.isakhmet@prodengi.kz',
                      'password' => bcrypt('adminreport'),
                  ],
                  [
                      'id'       => 5,
                      'name'     => 'Yerldaulet Bagdaulet',
                      'email'    => 'y.bagdaulet@prodengi.kz',
                      'password' => bcrypt('adminreport'),
                  ],
                  [
                      'id'       => 6,
                      'name'     => 'Reat Khabukhayev',
                      'email'    => 'r.khabukhayev@prodengi.kz',
                      'password' => bcrypt('adminreport'),
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
