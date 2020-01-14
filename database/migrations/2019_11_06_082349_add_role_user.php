<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Class AddRoleUser
 *
 * Класс добавляет стандартные
 * роли к пользователям для админ-панели.
 */
class AddRoleUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('role_user')
          ->insert(
              [
                  [
                      'user_id' => 1,
                      'role_id' => 1,
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
        DB::table('role_user')
          ->where('user_id', '<=', 6)
          ->delete()
        ;
    }
}
