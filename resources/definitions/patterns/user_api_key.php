<?php

return array(

    'install' => function() {
        
    }, // end install
    
    'view' => array(
        'list' => function(array $row) {}, // end list
        
        'form' => function(array $row) { // empty if create form
            $user = \App\User::find($row['id']);
            $token = \JWTAuth::fromUser($user);
            
            $html = '<label class="label">Api key</label>
                <label class="textarea state-disabled"> 
                    <textarea rows="5" class="custom-scroll" disabled="disabled">'. $token .'</textarea>
                <label>';

            return $html;
        }, // end view
    ),
    
    'handle' => array(
        'insert' => function($idRow, $patternValue, $values) {}, // end insert
        
        'update' => function($idRow, $patternValue, $values) {}, // end update
        
        'delete' => function($idRow) {}, // end delete
    ),
    
);
