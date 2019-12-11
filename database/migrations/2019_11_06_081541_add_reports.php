<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddReports
 *
 * Класс добавляет стандартные
 * отчеты в отчетную систему
 */
class AddReports extends Migration
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
        DB::table('reports')
          ->insert(
              [
                  [
                      'id'          => 1,
                      'code'        => 'ivr_send',
                      'name'        => 'Отправка заявки',
                      'category_id' => 4,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 2,
                      'code'        => '60',
                      'name'        => 'Задания на обзвон',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 3,
                      'code'        => '38',
                      'name'        => 'Отчет по СМС',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 4,
                      'code'        => '37',
                      'name'        => 'Отказной трафик по Евразийскому банку',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 5,
                      'code'        => '36',
                      'name'        => 'Заявки в Евразийский банк',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 6,
                      'code'        => '35',
                      'name'        => 'Отчет LeadEffect',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 7,
                      'code'        => '34',
                      'name'        => 'Отправленные заявки (Детали 034)',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 8,
                      'code'        => 'score_values',
                      'name'        => 'Скоринг данные',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 9,
                      'code'        => 'score_points',
                      'name'        => 'Баллы скоринга',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 10,
                      'code'        => 'client',
                      'name'        => 'Данные по клиентам',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 11,
                      'code'        => 'cluster',
                      'name'        => 'Кластер',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 12,
                      'code'        => 'alfa_bank',
                      'name'        => 'AlfaBank',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 13,
                      'code'        => 'hcb_short',
                      'name'        => 'ХКБ лиды короткие',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 14,
                      'code'        => 'hcb_long',
                      'name'        => 'ХКБ лиды длинные',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 15,
                      'code'        => 'agency',
                      'name'        => '123Agency',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 16,
                      'code'        => 'incoming',
                      'name'        => 'Исходящие СМС',
                      'category_id' => 3,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 17,
                      'code'        => 'outgoing',
                      'name'        => 'Входящие СМС',
                      'category_id' => 3,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 18,
                      'code'        => 'alfa_bank_landing',
                      'name'        => 'AlfaBank Landing',
                      'category_id' => 5,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 19,
                      'code'        => '40',
                      'name'        => 'Ручная отправка',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
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
        DB::table('reports')
          ->where('id', '<=', 17)
          ->delete()
        ;
    }
}
