<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now()
                      ->format('Y-m-d H:i:s')
        ;
        DB::table('roles')
          ->insert(
              [
                  [
                      'id'         => 1,
                      'title'      => 'Администратор',
                      'badge_role' => 'badge-danger',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 2,
                      'title'      => 'Заблокированные',
                      'badge_role' => 'badge-secondary',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 3,
                      'title'      => 'Отчетник',
                      'badge_role' => 'badge-primary',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 4,
                      'title'      => 'Телемаркетолог',
                      'badge_role' => 'badge-warning',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 5,
                      'title'      => 'Аналитик',
                      'badge_role' => 'badge-warning',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 6,
                      'title'      => 'Редактор',
                      'badge_role' => 'badge-warning',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 7,
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
}
