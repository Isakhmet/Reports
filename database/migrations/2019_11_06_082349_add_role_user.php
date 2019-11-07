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
