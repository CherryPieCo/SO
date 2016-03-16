<?php

return array(
    'db' => array(
        'table' => 'packs',
        'order' => array(
            'id' => 'DESC',
        ),
        'pagination' => array(
            'per_page' => array(
                20 => 20, 
                40 => 40, 
                60 => 60,
            ),
            'uri' => '/admin/packs',
        ),
    ),
    
    'options' => array(
        'caption' => 'packs',
        'ident' => 'table-container',
        'form_ident' => 'table-form',
        'table_ident' => 'table-table',
        'action_url' => '/admin/packs',
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
                'pending' => 'pending',
                'process' => 'process',
                'complete' => 'complete',
            ),
        ),
        'data' => array(
            'caption' => 'data',
            'type' => 'textarea',
            'hide_list' => true,
            'is_readonly' => true,
            'rows' => 20
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
