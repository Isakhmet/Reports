<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddCategoriesReport
 *
 * Класс добавляет стандартные
 * категории для отчетной системы
 */
class AddCategoriesReport extends Migration
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories_report')
          ->where('id', '<=', 4)
          ->delete()
        ;
    }
}
