<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
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
        DB::table('permissions')
          ->insert(
              [
                  [
                      'id'         => 1,
                      'title'      => 'user_management_access',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 2,
                      'title'      => 'permission_create',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 3,
                      'title'      => 'permission_edit',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 4,
                      'title'      => 'permission_show',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 5,
                      'title'      => 'permission_delete',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 6,
                      'title'      => 'permission_access',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 7,
                      'title'      => 'role_create',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 8,
                      'title'      => 'role_edit',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 9,
                      'title'      => 'role_show',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 10,
                      'title'      => 'role_delete',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 11,
                      'title'      => 'role_access',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 12,
                      'title'      => 'user_create',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 13,
                      'title'      => 'user_edit',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 14,
                      'title'      => 'user_show',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 15,
                      'title'      => 'user_delete',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 16,
                      'title'      => 'user_access',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 17,
                      'title'      => 'report_access',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 18,
                      'title'      => 'root',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 19,
                      'title'      => 'report_show',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 20,
                      'title'      => 'report_create',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 21,
                      'title'      => 'report_edit',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 22,
                      'title'      => 'report_delete',
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
              ]
          )
        ;
    }
}
