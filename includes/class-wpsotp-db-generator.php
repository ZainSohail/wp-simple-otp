<?php

defined( 'ABSPATH' ) || exit;

/**
 * Generate OTP Tables
 *
 * @class WPSOTP_GenerateTables
 */

class WPSOTP_GenerateTables {
    
    public function __construct() {
        self::create_tables();
    }

    private static function create_tables() {
        
        global $wpdb;

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        if ( !$wpdb->get_var( "SHOW TABLES LIKE" . WPSOTP_DB_OTP_TABLE ) ) {
            dbDelta( self::tables() );
        }
    }

    private static function tables() {
        global $wpdb;

        $collate = '';

        if ( $wpdb->has_cap( 'collation' ) ) {
            $collate = $wpdb->get_charset_collate();
        }

        $tables = "
            CREATE TABLE ".WPSOTP_DB_OTP_TABLE." (
              id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
              hmc_otp longtext NOT NULL,
              user_id INT UNSIGNED NULL,
              valid_until DATETIME NOT NULL,
              PRIMARY KEY  (id),
              UNIQUE KEY id (id)
            ) $collate;
        ";

        return $tables;
    }
}

new WPSOTP_GenerateTables();