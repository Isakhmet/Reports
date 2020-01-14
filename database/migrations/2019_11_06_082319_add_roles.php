<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddRoles
 *
 * Класс добавляет стандартные
 * роли для админ-панели.
 */
class AddRoles extends Migration
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
        DB::table('roles')
          ->insert(
              [
                  [
                      'id'         => 1,
                      'title'      => 'Root',
                      'badge_role' => 'badge-dark',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
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
        DB::table('roles')
          ->where('id', '<=', 7)
          ->delete()
        ;
    }
}
