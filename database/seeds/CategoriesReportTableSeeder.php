<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoriesReportTableSeeder extends Seeder
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
        DB::table('categories_report')
          ->insert(
              [
                  [
                      'id'         => 1,
                      'code'       => 'crm',
                      'name'       => 'CRM',
                      'is_active'  => true,
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 2,
                      'code'       => 'oracle',
                      'name'       => 'ORACLE',
                      'is_active'  => true,
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 3,
                      'code'       => 'smscm',
                      'name'       => 'SMS Campaign Manager',
                      'is_active'  => true,
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'id'         => 4,
                      'code'       => 'ivr',
                      'name'       => 'IVR',
                      'is_active'  => true,
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
              ]
          )
        ;
    }
}
