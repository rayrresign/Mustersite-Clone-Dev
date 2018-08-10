<?php
// Formular Script CTA Kontakt
function check_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
//$empfaenger = 'info@resignstudios.ch';	
$empfaenger = get_option('res_kontaktdaten')['form_adress_reciever'];;	
$name = $ctaipost = $tel = $nachricht = $kontakt = '';

if(isset($_POST["abschicken"])){					
	$name 		= check_input($_POST["name"]);
	$ctaipost 		= check_input($_POST["ctaipost"]);
	$nachricht 	= check_input($_POST["nachricht"]);
	$tel 		= check_input($_POST["tel"]);
	$kontakt 	= check_input($_POST["kontakt"]);
	
	$emailRegex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
	
	$emailValid = preg_match($emailRegex, $ctaipost);
	
	if(!empty($name) && !empty($ctaipost) && empty($_POST["res_hon"]) && $emailValid){
		$url = $_SERVER['SERVER_NAME'];
		if($betreff == '') {
			$betreff = "Kontaktaufnahmeformular ausgefüllt: ".$url;
		}
		
		$mailtext = "<html><head><title>Kontaktaufnahmeformular ausgefüllt: $url</title></head>
		<body style='font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#666666;'>
		<p>Ihnen wurde eine Nachricht via Kontaktaufnahmeformular von $url gesendet:</p>
		<p><b>Name:</b> $name</p>
		<p><b>E-Mail:</b> $ctaipost<br /></p>
		<p><b>Kontakt:</b> $kontakt<br /></p>
		<p><b>Telefon:</b> $tel</p> 
		<p><b>Nachricht:</b> $nachricht</p> 
		</body></html>";
		
		$headers  = 'From: Ihr Kontaktformular <'.get_option('res_kontaktdaten')['form_adress_sender'].'>' . "\r\n";
		// $headers  = 'From: Ihr Kontaktformular <info@musterpage.ch>' . "\r\n";
		$headers .= 'Reply-To: <'.$ctaipost.'>' . "\r\n";
		$headers .= 'Return-Path: <'.$ctaipost.'>' . "\r\n";
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
<!-- Kontakt  -->
<section class="cta-message well-top-md well-sm">
  <div class="container">
	<div class="row">
	 <h2 class="text-center well-bottom-md">Kontakt aufnehmen</h2>
        <form action="<?= $_SERVER['REQUEST_URI']; ?>" name="kontaktCtaFormular" id="kontaktCtaFormular" method="post">			  
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                	<div class="form-group">
                     	<input type="text" class="form-control" name="name" id="ctaname" placeholder="Name" value="<?php echo $name; ?>"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                	<div class="form-group">
                  		<input type="text" class="form-control" name="ctaipost" id="ctaipost" placeholder="E-Mail" value="<?php echo $ctaipost; ?>"/>
                    </div>
                </div>
            </div>
			<div class="form-group">
				<textarea id="ctanachricht" class="form-control" rows="6" cols="10" name="nachricht" placeholder="Ihre Nachricht"><?php echo $nachricht; ?></textarea>
			</div>
			<div class="row">
				 <div class="checkbox well-sm">
					<div class="col-xs-12 col-sm-12">
						<label>
							<input id="telContact" type="checkbox" name="kontakt" value="Ich möchte telefonisch kontaktiert werden">
							<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span> Ich möchte telefonisch kontaktiert werden</label>
					</div> 
				</div>
			</div>
			<div class="row">
			<div class="form-group">
				<div class="col-xs-12 col-sm-12">
					<input type="text" class="form-control" name="tel" id="tel" placeholder="Telefon" value="<?php echo $tel; ?>"/>
				</div>	
			</div>
			</div>
            <span style="position: absolute; left: -2000px;"><input name="res_hon" type="text" id="honey"/></span>
			<input type="hidden" name="form_name" value="overlayKontaktForm"/> <!-- Value => ID Form -->
            <input name="abschicken" type="hidden" value="" />
			<div class="well">
			<input type="submit" class="btn btn-secondary" id="abschicken" value="Nachricht senden " />
			</div>
        </form> 
 	</div>
 </div>     

        <div id="kontaktCtaFormular-alert-success" class="alert alert-success hidden">
            Das Formular wurde erfolgreich übermittelt. <i class="glyphicon glyphicon-ok text-success"></i> 
        </div>
		<div id="kontaktCtaFormular-alert-fail" class="alert alert-fail hidden">
            Das Formular konnte nicht übermittelt werden. <i class="glyphicon glyphicon-ok text-warning"></i>
        </div>
       
<?php
function page_cta_kontakt_function(){	
?>
 <script>
jQuery(document).ready(function($) {	
	$("#telContact").change(function() {
		if(this.checked) {
			$('#kontaktCtaFormular > div:nth-child(5)').fadeIn();
		} else {
			$('#kontaktCtaFormular > div:nth-child(5)').fadeOut();
		}
	});
	
	
	 $("#kontaktCtaFormular").formValidation({
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
            ctaipost: {
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
			nachricht: {
				row: '.form-group',
				validators: {
					notEmpty: {
						message: 'Nachricht ist ein Pflichtfeld'
					},
					stringLength: {
						min: 15,
						message: 'Nachricht ist ein Pflichtfeld (mind. 15 Zeichen)'
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
                    	$('#kontaktCtaFormular-alert-success').removeClass("hidden");
					}else{
						$('#kontaktCtaFormular-alert-fail').removeClass("hidden");
					}
					$('#cta-overlayer').animate({scrollTop: $('#abschicken').offset().top -100}, 5000);
				}
       		 });
		});
    });
</script>
<?php
}
add_action('wp_footer','page_cta_kontakt_function');								 
?>								
</section>