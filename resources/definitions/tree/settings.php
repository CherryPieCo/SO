<?php

return array(
    'db' => array(
        'table' => 'settings',
        'soft_delete' => true,
        'order' => array(
            'id' => 'ASC',
        ),
        'pagination' => array(
            'per_page' => 12,
            //'uri' => '/admin/settings',
        ),
    ),
    
    'cache' => array(
        'keys' => ['settings'],
    ),
    
    'options' => array(
        'caption' => 'Settings',
        'ident' => 'settings-container',
        'form_ident' => 'settings-form',
        'table_ident' => 'settings-table',
        //'action_url' => '/admin/settings',
        //'handler' => 'Yaro\Jarboe\Helpers\TableHandlers\Settings',
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
            'caption' => 'Ident',
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => true,
            'validation' => array(
                'server' => array(
                    'rules' => 'required'
                ),
                'client' => array(
                    'rules' => array(
                        'required' => true
                    ),
                    'messages' => array(
                        'required' => 'The field is required'
                    )   
                )
            )
        ),
        'value' => array(
            'caption' => 'Value',
            'type' => 'image',
            'cropp' => true,
        ),
        'description' => array(
            'caption' => 'Description',
            'type' => 'image',
            'is_multiple'   => true,
            'img_attributes' => array(
                'ru' => array(
                    'caption' => 'ru',
                    'inputs' => array(
                        'oh' => array(
                            'caption' => 'Oh',
                            'type' => 'text',
                        ),
                        'hai' => array(
                            'caption' => 'Oh',
                            'type' => 'text',
                        ),
                    ),
                ),
                'en' => array(
                    'caption' => 'en',
                    'inputs' => array(
                        'oh' => array(
                            'caption' => 'Oh',
                            'type' => 'text',
                        ),
                        'hai' => array(
                            'caption' => 'Oh',
                            'type' => 'text',
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    'filters' => array(
    ),
    
    'actions' => array(
        'search' => array(
            'caption' => 'Search',
        ),
        'insert' => array(
            'caption' => 'Create',
            'check' => function() {
                return true;
            }
        ),
        'update' => array(
            'caption' => 'Update',
            'check' => function() {
                return true;
            }
        ),
        'delete' => array(
            'caption' => 'Remove',
            'check' => function() {
                return true;
            }
        ),
    ),
);