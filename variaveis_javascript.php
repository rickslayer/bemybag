<?php
/**
 * Create custom javascript variables to be access on frontend
 */
function variaveis_js() 
{
    $user_info = get_userdata(get_current_user_id());
    $data = array(
        "user_id_bemybag" => $user_info->user_email
    );
    
    wp_localize_script( 'custombmb', 'bmb', $data );
}

add_action( 'wp_enqueue_scripts', 'variaveis_js' );
