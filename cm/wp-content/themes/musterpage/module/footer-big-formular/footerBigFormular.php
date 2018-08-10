<?php

global $nachname, $vorname, $plz, $ipost, $phone, $ort, $strasse, $mobile, $betreff, $nachricht, $statusmeldung, $kontakt, $rueckruf;


// diese zeile in functions hinzufügen
//require_once('module/footer-big-formular/footerBig-mail-function.php');
?>
<!-- footerBig Formular  -->
<section id="kontakt" class="footerBig-formular">
    <div class="container">
  	<div class="row footer-big-kontaktinfo well-md wow downIncoming" data-wow-duration="2s">    
          <div class="col-xs-12 col-sm-4 text-center">
                 <i class="fa fa-phone fa-2x"></i>
                <div class="postTxt text-center">
                    <h3>Kontakt</h3>
                    <p><a href="<?= get_option('res_kontaktdaten')['phone'];?>"><?= get_option('res_kontaktdaten')['phone_text'];?></a><br>
                    <a href="mailto:<?= get_option('res_kontaktdaten')['mail'];?>"><?= get_option('res_kontaktdaten')['mail_text'];?></a></p>
              </div>
          </div>
          <div class="col-xs-12 col-sm-4 text-center">
                 <i class="fa fa-map-marker fa-2x"></i>
                <div class="postTxt text-center">
                    <h3>Office</h3>
					<p><?= get_option('res_kontaktdaten')['strasse'];?><br>
					<?= get_option('res_kontaktdaten')['plz'];?> <?= get_option('res_kontaktdaten')['ort'];?><br>
					</p>
              </div>
          </div>
          <div class="col-xs-12 col-sm-4 text-center">
                 <i class="fa fa-comment-o fa-2x"></i>
                <div class="postTxt text-center">
                    <h3>Anfrage</h3>
                    <p>Lassen Sie sich beraten<br>
					   kontaktieren Sie uns </p>
              </div>
          </div>
      </div>
		
   <div class="row footer-big-Title wow fadeIn" data-wow-duration="2s">
        <div class="col-xs-12">
            <div class="text-center well-bottom-md">
                <h2><?= get_option('res_kontaktdaten')['kontakt_slogan']; ?></h2>
            </div>
        </div>
    </div>
		
    <div class="row footer-big-formular">
            <form action="<?= $_SERVER['REQUEST_URI']; ?>" name="footerBigFormular" id="footerBigFormular" method="post">          

                <div class="checkbox well-bottom-sm">
                    <div class="col-xs-12 col-sm-6">
                        <label>
                            <input type="checkbox" checked name="kontakt" value="beratung">
                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span> Ich möchte beraten
                            werden</label>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <label>
                            <input type="checkbox" name="rueckruf" value="rueckruf">
                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span> Bitte rufen Sie mich
                            zurück</label>
                    </div>

			</div>
					
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <input type="text" class="form-control" name="nachname" id="nachname" placeholder="Nachname"
                               value="<?php echo $nachname; ?>"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <input name="vorname" class="form-control" type="text" id="vorname" placeholder="Vorname"
                               value="<?php echo $vorname; ?>"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <input name="ipost" type="text" class="form-control" id="ipost" placeholder="E-Mail"
                               value="<?php echo $ipost; ?>"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <input name="phone" class="form-control" type="tel" id="phone" placeholder="Telefon"
                               value="<?php echo $phone; ?>"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <input name="strasse" class="form-control" type="text" id="strasse" placeholder="Strasse"
                               value="<?php echo $strasse; ?>"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group">
                        <input name="plz" class="form-control" type="text" id="plz" placeholder="PLZ"
                               value="<?php echo $plz; ?>"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group">
                        <input name="ort" class="form-control" type="text" id="ort" placeholder="Ort"
                               value="<?php echo $ort; ?>"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <textarea id="nachricht" class="form-control" rows="6" cols="10" name="nachricht"
                                  placeholder="Ihre Nachricht"><?php echo $nachricht; ?></textarea>
                    </div>
                </div> 
				
				<!--Datenschutz-->
				<div class="col-xs-12 col-sm-offset-4 col-sm-8 col-center well small datenschutz-hinweis">
					<label>
						<div class="form-group">
							<input id="checkBox" name="datenschutz" type="checkbox" class="datenschutz-checkbox">
							<span class="datenschutz-txt">Ich bin mit den <a href="<?php echo esc_url( home_url( '/' ) ); ?>impressum">Datenschutzerklärung</a> einverstanden</span>
						</div>
					</label>
				</div>

				<div class="col-xs-12 text-center">
                    <span style="position: absolute; left: -2000px;"><input name="res_hon" type="text" id="res_hon"></span>
                    <input name="senden" type="hidden" value="">
                    <input type="hidden" name="form_name" value="footerBigFormular"> <!-- Value => ID Form -->
            <input type="submit" class="btn btn-lg btn-default text-center" id="senden" value="senden" onclick="gtag('event', 'footerFormular', {event_category: 'FooterFormularSenden-btn', event_action: 'formular-send'});">
				</div>
				
			<div id="kontakt-alert-success" class="alert alert-success hidden">
				Das Formular wurde erfolgreich übermittelt. <i class="glyphicon glyphicon-ok text-success"></i> 
			</div>
			<div id="kontakt-alert-fail" class="alert alert-fail hidden">
				Das Formular konnte nicht übermittelt werden. <i class="glyphicon glyphicon-ok text-warning"></i>
			</div>
	  
	  		<p class="well"></p>
      
 	</div>
				

    <div class="row footer-rights text-center well-top-lg wel-bottom-sm">
        <p>Copyright <?= date('Y'); ?> <?= get_option('res_kontaktdaten')['firma'];?> -Webesign by <a
                href="http://www.resign.ch" rel="nofollow" target="_blank">RESIGN</a>. - <a
                href="<? echo esc_url(home_url('/')); ?>?impressum=impressum">Impressum & Datenschutz</a></p>
    </div>

    </div>
</section>

<?php
function footer_big_formular(){
	
//  function Formular mit Dankesseite-Redirect
//$redirect_link = get_permalink( get_page_by_title( 'Dankesseite' ));
?>
<!--  Script für FooterBig-Formular -->
<script> 
    jQuery(document).ready(function ($) {
// var redirect_link = '<?php //echo $redirect_link; ?>';
        $("#footerBigFormular").formValidation({
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
                phone: {
                    row: '.form-group',
                    validators: {
                        notEmpty: {
                            message: 'Telefon ist ein Pflichtfeld'
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
                },
				datenschutz: {
				row: '.form-group',
				validators: {
					notEmpty: {
						message: 'Bitte Datenschutzerklärung zustimmen'
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
						$('#kontaktSuccess').removeClass("hidden");
//					window.location.replace(redirect_link); // Redirect auf die Dankesseite		
					} else {
						$('#kontaktFail').removeClass("hidden");
					}
					$('html,body').animate({scrollTop: $('#senden').offset().top}, 2000);
				}
       		 });
		});
    });
	
</script>
<?php
}
add_action('wp_footer', 'footer_big_formular');
?>
