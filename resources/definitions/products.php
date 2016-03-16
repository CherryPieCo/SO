<?php

return array(

    'db' => array(
        'table' => 'products',
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
        'caption' => 'Wines',
        'form_class'  => 'modal-lg', 
    ),
    
    'position' => array(
        'tabs' => array(
            'Info' => ['title', 'price', 'description', 'images'],
            'Attributes' => ['many2many_attributes'],
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
        'title' => array(
            'caption' => 'Title',
            'type'    => 'text',
        ),
        'price' => array(
            'caption' => 'Price',
            'type'    => 'text',
        ),
        'description' => array(
            'caption' => 'Description',
            'type'    => 'wysiwyg',
            'wysiwyg' => 'redactor',
        ),
        'images' => array(
            'caption' => 'Images',
            'type' => 'image',
            'is_multiple' => true,
            'cropp' => false,
            'width' => '.',
        ),
        'many2many_attributes' => array(
            'caption'   => '',
            'type'      => 'many_to_many',
            'show_type' => 'extra',
            'hide_list' => true,
            'mtm_table'                      => 'product_attrs', // filials2services
            'mtm_key_field'                  => 'id_product',  // filials2catalog.id_filial
            'mtm_external_foreign_key_field' => 'id',         // services.id
            'mtm_external_key_field'         => 'id_attribute', // filials2services.id_service
            'mtm_external_value_field'       => 'name',       // services.name
            'mtm_external_table'             => 'attributes',
            'extra_fields' => array(
                'value' => array(  // filials2services.price
                    'caption' => 'Value',
                    'type'    => 'text',
                )
            ),
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