$(function() {
    'use strict';
    // Main contact form
    $('#contact').validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            message: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter your name",
                minlength: "Your name must consist of at least 2 characters"
            },
            email: {
                required: "Please enter your email address"
            },
            message: {
                required: "Please enter your message",
                minlength: "Your message must consist of at least 2 characters"
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                type:"POST",
                data: $(form).serializeArray(),
                url:"/create-account",
                success: function(response) {
                    
                    console.log(response);
                    if (response.status) {
                        $('#contact :input').attr('disabled', 'disabled');
                        $('#contact').fadeTo( "slow", 0.15, function() {
                            $(this).find(':input').attr('disabled', 'disabled');
                            $(this).find('label').css('cursor','default');
                            $('#success').fadeIn();
                        });
                        
                        //window.location = '/me/bulk';
                        $('#signUpModal').modal('show');
                    } else {
                        alert(response.error);
                    }
                    
                },
                error: function() {
                    $('#contact').fadeTo( "slow", 0.15, function() {
                        $('#error').fadeIn();
                    });
                }
            });
        }
    });
    
    // Signup form
    $('#signup').validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            name: {
                required: "Please enter your name",
                minlength: "Your name must consist of at least 2 characters"
            },
            email: {
                required: "Please enter your email address"
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                type:"POST",
                data: $(form).serializeArray(),
                url:"/create-account",
                success: function(response) {
                    if (response.status) {
                        window.location = '/me/bulk';
                    } else {
                        toastr.error(response.error);
                    }
                },
                error: function() {
                    $('#signup').fadeTo( "slow", 0.15, function() {
                        $('#error').fadeIn();
                    });
                }
            });
        }
    });
    
    $('#contactus-from').validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            name: {
                required: "Please enter your name"
            },
            email: {
                required: "Please enter your email address"
            },
            subject: {
                required: "Please enter subject"
            },
            text: {
                required: "Please enter your message"
            }
        },
        submitHandler: function(form) {
            var $form = $(form);
            jQuery.ajax({
                data: $form.serializeArray(),
                type: "POST",
                url: $form.attr('action'),
                cache: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        toastr.success('Your request has been sent successfully');
                    } else {
                        toastr.error('Something went wrong. Try later');
                    }
                }
            });
            return false;
        }
    });
    
    
    // Subscription form
    $('#subscribe').validate({
        rules: {
            subscribe_email: {
                required: true,
                email: true
            } 
        },
        messages: {
            subscribe_email: {
                required: "Please enter your email address"
            } 
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                type:"POST",
                data: $(form).serialize(),
                url:"inc/subscribe.php",
                success: function() {
                    $('#subscribe :input').attr('disabled', 'disabled');
                    $('#subscribe').fadeTo( "slow", 0.15, function() {
                        $(this).find(':input').attr('disabled', 'disabled');
                        $(this).find('label').css('cursor','default');
                        $('#success').fadeIn();
                    });
                },
                error: function() {
                    $('#subscribe').fadeTo( "slow", 0.15, function() {
                        $('#error').fadeIn();
                    });
                }
            });
        }
    });

});