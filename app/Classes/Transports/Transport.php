<?php


namespace App\Classes\Transports;


interface Transport
{
    /**
     * @return mixed
     */
    public function execute($type);
}
