<?php
/**
 * Ajax endpoints to check status from Woocommerce cart
 */
function checkCart()
{
    $result = new stdClass(); 
    $result->success = true;
    $result->content = WC()->cart->get_cart_contents_count();
    
    wp_die(json_encode($result));
}
/**
 * Erase cart items
 */
function eraseCart()
{
    $result = new stdClass(); 
    try {

      WC()->cart->empty_cart();
      WC()->session->set('cart', array());
      $result->success = true;
      $result->message = "erase cart successul";

    } catch (Exception $e) {

      $result->success = false;
      $result->message = $e->getMessage();

    }
    wp_die(json_encode($result));

}
add_action('wp_ajax_checkCart', 'checkCart');
add_action('wp_ajax_nopriv_checkCart', 'checkCart');
add_action('wp_ajax_eraseCart', 'eraseCart');
add_action('wp_ajax_nopriv_eraseCart', 'eraseCart');