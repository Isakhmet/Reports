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
                      'code'        => 'ivr_send_requests',
                      'title'       => 'Отправка заявки',
                      'category_id' => 4,
                  ],
                  [
                      'id'          => 2,
                      'code'        => 'crm_call_task',
                      'title'       => 'Задания на обзвон',
                      'category_id' => 1,
                  ],
                  [
                      'id'          => 3,
                      'code'        => 'crm_sms',
                      'title'       => 'Отчет по СМС',
                      'category_id' => 1,
                  ],
                  [
                      'id'          => 4,
                      'code'        => 'crm_eubank_failed_traffic',
                      'title'       => 'Отказной трафик по Евразийскому банку',
                      'category_id' => 1,
                  ],
                  [
                      'id'          => 5,
                      'code'        => 'crm_eubank_requests',
                      'title'       => 'Заявки в Евразийский банк',
                      'category_id' => 1,
                  ],
                  [
                      'id'          => 6,
                      'code'        => 'crm_lead_effect_report',
                      'title'       => 'Отчет LeadEffect',
                      'category_id' => 1,
                  ],
                  [
                      'id'          => 7,
                      'code'        => 'crm_send_leads',
                      'title'       => 'Отправленные заявки (Детали 034)',
                      'category_id' => 1,
                  ],
                  [
                      'id'          => 8,
                      'code'        => 'oracle_score_values',
                      'title'       => 'Скоринг данные',
                      'category_id' => 2,
                  ],
                  [
                      'id'          => 9,
                      'code'        => 'oracle_score_points',
                      'title'       => 'Баллы скоринга',
                      'category_id' => 2,
                  ],
                  [
                      'id'          => 10,
                      'code'        => 'oracle_score_clients',
                      'title'       => 'Данные по клиентам',
                      'category_id' => 2,
                  ],
                  [
                      'id'          => 11,
                      'code'        => 'oracle_cluster',
                      'title'       => 'Кластер',
                      'category_id' => 2,
                  ],
                  [
                      'id'          => 12,
                      'code'        => 'oracle_alfa_bank',
                      'title'       => 'AlfaBank',
                      'category_id' => 2,
                  ],
                  [
                      'id'          => 13,
                      'code'        => 'oracle_hcb_short',
                      'title'       => 'ХКБ лиды короткие',
                      'category_id' => 2,
                  ],
                  [
                      'id'          => 14,
                      'code'        => 'oracle_hcb_long',
                      'title'       => 'ХКБ лиды длинные',
                      'category_id' => 2,
                  ],
                  [
                      'id'          => 15,
                      'code'        => 'oracle_123_agency',
                      'title'       => '123Agency',
                      'category_id' => 2,
                  ],
                  [
                      'id'          => 16,
                      'code'        => 'sms_cm_incoming',
                      'title'       => 'Исходящие СМС',
                      'category_id' => 3,
                  ],
                  [
                      'id'          => 17,
                      'code'        => 'sms_cm_outgoing',
                      'title'       => 'Входящие СМС',
                      'category_id' => 3,
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
