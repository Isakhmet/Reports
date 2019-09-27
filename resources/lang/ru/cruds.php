<?php

return [
    'manage'         => 'Управление',
    'userManagement' => [
        'title'          => 'Управление пользователями',
        'title_singular' => 'Управление пользователями',
    ],
    'permission'     => [
        'title'          => 'Доступы',
        'title_singular' => 'Доступ',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Название',
            'title_helper'      => '',
            'created_at'        => 'Создан',
            'created_at_helper' => '',
            'updated_at'        => 'Обновлен',
            'updated_at_helper' => '',
            'deleted_at'        => 'Удален',
            'deleted_at_helper' => '',
        ],
    ],
    'role'           => [
        'title'          => 'Роли',
        'title_singular' => 'Роль',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Название',
            'title_helper'       => '',
            'permissions'        => 'Разрешения',
            'permissions_helper' => '',
            'created_at'         => 'Создан',
            'created_at_helper'  => '',
            'updated_at'         => 'Обновлен',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Удален',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'           => [
        'title'          => 'Пользователи',
        'title_singular' => 'Пользователь',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Имя',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email верифицирован',
            'email_verified_at_helper' => '',
            'password'                 => 'Пароль',
            'password_helper'          => '',
            'roles'                    => 'Роль',
            'roles_helper'             => '',
            'remember_token'           => 'Токен',
            'remember_token_helper'    => '',
            'created_at'               => 'Создан',
            'created_at_helper'        => '',
            'updated_at'               => 'Обновлен',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Удален',
            'deleted_at_helper'        => '',
            'is_active'                => 'Активен',
            'is_active_helper'         => '',
        ],
        'roles_badges'   => 'badge-info',
    ],
    'root'           => [
        'users_view' => 'Просмотр всех пользователей',
    ],
];
