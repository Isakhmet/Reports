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
                      'id'          => 1,
                      'code'        => 'ivr_send_requests',
                      'name'       => 'Отправка заявки',
                      'category_id' => 4,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 2,
                      'code'        => 'crm_call_task',
                      'name'       => 'Задания на обзвон',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 3,
                      'code'        => 'crm_sms',
                      'name'       => 'Отчет по СМС',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 4,
                      'code'        => 'crm_eubank_failed_traffic',
                      'name'       => 'Отказной трафик по Евразийскому банку',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 5,
                      'code'        => 'crm_eubank_requests',
                      'name'       => 'Заявки в Евразийский банк',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 6,
                      'code'        => 'crm_lead_effect_report',
                      'name'       => 'Отчет LeadEffect',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 7,
                      'code'        => 'crm_send_leads',
                      'name'       => 'Отправленные заявки (Детали 034)',
                      'category_id' => 1,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 8,
                      'code'        => 'oracle_score_values',
                      'name'       => 'Скоринг данные',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 9,
                      'code'        => 'oracle_score_points',
                      'name'       => 'Баллы скоринга',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 10,
                      'code'        => 'oracle_score_clients',
                      'name'       => 'Данные по клиентам',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 11,
                      'code'        => 'oracle_cluster',
                      'name'       => 'Кластер',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 12,
                      'code'        => 'oracle_alfa_bank',
                      'name'       => 'AlfaBank',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 13,
                      'code'        => 'oracle_hcb_short',
                      'name'       => 'ХКБ лиды короткие',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 14,
                      'code'        => 'oracle_hcb_long',
                      'name'       => 'ХКБ лиды длинные',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 15,
                      'code'        => 'oracle_123_agency',
                      'name'       => '123Agency',
                      'category_id' => 2,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 16,
                      'code'        => 'sms_cm_incoming',
                      'name'       => 'Исходящие СМС',
                      'category_id' => 3,
                      'is_active'   => true,
                      'created_at'  => $date,
                      'updated_at'  => $date,
                      'deleted_at'  => null,
                  ],
                  [
                      'id'          => 17,
                      'code'        => 'sms_cm_outgoing',
                      'name'       => 'Входящие СМС',
                      'category_id' => 3,
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
