/**
 * jQuery.ajax mid - CROSS DOMAIN AJAX 
 * ---
 * @author James Padolsey (http://james.padolsey.com)
 * @version 0.11
 * @updated 12-JAN-10
 * ---
 * Note: Read the README!
 * ---
 * @info http://james.padolsey.com/javascript/cross-domain-requests-with-jquery/
 */
 
 // mvaPost JS new edited by RESIGN. Don with Form_Validator - august 2016

jQuery.ajax = (function(_ajax){
    
    var protocol = location.protocol,
        hostname = location.hostname,
        exRegex = RegExp(protocol + '//' + hostname),
        YQL = 'http' + (/^https/.test(protocol)?'s':'') + '://query.yahooapis.com/v1/public/yql?callback=?',
        query = 'select * from html where url="{URL}" and xpath="*"';
    
    function isExternal(url) { 
        return !exRegex.test(url) && /:\/\//.test(url);
    }
    
    return function(o) {
        
        var url = o.url;
        
        if ( /get/i.test(o.type) && !/json/i.test(o.dataType) && isExternal(url) ) { 
            
            // Manipulate options so that JSONP-x request is made to YQL
            
            o.url = YQL;
            o.dataType = 'json';
            
            o.data = {
                q: query.replace(
                    '{URL}',
                    url + (o.data ?
                        (/\?/.test(url) ? '&' : '?') + jQuery.param(o.data)
                    : '')
                ),
                format: 'xml'
            };
            
            // Since it's a JSONP request
            // complete === success
            if (!o.success && o.complete) {
                o.success = o.complete;
                delete o.complete;
            }
            
            o.success = (function(_success){
                return function(data) {
                    
                    if (_success) {
                        // Fake XHR callback.
                        _success.call(this, {
                            responseText: (data.results[0] || '')
                                // YQL screws with <script>s
                                // Get rid of them
                                .replace(/<script[^>]+?\/>|<script(.|\s)*?\/script>/gi, '')
                        }, 'success');
                    }
                    
                };
            })(o.success);
            
        }
        
        return _ajax.apply(this, arguments);
        
    };
    
})(jQuery.ajax);

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
            },
            mobile: {
                row: '.form-group',
                validators: {
                    regexp: {
                        regexp: /^[\d\s]{10,25}|[+][\d\s]{10,25}$/,
                        message: 'Bitte geben Sie eine gültige Telefon Nummer ein'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {   // Formular send to Plugin Kontakte
		e.preventDefault();
		
		var send_id = escape($("#newsletter_send_id").val());
		
		if(send_id === 'mva'){
			var list_id = escape($("#newsletter_list_id").val());
			var form_id = escape($("#newsletter_form_id").val());
			var nachname = escape($("#newsletter_nachname").val());
			var vorname = escape($("#newsletter_vorname").val());
			var email = escape($("#newsletter_email").val());
			var mobile = escape($("#newsletter_mobile").val());

			$.ajax({
				url: 'https://nl.contentdrive.ch/nl.php?MailingListId=' + list_id + '&FormId=' + form_id + '&FormEncoding=iso-8859-1&u_LastName=' + nachname + '&u_FirstName=' + vorname + '&u_EMail=' + email + '&u_BusinessTelephone=' + mobile + '&Action=subscribe',
				success: function(res) {
					console.log(res);
					$('#mailing-alert-success').removeClass("hidden");
						setTimeout(function() {
							$('#newsletterbox').modal('hide');
						}, 9900);
				}
			});
		
		} else {
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
		
		}
	}); 
});	