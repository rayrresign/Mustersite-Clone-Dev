jQuery(document).ready(function($) {
	
	//  Mailing Kontakte Plugin	
	$("#res-footer-Mailing input").on('click', function(event) {
		event.preventDefault();
		$('#newsletterbox').modal('show');
	});
		
   // Mailing Footer Formular Validator
    $("#mailing-subscribe-form").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nachname: {
                row: '.form-group',
                validators: {
                    notEmpty: {
                        message: 'Nachname ist ein Pflichtfeld'
                    },
                    stringLength: {
                        min: 2,
                        max: 30,
                        message: 'Nachname ist ein Pflichtfeld (mind. 2 Zeichen)'
                    }
                }
            },
            email: {
                row: '.form-group',
                validators: {
                    notEmpty: {
                        message: 'Email ist ein Pflichtfeld'
                    },
                    regexp: {
                        regexp: /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i,
                        message: 'Bitte geben Sie eine gültige E-Mailadresse ein' 
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {   // Formular send to Plugin Kontakte
		e.preventDefault();
		var $form = $(this),
			url = $form.attr('action');
		$.post(url, $(this).serialize(),
			function(data) {
				console.log(data);
				$('#mailing-alert-success').removeClass("hidden");
				setTimeout(function() {
					$('#newsletterbox').modal('hide');
				}, 3000);
			}
		);
	});
});	