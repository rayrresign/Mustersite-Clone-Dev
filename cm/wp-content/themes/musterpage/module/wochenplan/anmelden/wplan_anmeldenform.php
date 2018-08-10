<section class="kurs-formular">
<?php 
	global $vorname, $nachname, $ipost, $telefon;
?>
	
	<div id="courseInfos"></div>
	
<!-- Formular -->
        <form action="<?= $_SERVER['REQUEST_URI']; ?>" name="kursFormular" id="kursFormular" method="post">	
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                	<div class="form-group">
                     	<input type="text" class="form-control" name="vorname" id="vorname" placeholder="Vorname" value="<?php echo $vorname; ?>"/>
                    </div>
                </div>
			</div>  
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                	<div class="form-group">
                  		<input type="text" class="form-control" name="nachname" id="nachname" placeholder="Nachname" value="<?php echo $nachname; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                	<div class="form-group">
                  		<input type="text" class="form-control" name="ipost" id="ipost" placeholder="E-Mail" value="<?php echo $ipost; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                	<div class="form-group">
                  		<input type="tel"  class="form-control" name="telefon" id="telefon" placeholder="Telefon" value="<?php echo $telefon; ?>"/>
                    </div>
                </div>
            </div>  
			<input type="hidden" id="kursInfo" value="" name="courseinfo" />		  
			<input type="hidden" name="mailText" id="mailText"/>
			<input type="hidden" name="absenderName" id="absenderName"/>
			<input type="hidden" name="absenderMail" id="absenderMail"/>
            <span style="position: absolute; left: -2000px;"><input name="res_honing" type="text" id="honey"/></span>
             <input type="hidden" name="form_name" value="wplan_anmelden_form"/> <!-- Value => ID Form -->
            <input name="senden" type="hidden" value="" />
			<div class="text-right">
            	<input type="submit" class="btn btn-default" id="senden" value="absenden" />
			</div>
        </form>      

        <div id="kontakt-alert-success" class="alert alert-success hidden"> <i class="glyphicon glyphicon-ok text-success"></i> 
        </div>
		<div id="kontakt-alert-fail" class="alert alert-fail hidden"> <i class="glyphicon glyphicon-ok text-warning"></i>
        </div>
	
<?php
function kurs_anmeldung() {
?>
 <script>

jQuery(document).ready(function($) {
	
	 $("#kursFormular").formValidation({
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
			vorname: {
                row: '.form-group',
                validators: {
                    notEmpty: {
                        message: 'Vorname ist ein Pflichtfeld'
                    },
                    stringLength: {
                        min: 2,
                        max: 30,
                        message: 'Vorname ist ein Pflichtfeld (mind. 2 Zeichen)'
                    }
                }
            },
            ipost: {
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
            telefon: {
                row: '.form-group',
                validators: {
                    notEmpty: {
                        message: 'Telefon ist ein Pflichtfeld'
                    },
                    regexp: {
						regexp: /^(?:(?:|0{1,2}|\+{0,2})41(?:|\(0\))|0)([1-9]\d)(\d{3})(\d{2})(\d{2})$/,
                        message: 'Bitte geben Sie eine gültige Telefonnummer ein'
                    }
                }
            }
        }
    }).on('success.form.fv', function (e) {   // Formular send to Contact
            e.preventDefault();
            var $form = $(this), url = $form.attr('action');

			$.ajax({
				type:"post",
				url: url,
				data: $(this).serialize(),
				complete: function(data) {
				   if (data.responseText.indexOf('mail-success') >= 0) {
						$('#kontakt-alert-success').removeClass("hidden");	
					} else {
						$('#kontakt-alert-fail').removeClass("hidden");
					}
				}
       		 });
		});
});
</script>
<?php
}
add_action('wp_footer', 'kurs_anmeldung');
?>
	
	
</section>