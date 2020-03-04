<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Class AddPermissionRole
 *
 * Класс добавляет стандартные
 * доступы к ролям для админ-панели.
 */
class AddPermissionRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permission_role')
          ->insert(
              [
                  [
                      'role_id'       => 1,
                      'permission_id' => 1,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 2,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 3,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 4,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 5,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 6,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 7,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 8,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 9,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 10,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 11,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 12,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 13,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 14,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 15,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 16,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 17,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 18,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 19,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 20,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 21,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 22,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 23,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 24,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 25,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 26,
                  ],
                  [
                      'role_id'       => 1,
                      'permission_id' => 27,
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
        DB::table('permission_role')
          ->where('role_id', '<=', 7)
          ->delete()
        ;
    }
}