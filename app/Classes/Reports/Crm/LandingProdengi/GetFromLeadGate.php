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
     * @param $lead
     * @param $from
     * @param $to
     *
     * @return array
     */
    public function getData($lead, $from, $to)
    {
        $query = $this->connection
            ->table('income_requests as ir')
            ->leftJoin('income_request_fields as irf', 'irf.request_id', '=', 'ir.id')
            ->leftJoin('senders as snd', 'snd.id', '=', 'ir.sender_id')
            ->leftJoin('sources as src', 'src.id', '=', 'ir.source_id')
            ->leftJoin('statuses as sts', 'sts.id', '=', 'ir.status_id')
            ->where('irf.field_id', '=', 1)
            ->where('irf.value', '=', $lead['id'])
            ->select(
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
        $leads     = [];

        if (!empty($queryData)) {

            foreach ($queryData as $leadGateData) {
                $leads[] = array_merge_recursive($lead, $leadGateData);
            }
            $translate = $this->translator->translate($leads);
            $leads     = $translate;

        } else {
            $leads = $lead;
        }

        return $leads;
    }
}