<?php

namespace App\Classes\Reports\Crm\HandJobLeads;

use App\Classes\Reports\Report;

class HandJobLeads implements Report
{
    /** @var \App\Classes\Reports\Crm\HandJobLeads\HandJobLeadsQueryBuilder  */
    public $queryService;

    /** @var \App\Classes\Reports\Crm\HandJobLeads\HandJobLeadsTransformer  */
    public $transformerService;

    /**
     * HandJobLeads constructor.
     */
    public function __construct()
    {
        $this->queryService       = new HandJobLeadsQueryBuilder();
        $this->transformerService = new HandJobLeadsTransformer();
    }

    /**
     * Генерация отчета
     *
     * @param     $reportType
     * @param int $page
     * @param int $perPage
     * @param     $from
     * @param     $to
     *
     * @return mixed
     */
    public function report($reportType, $page, $perPage, $from, $to)
    {
        $querySberLeads    = $this->queryService->getSberLeads($from, $to);
        $queryBccLeads     = $this->queryService->getBccLeads($from, $to);
        $queryHcbLeads     = $this->queryService->getHcbLeads($from, $to);
        $queryAlfaLeads    = $this->queryService->getAlfaLeads($from, $to);
        $queryForteLeads    = $this->queryService->getForteLeads($from, $to);
        $queryEubankLeads    = $this->queryService->getEubankLeads($from, $to);
        $sberLeads         = $this->transformerService->transformSberLeads($querySberLeads);
        $bccLeads          = $this->transformerService->transformBccLeads($queryBccLeads);
        $hcbLeads          = $this->transformerService->transformHcbLeads($queryHcbLeads);
        $alfaLeads         = $this->transformerService->transformAlfaLeads($queryAlfaLeads);
        $forteLeads        = $this->transformerService->transformForteLeads($queryForteLeads);
        $eubankLeads        = $this->transformerService->transformEubankLeads($queryEubankLeads);
        $data              = $this->transformerService->generate($sberLeads, $bccLeads, $hcbLeads, $alfaLeads, $forteLeads, $eubankLeads);
        $paginatedData     = $this->transformerService->paginate($data, 15);
        $result            = json_decode(json_encode($paginatedData), true);
        $excel['data']     = json_decode(json_encode($data), true);
        $columns           = __('report.reports.handJobLeads.columns');
        $result['headers'] = array_values($columns);
        $excel['columns']  = $columns;
        $result['excel']   = $excel;

        return $result;
    }
}
