<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class AddPermissions
 *
 * Класс добавляет стандартные
 * доступы для админ-панели.
 */
class AddPermissions extends Migration
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
        DB::table('permissions')
          ->insert(
              [
                  [
                      'id'         => 1,
                      'code'       => 'user_management_access',
                      'title'      => 'user_management_access',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 2,
                      'code'       => 'permission_create',
                      'title'      => 'permission_create',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 3,
                      'code'       => 'permission_edit',
                      'title'      => 'permission_edit',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 4,
                      'code'       => 'permission_show',
                      'title'      => 'permission_show',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 5,
                      'code'       => 'permission_delete',
                      'title'      => 'permission_delete',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 6,
                      'code'       => 'permission_access',
                      'title'      => 'permission_access',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 7,
                      'code'       => 'role_create',
                      'title'      => 'role_create',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 8,
                      'code'       => 'role_edit',
                      'title'      => 'role_edit',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 9,
                      'code'       => 'role_show',
                      'title'      => 'role_show',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 10,
                      'code'       => 'role_delete',
                      'title'      => 'role_delete',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 11,
                      'code'       => 'role_access',
                      'title'      => 'role_access',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 12,
                      'code'       => 'user_create',
                      'title'      => 'user_create',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 13,
                      'code'       => 'user_edit',
                      'title'      => 'user_edit',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 14,
                      'code'       => 'user_show',
                      'title'      => 'user_show',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 15,
                      'code'       => 'user_delete',
                      'title'      => 'user_delete',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 16,
                      'code'       => 'user_access',
                      'title'      => 'user_access',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 17,
                      'code'       => 'report_access',
                      'title'      => 'report_access',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 18,
                      'code'       => 'root',
                      'title'      => 'root',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 19,
                      'code'       => 'report_show',
                      'title'      => 'report_show',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 20,
                      'code'       => 'report_create',
                      'title'      => 'report_create',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 21,
                      'code'       => 'report_edit',
                      'title'      => 'report_edit',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 22,
                      'code'       => 'report_delete',
                      'title'      => 'report_delete',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 23,
                      'code'       => 'category_access',
                      'title'      => 'category_access',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 24,
                      'code'       => 'category_create',
                      'title'      => 'category_create',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 25,
                      'code'       => 'category_show',
                      'title'      => 'category_show',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 26,
                      'code'       => 'category_edit',
                      'title'      => 'category_edit',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 27,
                      'code'       => 'category_delete',
                      'title'      => 'category_delete',
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
        DB::table('permissions')
          ->where('id', '<=', 27)
          ->delete()
        ;
    }
}
