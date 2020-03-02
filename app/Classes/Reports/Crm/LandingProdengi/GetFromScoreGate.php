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

    /**
     * GetFromScoreGate constructor.
     */
    public function __construct()
    {
        $this->leadGateClass = new GetFromLeadGate();
        $this->connection    = $this->connect('score_gate');
    }


    /**
     * Получение заявок с базы ScoreGate
     * по статусам =>
     * "SEND_POSITIVE_LEAD_TO_BANK_FINISH" => 10 => approved traffic
     * "SEND_NEGATIVE_LEAD_TO_BANK_FINISH" => 13 => rejected traffic
     * "KK_APPROVED"                       => 17 => KK Выдал займ
     *
     * @param $from
     * @param $to
     *
     * @return array
     */
    public function getData($from, $to)
    {
        $leads           = [];
        $leadResult      = [];
        $approvedTraffic = $this->queryToLeadsTable(10, $from, $to);

        if ($approvedTraffic != null) {
            foreach ($approvedTraffic as $traffic) {
                $leads[] = $this->leadGateClass->getData($traffic, $from, $to);
            }
        } else {
            $approvedTraffic = [];
        }

        $rejectedTraffic = $this->queryToLeadsTable(13, $from, $to);

        if ($rejectedTraffic != null) {
            foreach ($rejectedTraffic as $traffic) {
                $leads[] = $this->leadGateClass->getData($traffic, $from, $to);
            }
        }

        foreach ($leads as $key => $value) {
            foreach ($value as $lead) {
                array_push($leadResult, $lead);
            }
        }

        $KKTraffic = $this->queryToLeadsTable(17, $from, $to);
        if ($KKTraffic != null) {
            foreach ($KKTraffic as $traffic) {
                $traffic['status_lead_gate'] = null;
                $traffic['source']           = null;
                $traffic['sender']           = null;
                $leads[]                     = $traffic;
                array_push($leadResult, $leads);
            }
        } else {
            $KKTraffic = [];
        }

        return $leadResult;
    }

    /**
     * Запрос в ScoreGate с передачей статуса
     *
     * @param $statusId
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function queryToLeadsTable($statusId, $from, $to)
    {
        $query = $this->connection
            ->table('leads')
            ->where('status', '=', $statusId)
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->select(
                'id',
                'name',
                'iin',
                'phone',
                'city',
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