<?php

return array(
    'db' => array(
        'table' => 'links',
        'order' => array(
            'id' => 'DESC',
        ),
        'pagination' => array(
            'per_page' => array(
                20 => 20, 
                40 => 40, 
                60 => 60,
            ),
            'uri' => '/admin/links',
        ),
    ),
    
    'options' => array(
        'caption' => 'links',
        'ident' => 'table-container',
        'form_ident' => 'table-form',
        'table_ident' => 'table-table',
        'action_url' => '/admin/links',
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
        'id_type' => array(
            'caption' => 'Type',
            'type' => 'foreign',
            'filter' => 'foreign',
            'foreign_table'       => 'links_types',
            'foreign_key_field'   => 'id',
            'foreign_value_field' => 'description',
        ),
        'phrase' => array(
            'caption' => 'phrase',
            'filter' => 'text',
            'type' => 'text',
        ),
        'anchor' => array(
            'caption' => 'anchor',
            'type' => 'checkbox',
            'is_null' => true,
        ),
        'url' => array(
            'caption' => 'url',
            'type' => 'checkbox',
            'is_null' => true,
        ),
        'content' => array(
            'caption' => 'content',
            'type' => 'checkbox',
            'is_null' => true,
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
