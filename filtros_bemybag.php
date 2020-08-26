<?php
/**
* Remove ship to differente address for default.  
*/
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );

/**
 * show newest product reviews on top
 * */

function newest_reviews_first($args) {
    $args['reverse_top_level'] = true;
    return $args;
}
add_filter( 'woocommerce_product_review_list_args', 'newest_reviews_first' );

/**
 * Change the separator title site
 **/
 function change_title_separator() {
  return '|';
}
add_filter( 'document_title_separator', 'change_title_separator' );

/**
 * Removes the attribute from the product title, in the cart.
 * 
 * @return string
 */
function remove_variation_from_product_title( $title, $cart_item, $cart_item_key ) {
	$_product = $cart_item['data'];
	$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

	if ( $_product->is_type( 'variation' ) ) {
		if ( ! $product_permalink ) {
			return $_product->get_title();
		} else {
			return sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() );
		}
	}

	return $title;
}
add_filter( 'woocommerce_cart_item_name', 'remove_variation_from_product_title', 10, 3 );

/**
 * Remove attributes from variations titles
 */
add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );

/**
 * Create new actions on order screen
 *  
 **/
 function adiciona_cancelar_acao_em_massa($actions)
 {
    $statuses = wc_get_order_statuses();
    foreach ($statuses as $key => $name) {
        $actions[ 'set-' . $key] = "Set status \"" . $name . "\"";
    }
    return $actions;
 } 
 add_filter( "bulk_actions-edit-shop_order", "adiciona_cancelar_acao_em_massa", 9 );


 function new_status(){
     // Make sure that we on "Woocomerce orders list" page
     if ( !isset($_GET['post_type']) || $_GET['post_type'] != 'shop_order' ) {
        return;
    }
    if ( isset($_GET['action']) && 'set-' === substr( $_GET['action'], 0, 4 ) ) {
        // Check Nonce
        if ( !check_admin_referer("bulk-posts") ) {
            return;
        }
        // Remove 'set-' from action
        $new_status =  substr( $_GET['action'], 4 );
        $posts = $_GET['post'];
        foreach ($posts as $postID) {
            if ( !is_numeric($postID) ) {
                continue;
            }
            $order = new WC_Order( (int)$postID );
            $order->update_status( $new_status, 'Bulk actions' );
        }
    }
 }

// Process Action
add_action( "admin_init", 'new_status', 0 );

/*add meta tag to the head*/
function add_wot()
{?>
   <meta name="wot-verification" content="{wot-codverification}"/>
<?php
}
add_action('wp_head', 'add_wot');
