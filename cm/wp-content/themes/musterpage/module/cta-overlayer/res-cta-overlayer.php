
<!-- Res Cta Overlayer -->

    <!-- cta-sticker -->  
    <div class="cta-sticker text-center"> 
    	<a href="#" onclick="javascript: jQuery('#cta-overlayer').modal('show'); return false; 
							 ga('send', 'event', { eventCategory: 'cta-sticker-click', eventAction: 'btn-klick', eventLabel: 'mainpage'})">
          <div class="cta-circle">
            <div class="cta-circleTxt text-center">
			  <i class="fa fa-comment" aria-hidden="true"></i>
              <h4>Hello...</h4>
            </div>
          </div>
        </a> 
      </div>
      

<!-- Modal CTA Overlayer --> 
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cta-overlayer" aria-hidden="true" id="cta-overlayer">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header clearfix">
        <div class="close-modal xClose pull-right" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
      </div>
      <div class="modal-body">
      
      	<?php require_once('res-cta-kontakt.php'); ?>
        
 		<?php //require_once('res-cta-ruckruf.php'); ?>
        
        <!-- Anrufen Tel hidden -->
        <section class="anrufen text-center well-sm hidden">
          <div class="container">
            <div class="row text-center">
                  <h2>Anrufen</h2>
                  <p class="well">Rufen Sie uns an, wir beraten Sie gerne telefonisch.</p>
                  <div class="col-xs-12"> 
					  <a href="<?= get_option('res_kontaktdaten')['phone'];?>" class="btn btn-secondary">
						  	<h3><i class="fa fa-phone" aria-hidden="true"></i> <?= get_option('res_kontaktdaten')['phone_text'];?></h3>
					  </a> 
                   </div>
            </div>
          </div>
        </section>
        
      </div>
    </div>
  </div>
</div>