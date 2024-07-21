jQuery(document).ready(function($){
    // alert("hello world");

    var forms = document.querySelectorAll('form');
        
    // Hook into each form's submission event
    forms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            // Check if the form contains a captcha
            var captcha = form.querySelector('.required-recaptcha');
            if (captcha) {

                // Check if the reCAPTCHA response is empty
                if (grecaptcha.getResponse(captcha.dataset.widgetid) === '') {
                    // If reCAPTCHA response is empty, prevent form submission and display an error message
                    event.preventDefault();
                    console.log('Please complete the reCAPTCHA before proceeding.');
                }
            }
        });
    });
    
  });