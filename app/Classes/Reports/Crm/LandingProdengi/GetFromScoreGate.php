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

    public $approvedStatuses = [8, 9, 10];

    public $rejectedStatuses = [11, 12, 13];

    public $anotherStatuses = [0, 1, 2, 3, 4, 5, 6, 7, 14, 15, 16, 17, 18, 19, 20];

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
        $leads      = [];
        $newLeads   = [];
        $leadResult = [];

        $approvedTraffic = $this->queryToLeadsTable($this->approvedStatuses, $from, $to);

        if ($approvedTraffic != null) {
            foreach ($approvedTraffic as $traffic) {
                $leads[] = $this->leadGateClass->getData($traffic, $from, $to);
            }
        } else {
            $approvedTraffic = [];
        }

        $rejectedTraffic = $this->queryToLeadsTable($this->rejectedStatuses, $from, $to);

        if ($rejectedTraffic != null) {
            foreach ($rejectedTraffic as $traffic) {
                $leads[] = $this->leadGateClass->getData($traffic, $from, $to);
            }
        }

        foreach ($leads as $key => $value) {
            foreach ($value as $lead) {
                if (isset($lead['source']) && isset($lead['sender'])) {
                    array_push($leadResult, $lead);
                } else {
                    $value['source']           = '---';
                    $value['sender']           = '---';
                    $value['status_lead_gate'] = 'Обрабатывается';
                    array_push($leadResult, $value);
                }
            }
        }

        $anotherLeads = $this->queryToLeadsTable($this->anotherStatuses, $from, $to);
        if ($anotherLeads != null) {

            foreach ($anotherLeads as $leads) {
                $leads['source']        = '-';
                $leads['sender']        = '-';
                $leads['statusRequest'] = '-';

                $newLeads[] = $leads;
            }
        } else {
            $anotherLeads = [];
        }

        foreach ($newLeads as $key => $value) {
            array_push($leadResult, $value);
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