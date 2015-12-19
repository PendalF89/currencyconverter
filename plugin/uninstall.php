<?php
// If uninstall is not called from WordPress, exit
if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option( \Korobochkin\Currency\Models\Settings\General::$option_name );
delete_option( 'currency_rates' );

delete_transient( \Korobochkin\Currency\Plugin::NAME . '_providers' );
