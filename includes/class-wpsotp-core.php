<?php

defined( 'ABSPATH' ) || exit;

/**
 * WPSOTP Core
 *
 * @class WPSOTP_Core
 */

class WPSOTP_Core {
    
    public static function create_otp( $user_id = null ) {

        global $wpdb;

        $otp = rand(1000,9999);

        do_action( 'wpsotp_otp_generated', $otp, $user_id);

        $hash = hash_hmac('md5', $otp, WPSOTP_HASH_KEY);

        // Prepare Expiry
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $valid_till = apply_filters( 'wpsotp_valid_till', $expiry ); 
            
        // Insert OTP Data
        $otp_id = $wpdb->insert( WPSOTP_DB_OTP_TABLE, array(
            "hmc_otp" => $hash,
            "user_id"=> $user_id,
            "valid_until" => $valid_till
        ));

        do_action( 'wpsotp_otp_generated_after');

        return $otp_id;
    }

    public static function verify_otp( $id, $otp ) {

        global $wpdb;

        $otp_r = $wpdb->get_row( "SELECT * FROM ".WPSOTP_DB_OTP_TABLE." WHERE id = " . $id );

        // Check OTP Expiration
        if ( (new DateTime($otp_r->valid_until)) < (new DateTime()) ) {
            do_action( 'wpsotp_otp_expired' );
            return false;
        }


        // Verify OTP
        if ( hash_hmac('md5', $otp, WPSOTP_HASH_KEY) === $otp_r->hmc_otp ) {
            do_action( 'wpsotp_otp_verified' );
            return true;
        }

        // Always return false;
        return false;

    }

}