<?php

namespace App\Classes\Reports\Crm\LandingProdengi;

use App\Classes\Connectors\Connectors;

/**
 * Class GetFromLeadGate
 *
 * @package App\Classes\Reports\Crm\LandingProdengi
 */
class GetFromLeadGate extends Connectors
{
    public $connection;

    public $translator;

    /**
     * GetFromLeadGate constructor.
     */
    public function __construct()
    {
        $this->connection = $this->connect('lead_gate');
        $this->translator = new LandingProdengiTranslator();
    }

    /**
     * @param $leads
     * @param $from
     * @param $to
     *
     * @return array
     */
    public function getData($leads)
    {
        $leadsIds = [];
        $leadGateLeads = [];

        foreach ($leads as $lead) {
            $leadsIds[] = $lead['id'];
        }

        $query = $this->connection
            ->table('income_requests as ir')
            ->leftJoin('income_request_fields as irf', 'irf.request_id', '=', 'ir.id')
            ->leftJoin('senders as snd', 'snd.id', '=', 'ir.sender_id')
            ->leftJoin('sources as src', 'src.id', '=', 'ir.source_id')
            ->leftJoin('statuses as sts', 'sts.id', '=', 'ir.status_id')
            ->where('irf.field_id', '=', 1)
            ->whereIn('irf.value', $leadsIds)
            ->select(
                'irf.value as lead_id',
                'src.name as source',
                'snd.name as sender',
                'sts.name as statusRequest'
            )
        ;

        $queryData = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        if (!empty($queryData)) {
            foreach ($queryData as $leadGateLead) {
                $leadGateLead['lead_id'] = intval($leadGateLead['lead_id']);
                foreach ($leads as $scoreGateLead) {
                    if ($leadGateLead['lead_id'] === $scoreGateLead['id']) {
                        $leadGateLeads[] = array_merge($scoreGateLead, $leadGateLead);
                    }
                }
            }
        }

        $translatedLeads = [];

        if (!empty($leadGateLeads)) {
            $translatedLeads = $this->translator->translate($leadGateLeads);
            }

        return $translatedLeads;
    }
}