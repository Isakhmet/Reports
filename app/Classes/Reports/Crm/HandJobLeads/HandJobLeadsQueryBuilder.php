<?php

namespace App\Classes\Reports\Crm\HandJobLeads;

use App\Classes\Connectors\Connectors;

class HandJobLeadsQueryBuilder extends Connectors
{
    /** @var \Illuminate\Database\ConnectionInterface  */
    public $connect;

    /**
     * HandJobLeadsQueryBuilder constructor.
     */
    public function __construct()
    {
        $this->connect = $this->connect('crm');
    }

    /**
     * Выборка из БД лидов, отправленных в Сбербанк
     *
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function getSberLeads($from, $to)
    {
        $queryForSberLeads = $this->connect
            ->table('sber_leads')
            ->where('updated_at', '>=', $from . ' 00:00:00')
            ->where('updated_at', '<=', $to . ' 23:59:59')
            ->orderBy('updated_at')
            ->select(
                'created_at',
                'updated_at',
                'firstname',
                'lastname',
                'middlename',
                'mobile_phone',
                'iin',
                'product',
                'credit_amount',
                'delivery_town'
            )
        ;
        $sberLeads         = json_decode(
            json_encode(
                $queryForSberLeads->get()
                                  ->toArray()
            ), true
        );

        return $sberLeads;
    }

    /**
     * Выборка из БД лидов, отправленных в БЦК
     *
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function getBccLeads($from, $to)
    {
        $queryForBccLeads = $this->connect
            ->table('bcc_leads')
            ->where('updated_at', '>=', $from . ' 00:00:00')
            ->where('updated_at', '<=', $to . ' 23:59:59')
            ->orderBy('updated_at')
            ->select(
                'created_at',
                'updated_at',
                'name',
                'phone',
                'iinBin as iin',
                'productName'
            )
        ;
        $bccLeads         = json_decode(
            json_encode(
                $queryForBccLeads->get()
                                 ->toArray()
            ), true
        );

        return $bccLeads;
    }
}