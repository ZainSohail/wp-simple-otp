<?php

defined( 'ABSPATH' ) || exit;

/**
 * WPSOTP Rest API Calls
 *
 * @class WPSOTP_Core
 */

class WPSOTP_Rest {
    
    public function __construct( $api_version, $base, $namespace ) {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
    * Register the routes for the objects of the controller.
    */
    public function register_routes() {

        $version    = WPSOTP_API_VERSION;
        $namespace  = WPSOTP_API_NAMESPACE;
        $base       = WPSOTP_API_BASE;

        register_rest_route( $namespace, '/' . $base . '/create_otp', array(
          array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'create_otp' ),
            'args'            => array(
              'user_id' => array(
                'validate_callback' => function($param, $request, $key) {
                  return is_string( sanitize_text_field($param) );
                },
                'required' => true
              )
            ),
          ),
        ) );

        register_rest_route( $namespace, '/' . $base . '/verify_otp', array(
          array(
            'methods'         => WP_REST_Server::READABLE,
            'callback'        => array( $this, 'verify_otp' ),
            'args'            => array(
              'id' => array(
                'validate_callback' => function($param, $request, $key) {
                  return is_string( sanitize_text_field($param) );
                },
                'required' => true
              ),
              'otp' => array(
                'validate_callback' => function($param, $request, $key) {
                  return is_string( sanitize_text_field($param) );
                },
                'required' => true
              )
            ),
          ),
        ) );
    }

    public function create_otp( $request ) {

        $user_id  = $request->get_param( 'user_id' );

        $wpsotp = new WPSOTP_Core();
        $data = $wpsotp->create_otp( $user_id );

        return self::sendResponse( 200, 'OTP Created', $data );

    }

    public function verify_otp( $request ) {

        $otp_id  = $request->get_param( 'id' );
        $otp  = $request->get_param( 'otp' );

        $wpsotp = new WPSOTP_Core();
        $r = $wpsotp->verify_otp( $otp_id, $otp );

        if ( $r )
            return self::sendResponse( 201, 'OTP Verified' );

        return self::sendResponse( 204, 'OTP Declined' );

    }

    public static function sendResponse($status, $message = null, $data = null) {
        $response_arr = array(
            'status'    => $status,
            'message'   => $message,
            'data'      => $data
        );
        return new WP_REST_Response( $response_arr, 200 );
    }
}

new WPSOTP_Rest();