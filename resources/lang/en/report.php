<?php

return [
    'reports' => [
        'leadEffect'   => [
            'headers' => [
                'Дата_отправки',
                'Статус_отправки',
                'ФИО',
                'Мобильный',
                'ИИН',
                'Компания',
                'Продукт',
                'affiliate_id',
                'Сумма',
                'Валюта',
                'Регион',
                'id',
                'email',
            ],
        ],
        'scorePoints'  => [
            'headers' => [
                'id'           => 'ID',
                'created_at'   => 'Дата/Время',
                'iin'          => 'ИИН',
                'full_name'    => 'ФИО',
                'mobile_phone' => 'Телефон',
                'email'        => 'email',
                'ore'          => 'Руда',
                'products'     => 'Продукты',
            ],
        ],
        'scoreValues'  => [
            'columns' => [
                'id'           => 'ID',
                'created_at'   => 'Дата/Время',
                'iin'          => 'ИИН',
                'full_name'    => 'ФИО',
                'mobile_phone' => 'Телефон',
                'email'        => 'email',
                'ore'          => 'Руда',
                'products'     => 'Продукты',
            ],
        ],
        'scoreClients' => [
            'headers' => [
                'id'                 => 'ID',
                'created_at'         => 'Дата/Время',
                'iin'                => 'ИИН',
                'full_name'          => 'ФИО',
                'mobile_phone'       => 'Телефон',
                'email'              => 'email',
                'gender'             => 'Пол',
                'birthday'           => 'Дата рождения',
                'category_score'     => 'Скор баллы',
                'ore'                => 'Руда',
                'pass_score'         => 'Прошел скоринг по категории',
                'pass_score_product' => 'Прошел скоринг по продуктам',
                'products'           => 'Продукты',
                'gclid'              => 'Google Click ID',
            ],
        ],
        'sms'          => [
            'outgoing' => [
                'headers' => [
                    'Дата_отправки',
                    'Время отправки',
                    'Статус доставки',
                    'Автор',
                    'Номер отправителя',
                    'Номер получателя',
                    'Кол-во смс',
                    'Тариф',
                    'Сумма',
                    'Текст смс',
                ],
            ],
            'incoming' => [
                'headers' => [
                    'Дата_отправки',
                    'Время отправки',
                    'Номер отправителя',
                    'Номер получателя',
                    'Кол-во смс',
                    'Тариф',
                    'Сумма',
                    'Текст смс',
                ],
            ],
        ],
    ],
];
