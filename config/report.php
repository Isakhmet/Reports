<?php

return [
    'crm' => [
        'type' => 'db',
        34 => '',
        35 => \App\Classes\Reports\Crm\LeadEffectReport::class,
        60 => \App\Classes\Reports\Crm\CallTasks::class
    ],
    'oracle' => App\Classes\Connectors\OracleConnector::class
];
