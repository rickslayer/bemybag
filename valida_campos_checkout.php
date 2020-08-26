<?php

/**
 * Filter to modify Woocommerce checkout fields
 */
function validate_checkout_fields( $fields ) {
    $fields['billing_phone']['required'] = true;
    $fields['billing_phone']['placeholder'] = '1134567891';
    $fields['billing_phone']['maxlength'] = '10';
    
    $fields['billing_cellphone']['required'] = true;
    $fields['billing_cellphone']['placeholder'] = '11999999999';
    $fields['billing_cellphone']['maxlength'] = '11';
    
    return $fields;
}
add_filter( 'woocommerce_billing_fields', 'validate_checkout_fields' );
