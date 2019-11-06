<?php

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
        DB::table('categories_report')
          ->insert(
              [
                  [
                      'id'   => 1,
                      'code' => 'crm',
                      'name' => 'CRM',
                  ],
                  [
                      'id'   => 2,
                      'code' => 'oracle',
                      'name' => 'ORACLE',
                  ],
                  [
                      'id'   => 3,
                      'code' => 'smscm',
                      'name' => 'SMS Campaign Manager',
                  ],
                  [
                      'id'   => 4,
                      'code' => 'ivr',
                      'name' => 'IVR',
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
