jQuery(document).ready(function($){
    function toggleInputFields() {
        var selectedOption = $('#recaptcha_version_select').val();

        if (selectedOption === 'recaptcha_v2') {
            $('#recaptcha_v2_site_key_field').css('display', 'block');
            $('#v2_notice_error').css('display', 'block');
            $('#g_recaptcha_v2_site_key').css('display', 'block');

            $('#v3_notice_error').css('display', 'none');
            $('#g_recaptcha_v3_site_key').css('display', 'none');
            $("#recaptcha_v2_site_key_field").prop("required", true);

            $('#recaptcha_v3_site_key_field').css('display', 'none');
            $("#recaptcha_v3_site_key_field").prop("required", false);

        } else if (selectedOption === 'recaptcha_v3') {
            $('#recaptcha_v2_site_key_field').css('display', 'none');
            $('#g_recaptcha_v2_site_key').css('display', 'none');
            $('#g_recaptcha_v3_site_key').css('display', 'block');
            $("#recaptcha_v2_site_key_field").prop("required", false);
            $('#v3_notice_error').css('display', 'block');
            $('#v2_notice_error').css('display', 'none');

            $('#recaptcha_v3_site_key_field').css('display', 'block');
            $("#recaptcha_v3_site_key_field").prop("required", true);

        }
    }

    toggleInputFields();

    $('#recaptcha_version_select').on('change', function() {
        toggleInputFields();
    });

    $('#add_captcha_fields').on('submit', function(e) {
        e.preventDefault();
        toggleInputFields();

        var g_recaptcha_v2_site_key = $('#g_recaptcha_v2_site_key').val();
        var g_recaptcha_v3_site_key = $('#g_recaptcha_v3_site_key').val();
        var selectedOptionValue = $('#show_on_woocommerce_pages').val();
        

        var recaptcha_version = $('#recaptcha_version_select').val();
        
        var isWooChecked = $('#woo_checkout_page_check').prop('checked');
        var isWooCheckedStatus = isWooChecked ? 'on' : 'off';

        var isUserLoginChecked = $('#show_on_user_login_form').prop('checked');
        var isUserLoginCheckedStatus = isUserLoginChecked ? 'on' : 'off';

       
        var isUserSignUpChecked = $('#show_on_user_signup_form').prop('checked');
        var isUserSignUpCheckedStatus = isUserSignUpChecked ? 'on' : 'off';

        var isWooLoginChecked = $('#show_on_woo_login').prop('checked');
        var isWooLoginCheckedStatus = isWooLoginChecked ? 'on' : 'off';
        
        var isWooSignUpChecked = $('#show_on_woo_signup').prop('checked');
        var isWooSignUpCheckedStatus = isWooSignUpChecked ? 'on' : 'off';
        
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'post',
            data: {
                action: 'update_recaptcha_version',
                recaptcha_version: recaptcha_version,
                v2_site_key: g_recaptcha_v2_site_key,
                v3_site_key: g_recaptcha_v3_site_key,
                check_woo_status: isWooCheckedStatus, 
                check_login_status: isUserLoginCheckedStatus,
                check_SignUp_status: isUserSignUpCheckedStatus, 
                check_woo_login: isWooLoginCheckedStatus, 
                check_woo_signup: isWooSignUpCheckedStatus, 
                check_selected_woo:selectedOptionValue, 
            },
            success: function(response) {
                // location.reload();
                console.log(response); 
                location.reload();
            },
            error: function(error) {
                console.log(error.responseText); 
            }
        });
    });

      var forms = document.querySelectorAll('form .required-recaptcha');
        
        // Hook into each form's submission event
        forms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (grecaptcha.getResponse() === '') {
                    event.preventDefault();
                    alert('Please complete the reCAPTCHA before proceeding.');
                }
            });
        });
    



  });