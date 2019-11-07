<?php

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
        DB::table('roles')
          ->insert(
              [
                  [
                      'id'         => 1,
                      'title'      => 'Администратор',
                      'badge_role' => 'badge-danger',
                  ],
                  [
                      'id'         => 2,
                      'title'      => 'Заблокированные',
                      'badge_role' => 'badge-secondary',
                  ],
                  [
                      'id'         => 3,
                      'title'      => 'Отчетник',
                      'badge_role' => 'badge-primary',
                  ],
                  [
                      'id'         => 4,
                      'title'      => 'Телемаркетолог',
                      'badge_role' => 'badge-warning',
                  ],
                  [
                      'id'         => 5,
                      'title'      => 'Аналитик',
                      'badge_role' => 'badge-warning',
                  ],
                  [
                      'id'         => 6,
                      'title'      => 'Редактор',
                      'badge_role' => 'badge-warning',
                  ],
                  [
                      'id'         => 7,
                      'title'      => 'Root',
                      'badge_role' => 'badge-dark',
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
