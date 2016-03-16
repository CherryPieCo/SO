<?php

return array(
    'db' => array(
        'table' => 'example',
        'order' => array(
            'id' => 'DESC',
        ),
        'pagination' => array(
            'per_page' => array(
                20 => 20, 
                40 => 40, 
                60 => 60,
            ),
            'uri' => '/admin/ex',
        ),
    ),
    
    'options' => array(
        'caption' => 'example',
        'ident' => 'table-container',
        'form_ident' => 'table-form',
        'table_ident' => 'table-table',
        'action_url' => '/admin/ex',
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
        'name' => array(
            'caption' => 'name',
            'type' => 'text',
        ),
        'textarea' => array(
            'caption' => 'textarea',
            'type' => 'textarea',
        ),
        'select' => array(
            'caption' => 'select',
            'type' => 'select',
            'options' => array(
                'this' => 'this',
                'that' => 'that',
            ),
        ),
        'checkbox' => array(
            'caption' => 'checkbox',
            'type' => 'select',
            'options' => array(
                1 => 'Да',
                0 => 'Нет',
            ),
            'is_null' => true
        ),
        'wysiwyg' => array(
            'caption' => 'wysiwyg',
            'type' => 'wysiwyg',
            'wysiwyg' => 'redactor',
        ),
        'datetime' => array(
            'caption' => 'datetime',
            'type' => 'datetime',
        ),
        'date' => array(
            'caption' => 'date',
            'type' => 'text',
        ),
        'timestamp' => array(
            'caption' => 'timestamp',
            'type' => 'timestamp',
        ),
        'image' => array(
            'caption' => 'image',
            'type' => 'text',
        ),
        'images' => array(
            'caption' => 'images',
            'type' => 'text',
        ),
        'file' => array(
            'caption' => 'file',
            'type' => 'text',
        ),
        'color' => array(
            'caption' => 'color',
            'type' => 'text',
        ),
        'foreign_key' => array(
            'caption' => 'foreign_key',
            'type' => 'foreign',
            'foreign_table' => 'example',
            'foreign_key_field' => 'id',
            'foreign_value_field' => 'id', //change me
            'alias' => 'exampleexample',
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
