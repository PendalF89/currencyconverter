<?php
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

// TODO: Написать деинсталятор

delete_option( 'currency' );
delete_option( 'currency_rates' );
delete_option( 'currency_rates_available' );

//delete_transient( \Korobochkin\Currency\Plugin::NAME . '_provider_rates_' .  );
//set_transient( Plugin::NAME . '_provider_rates_' . $info['id'], $prepare_transient, 24 * HOUR_IN_SECONDS );