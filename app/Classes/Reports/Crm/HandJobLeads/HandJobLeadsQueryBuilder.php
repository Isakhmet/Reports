<?php

namespace App\Classes\Reports\Crm\HandJobLeads;

use App\Classes\Connectors\Connectors;

class HandJobLeadsQueryBuilder extends Connectors
{
    /** @var int  */
    const SUCCESS_STATUS = 3;

    /** @var \Illuminate\Database\ConnectionInterface */
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
            ->where('status_id', '=', self::SUCCESS_STATUS)
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
            ->where('status_id', '=', self::SUCCESS_STATUS)
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

    /**
     * Выборка из БД лидов, отправленных в ХКБ
     *
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function getHcbLeads($from, $to)
    {
        $queryForHcbLeads = $this->connect
            ->table('hcb_leads')
            ->leftJoin('crm_product', 'hcb_leads.product_id', '=', 'crm_product.id')
            ->where('hcb_leads.updated_at', '>=', $from . ' 00:00:00')
            ->where('hcb_leads.updated_at', '<=', $to . ' 23:59:59')
            ->where('hcb_leads.status_id', '=', self::SUCCESS_STATUS)
            ->orderBy('hcb_leads.updated_at')
            ->select(
                'hcb_leads.created_at',
                'hcb_leads.updated_at',
                'hcb_leads.firstname',
                'hcb_leads.lastname',
                'hcb_leads.middlename',
                'hcb_leads.mobile_phone',
                'hcb_leads.iin',
                'crm_product.name as product',
                'hcb_leads.city'
            )
        ;
        $hcbLeads         = json_decode(
            json_encode(
                $queryForHcbLeads->get()
                                 ->toArray()
            ), true
        );

        return $hcbLeads;
    }

    /**
     * Выборка из БД лидов, отправленных в Альфа Банк
     *
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function getAlfaLeads($from, $to)
    {
        $queryForAlfaLeads = $this->connect
            ->table('alfa_leads')
            ->where('updated_at', '>=', $from . ' 00:00:00')
            ->where('updated_at', '<=', $to . ' 23:59:59')
            ->where('status_id', '=', self::SUCCESS_STATUS)
            ->orderBy('updated_at')
            ->select(
                'created_at',
                'updated_at',
                'name',
                'phone',
                'iin',
                'town'
            )
        ;
        $alfaLeads         = json_decode(
            json_encode(
                $queryForAlfaLeads->get()
                                  ->toArray()
            ), true
        );

        return $alfaLeads;
    }

    /**
     * Выборка из БД лидов, отправленных в Форте Банк
     *
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function getForteLeads($from, $to)
    {
        $queryForForteLeads = $this->connect
            ->table('forte_leads')
            ->where('updated_at', '>=', $from . ' 00:00:00')
            ->where('updated_at', '<=', $to . ' 23:59:59')
            ->where('status_id', '=', self::SUCCESS_STATUS)
            ->orderBy('updated_at')
            ->select(
                'created_at',
                'updated_at',
                'first_name',
                'last_name',
                'middle_name',
                'phone',
                'iin',
                'product',
                'amount',
                'region'
            )
        ;
        $forteLeads         = json_decode(
            json_encode(
                $queryForForteLeads->get()
                                  ->toArray()
            ), true
        );

        return $forteLeads;
    }
}