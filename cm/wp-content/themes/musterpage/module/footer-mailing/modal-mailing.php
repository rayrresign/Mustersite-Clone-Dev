
<!-- Newsletter Modal  2018 -->    
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="newsletterbox" aria-hidden="true" id="newsletterbox">
    <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header clearfix">
                  <div class="close-modal xClose pull-right" data-dismiss="modal"><div class="lr"><div class="rl"></div></div></div>
                  <h3 class="modal-title pull-left">Newsletter</h3>
                </div>
                <div class="modal-body">
                  <div class="newsletterPoupFormular">
                      <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>?action=subscribe" name="newsletterFormular" id="mailing-subscribe-form">
                        <input type="hidden" id="newsletter_list_id" name="list_id" value="6" /><!-- ID 6 musterpage -->
                        <input type="hidden" id="newsletter_form_id" name="form_id" value="1" />
						  
						<?php // Input value "res" schreibt in CMS-Kontakte  -  value "mva" schreibt zu ContentNewsletter mit List-ID ?>
                        <input type="hidden" id="newsletter_send_id" name="send_id" value="mva" />
                        
                        <div class="form-group">
                          <input type="text" class="form-control" name="nachname" id="newsletter_nachname" placeholder="Nachname"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="vorname" id="newsletter_vorname" placeholder="Vorname"/>
                        </div>
                        <div class="form-group">
                            <input name="email" type="text" class="form-control" id="newsletter_email" placeholder="E-Mail"/>
                        </div>
                        <div class="form-group">
                            <input name="mobile" class="form-control" type="tel" id="newsletter_mobile" placeholder="Mobile"/>
                        </div>
						  
						<!--Datenschutz-->
						<label>
							<div class="form-group small datenschutz-hinweis">
								<input id="checkBox" name="datenschutz" type="checkbox" class="datenschutz-checkbox">
								<span class="datenschutz-txt">Ich bin mit den <a href="<?php echo esc_url( home_url( '/' ) ); ?>impressum">Datenschutzerklärung</a> einverstanden</span>
							</div>
						</label>
	
                        <input type="submit" name="contact_send" id="contact_send_btn" class="btn btn-default" value="anmelden" />
                        <div id="mailing-alert-success" class="alert alert-success hidden">
                        	Die Angaben wurden erfolgreich eingetragen. <i class="glyphicon glyphicon-ok text-success"></i> 
                        </div>
                      </form>
                  </div>
              </div>
        </div> 
    </div>
</div>

