<?php

namespace App\Classes\Connectors;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

/**
 * Class Connectors
 *
 * @package App\Classes\Connectors
 */
abstract class Connectors
{
    /**
     * @param $type
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function connect($type){
        return DB::connection($type);
    }
}
