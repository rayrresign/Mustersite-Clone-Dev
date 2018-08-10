<?php
// Formular Script Kontakt Rückrufservice
function check_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
//$empfaenger = 'info@resignstudios.ch';	
$empfaenger = get_option('res_kontaktdaten')['form_adress_reciever'];;	
$name = $bemerkung = $tel = '';


if(isset($_POST['absenden'])){					
	$name 			= check_input($_POST["name"]);
	$bemerkung 		= check_input($_POST["bemerkung"]);
	$tel 			= check_input($_POST["tel"]);
	
	if(!empty($name) && empty($_POST["res_hon"]) ){
		$url = $_SERVER['SERVER_NAME'];
		if($betreff == '') {
			$betreff = "Rückrufserviceformular ausgefüllt: ".$url;
		}
		
		$mailtext = "<html><head><title>Rückrufserviceformular ausgefüllt: $url</title></head>
		<body style='font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#666666;'>
		<p>Ihnen wurde eine Nachricht via Rückrufservice von $url gesendet:</p>
		<p><b>Name:</b> $name</p>
		<p><b>Telefon:</b> $tel</p> 
		<p><b>Bemerkung:</b> $bemerkung<br /></p>
		</body></html>";
		
//		$headers  = 'From: '.$name. "\r\n";
		$headers  = 'From: Ihr Rückruf-Formular <'.get_option('res_kontaktdaten')['form_adress_sender'].'>' . "\r\n";
		$headers .= 'Reply-To: <info@resignstudios.ch>' . "\r\n";
		$headers .= 'Return-Path: <info@resignstudios.ch>' . "\r\n";
		$headers .= "X-Mailer: PHP\n";
		$headers .= 'MIME-Version: 1.0' . "\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	
		
		mail($empfaenger, $betreff, $mailtext, $headers); 
		
		echo 'success';
	} else {
		echo 'fail';
	}
	exit();
}
?>
<!-- Ruckruf hidden -->
<section class="rueckruf well-top-md well-sm">
  <div class="container">
	<div class="row">
	  <h2 class="text-center">Rückrufservice</h2>
	  <p class="well-bottom-sm text-center">Wir werden Sie nach Erhalt Ihrer Nachricht schnellst möglich zurückrufen.</p>
	<form action="<?= $_SERVER['REQUEST_URI']; ?>" name="rueckrufservice" id="rueckrufservice" method="post">
	   <div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="form-group">
				<input type="text" class="form-control" name="name" id="ctaname" placeholder="Name" value="<?php echo $name; ?>"/>
			</div>
		</div>
		</div>
	  <div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="form-group">
				<input type="text" class="form-control" name="tel" id="ctatel" placeholder="Telefonnummer" value="<?php echo $tel; ?>"/>
			</div>
		</div>
	</div>
	 <div class="row well-bottom-sm">
		<div class="col-xs-12 col-sm-12">
			<div class="form-group">
				<input type="text" class="form-control" name="bemerkung" id="bemerkung" placeholder="Bemerkung" value="<?php echo $bemerkung; ?>"/>
			</div>
		</div>
	</div>
	<span style="position: absolute; left: -2000px;"><input name="res_hon" type="text" id="honey"/></span>
	<input type="hidden" name="form_name" value="overlayAnrufenForm"/> <!-- Value => ID Form -->
	<input name="absenden" type="hidden" value="" />
	<input type="submit" class="btn btn-secondary" id="absenden" value="senden" />
	</form>  
	</div>
  </div>

        <div id="kontakt-cta-phone-success" class="alert alert-success hidden">
            Das Formular wurde erfolgreich übermittelt. <i class="glyphicon glyphicon-ok text-success"></i> 
        </div>
		<div id="kontakt-cta-phone-fail" class="alert alert-fail hidden">
            Das Formular konnte nicht übermittelt werden. <i class="glyphicon glyphicon-ok text-warning"></i>
        </div>
       
<?php
function page_rueckrufservice_kontakt_function(){	
?>
 <script>
jQuery(document).ready(function($) {
	 $("#rueckrufservice").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },

        fields: {
            name: {
                row: '.form-group',
                validators: {
                    notEmpty: {
                        message: 'Name ist ein Pflichtfeld'
                    },
                    stringLength: {
                        min: 2,
                        max: 30,
                        message: 'Name ist ein Pflichtfeld (mind. 2 Zeichen)'
                    }
                }
            },
            tel: {
                row: '.form-group',
                validators: {
                    notEmpty: {
                        message: 'Telefonnummer ist ein Pflichtfeld'
                    },
                    regexp: {
                        regexp: /.*\d.[0-9]?/,
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
				   if (data.responseText.indexOf('success') >= 0) {
                    $('#kontakt-cta-phone-success').removeClass("hidden");
					}else{
						$('#kontakt-cta-phone-fail').removeClass("hidden");
					}
					$('#cta-overlayer').animate({scrollTop: $('#absenden').offset().top -100}, 1000);
				}
       		 });
		});
    });
</script>
<?php
}
add_action('wp_footer','page_rueckrufservice_kontakt_function');								 
?>								
</section>