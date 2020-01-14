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
                  ]
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
