<?php

return array(

    'db' => array(
        'table' => 'logs',
        'order' => array(
            'id' => 'DESC',
        ),
        'select_all' => true,
        'pagination' => array(
            'per_page' => [
                12 => 12, 
                24 => 24, 
                50 => 50
            ],
        ),
    ),
    'options' => array(
        'caption' => 'Логи приложения',
        'form_class'  => 'modal-lg', 
    ),
    
    'position' => array(
        'tabs' => array(
            'Info' => array(['exception', 'message'], ['file', 'line'], 'created_at', 'method'),
            'Trace' => array('trace'),
            'Server' => array('server'),
            'Session' => array('session'),
            'Cookie' => array('cookie'),
            'Headers' => array('headers'),
            'Request' => array('request'),
            'File' => array('file_request'),
            'Old' => array('old_request'),
        )
    ),
    
    'fields' => array(
        'id' => array(
            'caption' => '#',
            'type' => 'readonly',
            'class' => 'col-id',
            'width' => '1%',
            'is_sorting' => true,
            'hide' => true,
        ),
        'created_at' => array(
            'caption' => 'Создано',
            'type'    => 'readonly',
        ),
        'method' => array(
            'caption' => 'Метод',
            'type'    => 'readonly',
            'hide_list' => true,
        ),
        'trace' => array(
            'caption' => '',
            'type'    => 'code',
            'language' => '',
            'hide_list' => true,
        ),
        'server' => array(
            'caption' => '',
            'type'    => 'code',
            'hide_list' => true,
        ),
        'session' => array(
            'caption' => '',
            'type'    => 'code',
            'hide_list' => true,
        ),
        'cookie' => array(
            'caption' => '',
            'type'    => 'code',
            'hide_list' => true,
        ),
        'headers' => array(
            'caption' => '',
            'type'    => 'code',
            'hide_list' => true,
        ),
        'request' => array(
            'caption' => '',
            'type'    => 'code',
            'hide_list' => true,
        ),
        'file_request' => array(
            'caption' => '',
            'type'    => 'code',
            'hide_list' => true,
        ),
        'old_request' => array(
            'caption' => '',
            'type'    => 'code',
            'hide_list' => true,
        ),
        'exception' => array(
            'caption' => 'Исключение',
            'type'    => 'readonly',
            'filter' => 'text',
        ),
        'message' => array(
            'caption' => 'Сообщение',
            'type'    => 'readonly',
            'filter' => 'text',
        ),
        'url' => array(
            'caption' => 'URL',
            'type'    => 'readonly',
            'filter' => 'text',
        ),
        'file' => array(
            'caption' => 'Файл',
            'type'    => 'readonly',
            'hide_list' => true,
        ),
        'line' => array(
            'caption' => 'Строка',
            'type'    => 'readonly',
            'hide_list' => true,
        ),
    ),
    
    'actions' => array(
        'search' => array(
            'caption' => 'Поиск',
        ),
        'insert' => array(
            'caption' => 'Добавить',
            'check' => function() {
                return false;
            }
        ),
        'update' => array(
            'caption' => 'Редактировать',
        ),
        'delete' => array(
            'caption' => 'Удалить',
        ),
    ),
    
);