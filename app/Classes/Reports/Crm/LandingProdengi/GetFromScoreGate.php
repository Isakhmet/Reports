<?php

namespace App\Classes\Reports\Crm\LandingProdengi;

use App\Classes\Connectors\Connectors;

/**
 * Class GetFromScoreGate
 *
 * @package App\Classes\Reports\Crm\LandingProdengi
 */
class GetFromScoreGate extends Connectors
{
    public $connection;

    public $leadGateClass;

    public $translator;

    public $statusesLeads = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];


    /**
     * GetFromScoreGate constructor.
     */
    public function __construct()
    {
        $this->leadGateClass = new GetFromLeadGate();
        $this->translator    = new LandingProdengiTranslator();
        $this->connection    = $this->connect('score_gate');
    }


    /**
     * Получение заявок с базы ScoreGate
     *
     * @param $from
     * @param $to
     *
     * @return array
     */
    public function getData($from, $to)
    {
        $leadResult           = [];
        $leadGateLeads     = [];
        $anotherStatusesLeads = [];

        $leads = $this->queryToLeadsTable($this->statusesLeads, $from, $to);
        foreach ($leads as $lead) {
            if ($lead['status'] === "8" || $lead['status'] === "9" || $lead['status'] === "10" || $lead['status'] === "11" || $lead['status'] === "12" || $lead['status'] === "13") {
                $leadGateLeads[] = $lead;
            } else {
                $anotherStatusesLeads[] = $lead;
            }
        }

        $readyLeadGateLeads = $this->leadGateClass->getData($leadGateLeads);

        foreach ($readyLeadGateLeads as $key => $value) {
            if (isset($value['source']) && isset($value['sender'])) {
                unset($value['id'], $value['lead_id']);
                array_push($leadResult, $value);
            } else {
                unset($value['id'], $value['lead_id']);
                $value['source']           = '---';
                $value['sender']           = '---';
                $value['status_lead_gate'] = 'Обрабатывается';
                array_push($leadResult, $value);
            }
        }

        if (!empty($anotherStatusesLeads)) {

            foreach ($anotherStatusesLeads as $key => $value) {
                unset($value['id']);
                $value['source']        = '-';
                $value['sender']        = '-';
                $value['statusRequest'] = '-';
                array_push($leadResult, $value);
            }
        }

        $translate  = $this->translator->translateScoreGateStatus($leadResult);
        $leadResult = $translate;

        return $leadResult;
    }

    /**
     * Запрос в ScoreGate с передачей статуса
     *
     * @param $statusIds
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function queryToLeadsTable(array $statusIds, $from, $to)
    {
        $query = $this->connection
            ->table('leads')
            ->whereIn('status', $statusIds)
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->select(
                'id',
                'name',
                'iin',
                'phone',
                'city',
                'status',
                'created_at',
                'updated_at'
            )
        ;

        return json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
    }

}