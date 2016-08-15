<?php

return array(
    'db' => array(
        'table' => 'mozapi_accounts',
        'order' => array(
            'id' => 'DESC',
        ),
        'pagination' => array(
            'per_page' => array(
                20 => 20, 
                40 => 40, 
                60 => 60,
            ),
            'uri' => '/admin/moz',
        ),
    ),
    
    'options' => array(
        'caption' => 'mozapi_accounts',
        'ident' => 'table-container',
        'form_ident' => 'table-form',
        'table_ident' => 'table-table',
        'action_url' => '/admin/moz',
        'not_found' => 'NOT FOUND',
    ),
    
    'fields' => array(
        'id' => array(
            'caption' => '#',
            'type' => 'readonly',
            'class' => 'col-id',
            'width' => '1%',
            'hide' => true,
            'is_sorting' => true
        ),
        'status' => array(
            'caption' => 'status',
            'type' => 'select',
            'options' => array(
                'ok' => 'ok',
                'error' => 'error',
            ),
        ),
        'access_id' => array(
            'caption' => 'access_id',
            'type' => 'text',
        ),
        'secret_key' => array(
            'caption' => 'secret_key',
            'type' => 'text',
        ),
        'last_used_at' => array(
            'caption' => 'last_used_at',
            'type' => 'readonly',
        ),
        'error' => array(
            'caption' => 'error',
            'type' => 'textarea',
        ),

    ),
    
    'filters' => array(
    ),
    
    'actions' => array(
        'search' => array(
            'caption' => 'Поиск',
        ),
        'insert' => array(
            'caption' => 'Создать',
            'check' => function() {
                return true;
            }
        ),
        'update' => array(
            'caption' => 'Обновить',
            'check' => function() {
                return true;
            }
        ),
        'delete' => array(
            'caption' => 'Удалить',
            'check' => function() {
                return true;
            }
        ),
    ),
);
