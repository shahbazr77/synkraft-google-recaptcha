<?php
/*
Plugin Name: Synkraft Google reCaptcha
Plugin URI: [Plugin URI]
Description: Adds Google reCaptcha for users while login
Version: 0.01
Author: login, login captcha, recaptcha,
Author URI: [Your Author URI]
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: syn-google-captcha-plugin
Requires at least:Recaptcha_Option_Page
Requires PHP:create_admin_page
*/
if(!defined('ABSPATH')){
    return;
}

class Google_Captcha_Main {
  
    public function __construct() {
        // Define constants.
        define('SGR_PLUGIN_DIR', plugin_dir_path(__FILE__));
        define('SGR_PLUGIN_URL', plugin_dir_url(__FILE__));

        // Include required files.
        require_once SGR_PLUGIN_DIR . 'inc/classes/recaptcha-option-page.php';
        $option_page = new Recaptcha_Option_Page();

        if(!class_exists('Google_Captcha_Main_pro')){
           
            require_once SGR_PLUGIN_DIR . 'inc/classes/recaptcha-v2.php';
            $recaptcha_v2 = new Recaptcha_V2();


          $check_if_woo_is_on =     get_option('enable_captcha_on_login_form');

            if(isset($check_if_woo_is_on) && $check_if_woo_is_on == 'on'){

                add_action('login_form', array($recaptcha_v2, 'display_recaptcha'));
            }

            // Enqueue scripts.
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_front_scripts'));
    
            // Localize Ajax URL.
            add_action('admin_enqueue_scripts', array($this, 'recaptcha_localize_ajax_url'));
            // require_once SGR_PLUGIN_DIR . 'inc/classes/recaptcha-v3.php';
            // $recaptcha_v3 = new Recaptcha_V3();
            // add_action('login_form', array($recaptcha_v3, 'display_recaptcha'));

        } 
    }

    public function enqueue_admin_scripts() {
        wp_enqueue_style('admin-captcha-styles', SGR_PLUGIN_URL . 'assets/css/admin-style.css');
        wp_enqueue_script('admin-captcha-scripts', SGR_PLUGIN_URL . 'assets/js/admin-scripts.js', array('jquery'), '1.0', true);
    }

    public function enqueue_front_scripts() {
        wp_enqueue_script('user-captcha-scripts', SGR_PLUGIN_URL . 'assets/js/user-scripts.js', array('jquery'), '1.0', true);
    }

    public function recaptcha_localize_ajax_url() {
        $ajax_nonce = wp_create_nonce('syn_recaptcha_nonce');

        wp_localize_script('admin-captcha-scripts', 'ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => $ajax_nonce,
        ));
    }
}

// Initialize the plugin.
$google_captcha_main = new Google_Captcha_Main();