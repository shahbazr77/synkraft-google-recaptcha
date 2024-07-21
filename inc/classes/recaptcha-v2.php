<?php
/**
** Recaptcha_V2
**/
if(!defined('ABSPATH')){
    return;
}

class Recaptcha_V2 {
    
    public function __construct(){
        
        $check_if_woo_is_on =     get_option('enable_captcha_on_woo_checkout');
        $show_on_woo_login_signup = get_option( 'check_woo_account_status' );
        $show_on_wp_signup_form = get_option( 'enable_captcha_on_signup_wp_form' );


        if(isset($check_if_woo_is_on) && $check_if_woo_is_on == 'on') {
            
            add_action('woocommerce_review_order_before_submit', array($this,'display_recaptcha_before_place_order_button' ));
        }

        if(isset($show_on_woo_login_signup) && $show_on_woo_login_signup == 'login') {
            
            add_action('woocommerce_login_form', array($this, 'display_recaptcha_on_Woo_Login_form'));
        }

        if(isset($show_on_woo_login_signup) && $show_on_woo_login_signup == 'signup'){
            
            add_action('woocommerce_register_form', array($this, 'display_recaptcha_on_woo_registration_form'));
        }

        if(isset($show_on_wp_signup_form) && $show_on_wp_signup_form  == 'on'){

            add_action('register_form', array($this, 'display_recaptcha_on_wp_registration_form'));
        }
    }
    

public function display_recaptcha() {
    $recaptcha_version = get_option('synkraft_google_recaptcha_version');
    ?>
    <div id="synkraft-recaptcha-container">
        <?php
        if ($recaptcha_version === 'recaptcha_v2') {
            $recaptcha_v2_site_key = get_option('synkraft_google_recaptcha_v2_key');
            ?>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <div class="g-recaptcha required-recaptcha" data-sitekey="<?php echo esc_attr($recaptcha_v2_site_key); ?>">
        
            <div class="recaptcha-error-message" style="color: red;"></div> 
            </div>
      
            <script>
                // Custom JavaScript to validate reCAPTCHA
                document.querySelector('#loginform').addEventListener('submit', function (event) {
                    var recaptchaResponse = document.querySelector('#g-recaptcha-response').value;
                    if (!recaptchaResponse) {
                        event.preventDefault(); // Prevent form submission

                        // Display the error message inside the reCAPTCHA container
                        var errorMessageElement = document.querySelector('.recaptcha-error-message');
                        errorMessageElement.textContent = 'Please complete the reCAPTCHA.';
                    }
                });
            </script>
            <?php
                }
            ?>
    </div>

    <?php
}


    function display_recaptcha_before_place_order_button() {
        $recaptcha_version = get_option('synkraft_google_recaptcha_version');
        if ($recaptcha_version === 'recaptcha_v2') {

         $recaptcha_v2_site_key = get_option('synkraft_google_recaptcha_v2_key');

            echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
            echo '<div class="g-recaptcha required-recaptcha" data-sitekey="' . esc_attr($recaptcha_v2_site_key) . '"></div>
            ';
            
        }
        ?>
        <div class="recaptcha-error-message" style="color: red;"></div>

        <script>
        // Custom JavaScript to validate reCAPTCHA on the checkout page
        document.querySelector('#order_review').addEventListener('click', function (event) {
            var recaptchaResponse = document.querySelector('.g-recaptcha-response').value;
            var errorMessageElement = document.querySelector('.recaptcha-error-message');
            if (!recaptchaResponse) {
                event.preventDefault(); // Prevent order placement
                errorMessageElement.textContent = 'Please complete the reCAPTCHA.';
            }
        });
    </script>
    <?php
    }

    
    public function display_recaptcha_on_Woo_Login_form() {
        $recaptcha_version = get_option('synkraft_google_recaptcha_version');
        if ($recaptcha_version === 'recaptcha_v2') {
            // Get the Recaptcha V2 site key from your plugin settings or replace it with your actual site key.
            $recaptcha_v2_site_key = get_option('synkraft_google_recaptcha_v2_key');
            
            // Output the Recaptcha V2 script and div element on the login form.
            echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
            echo '<div class="g-recaptcha required-recaptcha" data-sitekey="' . esc_attr($recaptcha_v2_site_key) . '"></div>';
        }
        ?>
        <div class="recaptcha-error-message" style="color: red;"></div>

        <script>
        // Custom JavaScript to validate reCAPTCHA on the checkout page
        document.querySelector('#order_review').addEventListener('click', function (event) {
            var recaptchaResponse = document.querySelector('.g-recaptcha-response').value;
            var errorMessageElement = document.querySelector('.recaptcha-error-message');
            if (!recaptchaResponse) {
                event.preventDefault(); // Prevent order placement
                errorMessageElement.textContent = 'Please complete the reCAPTCHA.';
            }
        });
    </script>
    <?php
    }

    public function display_recaptcha_on_woo_registration_form() {

        $recaptcha_version = get_option('synkraft_google_recaptcha_version');
        if ($recaptcha_version === 'recaptcha_v2') {
            $recaptcha_v2_site_key = get_option('synkraft_google_recaptcha_v2_key');
            
            echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
            echo '<div class="g-recaptcha required-recaptcha" data-sitekey="' . esc_attr($recaptcha_v2_site_key) . '"></div>';
        }
        ?>
        <div class="recaptcha-error-message" style="color: red;"></div>

        <script>
        // Custom JavaScript to validate reCAPTCHA on the checkout page
        document.querySelector('#order_review').addEventListener('click', function (event) {
            var recaptchaResponse = document.querySelector('.g-recaptcha-response').value;
            var errorMessageElement = document.querySelector('.recaptcha-error-message');
            if (!recaptchaResponse) {
                event.preventDefault(); // Prevent order placement
                errorMessageElement.textContent = 'Please complete the reCAPTCHA.';
            }
        });
    </script>
    <?php
    }

    function display_recaptcha_on_wp_registration_form() {
        $recaptcha_version = get_option('synkraft_google_recaptcha_version');
        
        if ($recaptcha_version === 'recaptcha_v2') {
            $recaptcha_v2_site_key = get_option('synkraft_google_recaptcha_v2_key');
            ?>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <div class="g-recaptcha required-recaptcha" data-sitekey="<?php echo esc_attr($recaptcha_v2_site_key); ?>"></div>
            <div class="recaptcha-error-message" style="color: red;"></div> <!-- Error message container -->
            <script>
                // Custom JavaScript to validate reCAPTCHA on the registration form
                document.querySelector('#registerform').addEventListener('submit', function (event) {
                    var recaptchaResponse = document.querySelector('.g-recaptcha-response').value;
                    var errorMessageElement = document.querySelector('.recaptcha-error-message');
                    if (!recaptchaResponse) {
                        event.preventDefault(); // Prevent form submission
                        errorMessageElement.textContent = 'Please complete the reCAPTCHA.';
                    }
                });
            </script>
            <?php
        }
    }
}