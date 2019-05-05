<?php


namespace App\Classes\Connectors;


use Illuminate\Support\Facades\App;

abstract class Connectors
{
    protected $transport = [
        'crm' => \App\Classes\Transports\DB\DbTransport::class,
        'oracle' => \App\Classes\Transports\DB\DbTransport::class,
        'sms' => \App\Classes\Transports\Http\HttpTransport::class
    ];

    protected $connect;

    public function connect($type){
        $this->connect = app($this->transport[$type])->execute($type);
    }

    public function getHttp($type){
        //
    }

    public function query($sql){
        $result = $this->connect->query($sql);

        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }
}
