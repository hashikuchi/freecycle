<?php
/**
 * freecycle/app/app.php
 *
 * Functions called from the smartphone app.
 */
add_action('wp_ajax_get_nonce_from_app', 'get_nonce_from_app');
add_action('wp_ajax_nopriv_get_nonce_from_app', 'get_nonce_from_app');
/**
 * 認証用のnonceを取得します。
 */
function get_nonce_from_app(){
	$action = isset($_REQUEST["nonce_action"])?$_REQUEST["nonce_action"]:"";
	echo wp_create_nonce($action);
	die;
}
?>