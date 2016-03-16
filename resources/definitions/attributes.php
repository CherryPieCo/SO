<?php

return array(

    'db' => array(
        'table' => 'attributes',
        'order' => array(
            'id' => 'DESC',
        ),
        'pagination' => array(
            'per_page' => [
                12 => 12, 
                24 => 24, 
                50 => 50
            ],
        ),
    ),
    'options' => array(
        'caption' => 'Wine Attributes',
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
        'name' => array(
            'caption' => 'Title',
            'type'    => 'text',
            'filter' => 'text',
            'is_sorting' => true,
        ),
    ),
    
    'actions' => array(
        'search' => array(
            'caption' => 'Поиск',
        ),
        'insert' => array(
            'caption' => 'Добавить',
        ),
        'update' => array(
            'caption' => 'Редактировать',
        ),
        'delete' => array(
            'caption' => 'Удалить',
        ),
    ),
    
);