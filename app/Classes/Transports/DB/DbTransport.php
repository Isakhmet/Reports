<?php


namespace App\Classes\Transports\DB;


use App\Classes\Transports\Transport;
use PDO;

class DbTransport implements Transport
{

    /**
     * @return mixed
     */
    public function execute($type)
    {
        $config = config('database.connections.'.$type);
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";

        return new PDO($dsn, $config['username'], $config['password']);
    }
}
