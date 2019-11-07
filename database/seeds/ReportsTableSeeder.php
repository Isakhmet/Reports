<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsTableSeeder extends Seeder
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
        DB::table('reports')
          ->insert(
              [
                  [
                      'code'        => 'ivr_send',
                      'name'        => 'Отправка заявки',
                      'category_id' => 4,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => '60',
                      'name'        => 'Задания на обзвон',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => '38',
                      'name'        => 'Отчет по СМС',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => '37',
                      'name'        => 'Отказной трафик по Евразийскому банку',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => '36',
                      'name'        => 'Заявки в Евразийский банк',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => '35',
                      'name'        => 'Отчет LeadEffect',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => '34',
                      'name'        => 'Отправленные заявки (Детали 034)',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => 'score_values',
                      'name'        => 'Скоринг данные',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => 'score_points',
                      'name'        => 'Баллы скоринга',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => 'client',
                      'name'        => 'Данные по клиентам',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => 'cluster',
                      'name'        => 'Кластер',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => 'alfa_bank',
                      'name'        => 'AlfaBank',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => 'hcb_short',
                      'name'        => 'ХКБ лиды короткие',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => 'hcb_long',
                      'name'        => 'ХКБ лиды длинные',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => 'agency',
                      'name'        => '123Agency',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => 'incoming',
                      'name'        => 'Исходящие СМС',
                      'category_id' => 3,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => 'outgoing',
                      'name'        => 'Входящие СМС',
                      'category_id' => 3,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'code'        => '39',
                      'name'        => 'AlfaBank Landing',
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
}
