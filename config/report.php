<?php

return [
    'crm' => [
        'type' => 'db',
        34     => \App\Classes\Reports\Crm\SendLeads::class,
        35     => \App\Classes\Reports\Crm\LeadEffectReport::class,
        36     => \App\Classes\Reports\Crm\EuBankRequests::class,
        37     => \App\Classes\Reports\Crm\EuBankFailedTraffic::class,
        60     => \App\Classes\Reports\Crm\CallTasks::class,
        38     => \App\Classes\Reports\Crm\SMS::class
    ],
    'oracle' => [
        'cluster'      => App\Classes\Reports\Oracle\Cluster\Cluster::class,
        'alfa_bank'    => App\Classes\Reports\Oracle\AlfaBank::class,
        'score_points' => App\Classes\Reports\Oracle\ScorePoints\ScorePoints::class,
        'score_values' => App\Classes\Reports\Oracle\ScoreValues\ScoreValues::class,
        'client'       => App\Classes\Reports\Oracle\ScoreClients\ScoreClients::class,
        'hcb_long'     => App\Classes\Reports\Oracle\Hcb\Long\HcbLong::class,
        'hcb_short'    => App\Classes\Reports\Oracle\Hcb\Short\HcbShort::class,
        'agency'       => App\Classes\Reports\Oracle\Delayed\Okzaim::class,
    ],
    'sms' => [
        'outgoing' => App\Classes\Reports\SmsCampaignManager\Outgoing\Outgoing::class,
        'incoming' => App\Classes\Reports\SmsCampaignManager\Incoming\Incoming::class
    ],
    'ivr' => [
        'ivr_send' => App\Classes\Reports\IVR\SendRequests\SendRequests::class,
    ]
];
