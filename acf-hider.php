<?php
/*
Plugin Name: ACF Hider
Plugin URI: http://danielpost.com
Description: Hide Advanced Custom Fields from the WordPress admin menu.
Version: 1.0
Author: Daniel Post
Author URI: http://danielpost.com
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) exit;

class ACF_Hider {

    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }

    public function init() {
        // If ACF isn't installed/activated, don't do anything.
        // Additionally, if we're not on an admin page none of this is needed.
        if ( ! class_exists('acf') || ! is_admin() ) {
            return;
        }

        $this->hide_menu_item();
        $this->redirect();
    }

    public function hide_menu_item() {
        // Remove the ACF main item from the admin menu.
        add_filter( 'acf/settings/show_admin', '__return_false' );
    }

    public function redirect() {
        // If the user tries to access an ACF page directly, redirect them to the Dashboard.
        if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'acf-field-group' ) {
            wp_redirect( admin_url() );
            die();
        }
    }

}
new ACF_Hider();
