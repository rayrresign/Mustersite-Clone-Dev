<?php
/*
 * Template Name: Page-Kontakt
 */
 
// Formular Script Kontakt
function check_input_contact($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

//$empfaenger = get_option('res_kontaktdaten')['form_adress_reciever'];	
$empfaenger = 'ray@resign.ch';	
//$empfaenger = 'info@resignstudios.ch';	
$nachname = $vorname = $ipost = $mobile = $betreff = $nachricht = '';

if(isset($_POST["senden"])){		

	$nachname 	= check_input_contact($_POST["nachname"]);
	$vorname 	= check_input_contact($_POST["vorname"]);
	$ipost 		= check_input_contact($_POST["ipost"]);
	$mobile 	= check_input_contact($_POST["mobile"]);
	$betreff 	= check_input_contact($_POST["betreff"]);
	$nachricht 	= check_input_contact($_POST["nachricht"]);
	
	$emailRegex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
	
	$emailValid = preg_match($emailRegex, $ipost);
	
	if(!empty($nachname) && !empty($ipost) && empty($_POST["res_hon"]) && $emailValid){
		$url = $_SERVER['SERVER_NAME'];
		if($betreff == '') {
			$betreff = "Kontaktformular ausgefüllt: ".$url;
		}
		
		$mailtext = "<html>
		<body style='font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#666666;'>
		<p>Ihnen wurde eine Nachricht via Kontaktformular von $url gesendet:</p>
		<p><b>Name:</b> $vorname&nbsp;$nachname</p>
		<p><b>Mobile:</b> $mobile<br /></p>
		<p><b>E-Mail:</b> $ipost<br /></p>
		<p><b>Betreff:</b> $betreff</p> 
		<p><b>Nachricht:</b> $nachricht</p> 
		</body></html>";
		
		$headers  = 'From: Kontaktformular <'.get_option('res_kontaktdaten')['form_adress_sender'].'>' . "\r\n";
		// $headers  = 'From: Ihr Kontaktformular <info@musterpage.ch>' . "\r\n";
		$headers .= 'Reply-To: <'.$ipost.'>' . "\r\n";
		$headers .= 'Return-Path: <'.$ipost.'>' . "\r\n";
		$headers .= "X-Mailer: PHP\n";
		$headers .= 'MIME-Version: 1.0' . "\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	
		
		if(mail($empfaenger, $betreff, $mailtext, $headers)){
			echo 'mail-success';
		}
		echo 'mail-success';
		
	} else {
		echo 'fail';
	}
	exit();
}
get_header(); ?>

<main class="res-content">
 
<!-- Kontakt  -->
<section class="kontakt-formular">
  <div class="container">

	<h2>Kontakt</h2>

                <div class="row well-bottom">
                    <div class="col-xs-12 col-sm-4 postBox">
                      <div class="postContent">
                        <?= get_option('res_kontaktdaten')['firma'];?><br>
                        <?= get_option('res_kontaktdaten')['strasse'];?><br>
                        <?= get_option('res_kontaktdaten')['plz'];?> <?= get_option('res_kontaktdaten')['ort'];?><br>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 postBox">
                      <div class="postContent">
                        <p><a href="mailto:<?= get_option('res_kontaktdaten')['mail'];?>"><?= get_option('res_kontaktdaten')['mail_text'];?></a><br>
                        <a href="tel:<?= get_option('res_kontaktdaten')['phone'];?>"><?= get_option('res_kontaktdaten')['phone_text'];?></a></p>                   
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 postBox">
                      <div class="postContent footerSocial">
                      </div>
                    </div>
                </div>
     
		<h3 class="well-sm"><?= get_option('res_kontaktdaten')['kontakt_slogan']; ?></h3>

        <!-- Formular -->
        <form action="<?= $_SERVER['REQUEST_URI']; ?>" name="kontaktFormular" id="kontaktFormular" method="post">			  
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                	<div class="form-group">
                     	<input type="text" class="form-control" name="nachname" id="nachname" placeholder="ss" value="<?php echo $nachname; ?>"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                	<div class="form-group">
                  		<input type="text" class="form-control" name="vorname" id="vorname" placeholder="Vorname" value="<?php echo $vorname; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                	<div class="form-group">
                  		<input type="text" class="form-control" name="ipost" id="ipost" placeholder="E-Mail" value="<?php echo $ipost; ?>"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                	<div class="form-group">
                  		<input type="tel"  class="form-control" name="mobile" id="mobile" placeholder="Mobile" value="<?php echo $mobile; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                	<div class="form-group">
                  		<input type="text" class="form-control" name="betreff" id="betreff" placeholder="Betreff" value="<?php echo $betreff; ?>"/>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <textarea id="nachricht" class="form-control" rows="6" cols="10" name="nachricht" placeholder="Ihre Nachricht"><?php echo $nachricht; ?></textarea>
            </div>
            <span style="position: absolute; left: -2000px;"><input name="res_hon" type="text" id="honey"/></span>
             <input type="hidden" name="form_name" value="kontaktFormular"/> <!-- Value => ID Form -->
            <input name="senden" type="hidden" value="" />
            <input type="submit" class="btn btn-default" id="senden" value="absenden" />
        </form>      

        <div id="kontakt-alert-success" class="alert alert-success hidden">
            Das Formular wurde erfolgreich übermittelt. <i class="glyphicon glyphicon-ok text-success"></i> 
        </div>
		<div id="kontakt-alert-fail" class="alert alert-fail hidden">
            Das Formular konnte nicht übermittelt werden. <i class="glyphicon glyphicon-ok text-warning"></i>
        </div>
      
 </div> 
<?php
function page_kontakt_function(){	
?>
 <script>
jQuery(document).ready(function($) {
	 $("#kontaktFormular").formValidation({
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
					console.log(data.responseText);
					
					if (data.responseText.indexOf('mail-success') >= 0) {
					   	
                    	$('#kontakt-alert-success').removeClass("hidden");
					   
					} else {
						
						$('#kontakt-alert-fail').removeClass("hidden");
					}
					$('html,body').animate({scrollTop: $('#senden').offset().top -100}, 1000);
				}
       		 });
		});
    });
</script>
<?php
}
add_action('wp_footer','page_kontakt_function');								 
?>								
</section>
 

</main>
<?php get_footer(); ?>