<?php

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
        DB::table('reports')
          ->insert(
              [
                  [
                      'id'          => 1,
                      'code'        => 'ivr_send',
                      'name'        => 'Отправка заявки',
                      'category_id' => 4,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 2,
                      'code'        => '60',
                      'name'        => 'Задания на обзвон',
                      'category_id' => 1,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 3,
                      'code'        => '38',
                      'name'        => 'Отчет по СМС',
                      'category_id' => 1,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 4,
                      'code'        => '37',
                      'name'        => 'Отказной трафик по Евразийскому банку',
                      'category_id' => 1,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 5,
                      'code'        => '36',
                      'name'        => 'Заявки в Евразийский банк',
                      'category_id' => 1,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 6,
                      'code'        => '35',
                      'name'        => 'Отчет LeadEffect',
                      'category_id' => 1,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 7,
                      'code'        => '34',
                      'name'        => 'Отправленные заявки (Детали 034)',
                      'category_id' => 1,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 8,
                      'code'        => 'score_values',
                      'name'        => 'Скоринг данные',
                      'category_id' => 2,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 9,
                      'code'        => 'score_points',
                      'name'        => 'Баллы скоринга',
                      'category_id' => 2,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 10,
                      'code'        => 'client',
                      'name'        => 'Данные по клиентам',
                      'category_id' => 2,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 11,
                      'code'        => 'cluster',
                      'name'        => 'Кластер',
                      'category_id' => 2,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 12,
                      'code'        => 'alfa_bank',
                      'name'        => 'AlfaBank',
                      'category_id' => 2,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 13,
                      'code'        => 'hcb_short',
                      'name'        => 'ХКБ лиды короткие',
                      'category_id' => 2,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 14,
                      'code'        => 'hcb_long',
                      'name'        => 'ХКБ лиды длинные',
                      'category_id' => 2,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 15,
                      'code'        => 'agency',
                      'name'        => '123Agency',
                      'category_id' => 2,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 16,
                      'code'        => 'incoming',
                      'name'        => 'Исходящие СМС',
                      'category_id' => 3,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 17,
                      'code'        => 'outgoing',
                      'name'        => 'Входящие СМС',
                      'category_id' => 3,
                      'is_active'   => true,
                  ],
                  [
                      'id'          => 18,
                      'code'        => '39',
                      'name'        => 'AlfaBank Landing',
                      'category_id' => 1,
                      'is_active'   => true,
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
