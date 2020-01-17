<?php

return [
    'reports' => [
        'leadEffect'     => [
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
        'EuBankRequests' => [
            'headers' => [
                'iin'   => 'ИИН',
                'fio'   => 'ФИО',
                'phone' => 'Телефон',
                'date'  => 'Дата',
                'city'  => 'Город',
                'ga'    => 'Google Client Id',
                'score' => 'Прошел скоринг',
            ],
            'helper'  => [
                'a' => 1,
                'b' => 2,
                'c' => 3,
                'd' => 4,
                'e' => 5,
                'f' => 6,
            ],
        ],
        'scorePoints'    => [
            'headers' => [
                'id'           => 'ID',
                'created_at'   => 'Дата/Время',
                'iin'          => 'ИИН',
                'full_name'    => 'ФИО',
                'mobile_phone' => 'Телефон',
                'email'        => 'email',
                'ore'          => 'Руда',
                'products'     => 'Продукты',
                'ga'           => 'Google Client Id',
            ],
        ],
        'scoreValues'    => [
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
        'scoreClients'   => [
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
        'alfaBank'       => [
            'cities'   => [
                1  => "алматы",
                2  => "астана",
                3  => "актау",
                4  => "актобе",
                5  => "атырау",
                6  => "кокшетау",
                7  => "костанай",
                8  => "павлодар",
                9  => "экибастуз",
                10 => "петропавловск",
                11 => "уральск",
                12 => "усть-каменогорск",
                13 => "семей",
                14 => "шымкент",
                15 => "караганда",
            ],
            'columns'  => [
                'lead_id'    => 'Номер в оракуле',
                'status_id'  => 'Статус',
                'fio'        => 'ФИО',
                'phone'      => 'Телефон',
                'email'      => 'email',
                'iin'        => 'ИИН',
                'towns'      => 'Регион',
                'created_at' => 'Дата заявки',
            ],
            'statuses' => [
                1 => 'new',
                2 => 'processing',
                3 => 'sent',
                4 => 'failed',

            ],
        ],
        'sms'            => [
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
        'hcb'            => [
            'columns' => [
                'lead_id'                 => 'Номер в оракуле',
                'iin'                     => 'ИИН',
                'firstname'               => 'Имя',
                'lastname'                => 'Фамилия',
                'middlename'              => 'Отчество',
                'mobile_phone'            => 'Телефон',
                'amount'                  => 'Сумма',
                'monthly_income'          => 'Доход',
                'sales_place'             => 'Индекс города',
                'valid'                   => 'Прошла проверки',
                'failed'                  => 'Есть ли ошибки',
                'accepted'                => 'Выдан ли кредит',
                'send'                    => 'Отправлена ли заявка в ХКБ',
                'postback'                => 'Получили ли статус ответа',
                'partner_server_info'     => 'Ответ от сервера ХКБ',
                'partner_server_postback' => 'Postback от ХКБ',
                'created_at'              => 'Дата',
            ],
        ],
        'okzaim'         => [
            'columns' => [
                'lead_id'      => 'Номер в оракуле',
                'is_double'    => 'Дубль',
                'created_at'   => 'Дата создания',
                'send_at'      => 'Дата отправки',
                'status'       => 'Статус заявки',
                'iin'          => 'ИИН',
                'firstname'    => 'Имя',
                'lastname'     => 'Фамилия',
                'middlename'   => 'Отчество',
                'mobile_phone' => 'Телефон',
                'email'        => 'Email',
                'ore'          => 'Руда',
                'response'     => 'Проблема',
            ],

            'statuses' => [
                'new'        => 'Новая',
                'processing' => 'В обработке',
                'sent'       => 'Отправленно',
                'failed'     => 'Ошибка',
            ],
        ],
        'cluster'        => [
            'columns' => [
                'lead_id'    => 'Номер в оракуле',
                'iin'        => 'ИИН',
                'interval'   => 'Пенсионное отчисление в месяцах(Оракул)',
                'count'      => 'Количество поступления пенсионки',
                'amounts'    => 'Отчисление в месяцах',
                'created_at' => 'Дата заявки',
            ],
            'months'  => [
                "1"  => "Январь",
                "2"  => "Февраль",
                "3"  => "Март",
                "4"  => "Апрель",
                "5"  => "Май",
                "6"  => "Июнь",
                "7"  => "Июль",
                "8"  => "Август",
                "9"  => "Сентябрь",
                "10" => "Октябрь",
                "11" => "Ноябрь",
                "12" => "Декабрь",
            ],
        ],
        'handJobLeads'   => [
            'columns' => [
                'created_at'      => 'Дата регистрации',
                'updated_at'      => 'Дата отправки',
                'fio'             => 'ФИО',
                'mobile_phone'    => 'Телефон',
                'company_name'    => 'Компания',
                'iin'             => 'ИИН',
                'product'         => 'Продукт',
                'credit_amount'   => 'Сумма',
                'delivery_town'   => 'Регион',
                'utm_source_name' => 'Источник',
            ],
        ],
        'sendLeads'      => [
            'columns'          => [
                'send_product_date' => 'Дата отправки',
                'status'            => 'Статус отправки',
                'specialist'        => 'Специалист',
                'name_full'         => 'ФИО',
                'phone_mob'         => 'Мобильный',
                'company'           => 'Компания',
                'document_inn'      => 'ИИН',
                'product'           => 'Продукт',
                'amount_product'    => 'Сумма',
                'region'            => 'Регион',
                'audit_status'      => 'Аудит: Статус',
                'audit_name'        => 'Аудит: ФИО',
                'audit_date'        => 'Аудит: Дата изменения',
                'email'             => 'Email',
                'utm_source'        => 'Источник создания клиента',
                'ga'                => 'Google Client Id',
            ],
            'utmSourceDefault' => 'Входящий звонок',
        ],
        'callTask'       => [
            'columns' => [
                'id'               => 'id звонка',
                'client_id'        => 'id клиента',
                'request_id'       => 'id заявки',
                'created_datetime' => 'Дата создания',
                'name_full'        => 'ФИО',
                'document_inn'     => 'ИИН',
                'phone_mob'        => 'Мобильный',
                'region'           => 'Регион',
                'operator'         => 'Оператор',
                'creator'          => 'Создатель',
                'type'             => 'Тип задания',
                'status'           => 'Статус',
                'call_back'        => 'Когда перезвонить',
                'closed_datetime'  => 'Когда закрыта',
                'is_promise'       => 'Обещали позвонить',
                'comments'         => 'Комментарий',
                'product'          => 'Продукт',
                'company'          => 'Компания',
                'utm_source'       => 'Источник создания клиента',
            ],
        ],
    ],
];
