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
                      'code'       => 'crm',
                      'name'       => 'CRM',
                      'is_active'  => true,
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'code'       => 'oracle',
                      'name'       => 'ORACLE',
                      'is_active'  => true,
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'code'       => 'smscm',
                      'name'       => 'SMS Campaign Manager',
                      'is_active'  => true,
                      'created_at' => $date,
                      'updated_at' => $date,
                      'deleted_at' => null,
                  ],
                  [
                      'code'       => 'landings',
                      'name'       => 'Landings',
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
