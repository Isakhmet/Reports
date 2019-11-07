<?php//

use Illuminate\Database\Migrations\Migration;
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
        DB::table('permissions')
          ->insert(
              [
                  [
                      'id'    => 1,
                      'title' => 'user_management_access',
                  ],
                  [
                      'id'    => 2,
                      'title' => 'permission_create',
                  ],
                  [
                      'id'    => 3,
                      'title' => 'permission_edit',
                  ],
                  [
                      'id'    => 4,
                      'title' => 'permission_show',
                  ],
                  [
                      'id'    => 5,
                      'title' => 'permission_delete',
                  ],
                  [
                      'id'    => 6,
                      'title' => 'permission_access',
                  ],
                  [
                      'id'    => 7,
                      'title' => 'role_create',
                  ],
                  [
                      'id'    => 8,
                      'title' => 'role_edit',
                  ],
                  [
                      'id'    => 9,
                      'title' => 'role_show',
                  ],
                  [
                      'id'    => 10,
                      'title' => 'role_delete',
                  ],
                  [
                      'id'    => 11,
                      'title' => 'role_access',
                  ],
                  [
                      'id'    => 12,
                      'title' => 'user_create',
                  ],
                  [
                      'id'    => 13,
                      'title' => 'user_edit',
                  ],
                  [
                      'id'    => 14,
                      'title' => 'user_show',
                  ],
                  [
                      'id'    => 15,
                      'title' => 'user_delete',
                  ],
                  [
                      'id'    => 16,
                      'title' => 'user_access',
                  ],
                  [
                      'id'    => 17,
                      'title' => 'report_access',
                  ],
                  [
                      'id'    => 18,
                      'title' => 'root',
                  ],
                  [
                      'id'    => 19,
                      'title' => 'report_show',
                  ],
                  [
                      'id'    => 20,
                      'title' => 'report_create',
                  ],
                  [
                      'id'    => 21,
                      'title' => 'report_edit',
                  ],
                  [
                      'id'    => 22,
                      'title' => 'report_delete',
                  ],
                  [
                      'id'    => 23,
                      'title' => 'category_access',
                  ],
                  [
                      'id'    => 24,
                      'title' => 'category_create',
                  ],
                  [
                      'id'    => 25,
                      'title' => 'category_show',
                  ],
                  [
                      'id'    => 26,
                      'title' => 'category_edit',
                  ],
                  [
                      'id'    => 27,
                      'title' => 'category_delete',
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
