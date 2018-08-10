<?php
include_once(plugin_dir_path( __DIR__ ) .'connect.php');
global $wpdb;
// AJAX Guestlist Tool for v8

if(isset($_POST["event_id"])){
	$event_id = strip_tags(esc_sql($_POST["event_id"]));
	$guestlist = mysql_query("SELECT * FROM guestlist WHERE event_id = '$event_id'");
	$guestlist = mysql_fetch_array($guestlist);
}else{
	$guestlist = $wpdb->get_row("SELECT * FROM guestlist where status = '0' ORDER BY datum ASC LIMIT 1"); // Gästeliste geschlossen
		$event_id = $guestlist->event_id;
}

$glist = $wpdb->get_results("SELECT * FROM guestlist WHERE status = '0' ORDER BY datum ASC", ARRAY_A); // alle Gästelisten, die noch verfügbar sind
//print_r('<pre>');
//print_r($glist);
//print_r('</pre>');
		if(isset($_POST["update_id"])){
			$update_id = $_POST["update_id"];
		}
		else {
			$update_id = $guestlist->id;
		}	

// Callback
//if(isset($_POST['arguments'])){
//	$update_id = 0;
//}
//foreach($_POST['arguments'] as $v) $update_id+= (int) $v;

// Main Query
$glist = $wpdb->get_results("SELECT * FROM guestlist WHERE status = '0' ORDER BY datum ASC");
							$wp_posts = Array();

							$term_id =  $wpdb->get_row("SELECT term_id from wp_terms where slug='events'"); // 20
	
								
							$ids = $wpdb->get_results("SELECT object_id from wp_term_relationships where term_taxonomy_id = '".$term_id->term_id."'");
//print_r('<pre>');
//print_r($ids);
//print_r('</pre>');
							$f = 0; // von oben: 466 470 935 781 493 801 797 938 941 450 957 960 963 460 788
							$g = 0;
							foreach($ids as $object_ids){
								$post = $wpdb->get_row("SELECT * from wp_posts where ID='".$object_ids->object_id."' AND (post_status = 'publish' OR post_status = 'future')");
								
								
//								$post = mysql_fetch_array($post);
								 
								 $event_name_and_ids_a[$g][0] = $post->post_title;
								 $event_name_and_ids_a[$g][1] = $post->ID;
								 
								 $g++;

									if(!empty($post)){
										$check = $wpdb->get_results("SELECT * from guestlist where event_id='".$object_ids->object_id."'");
										
									}
							}
						?>
<!-- AJAX Updater - html code -->

<form id="guestlist_form" method="POST" action="" name="entry_form"  enctype="multipart/form-data">
  <div class="formularZeile form-group">
    <select id="event_drop_down" name="party" class="textbox_select form-control" required>
    <option value="">-- bitte wählen --</option>
      <?php
							foreach($glist as $gl){
						?>
      <option <?php if($update_id == $gl->id){ ?> //selected="selected" <?php } ?> title="<?= $gl->id; ?>" value="<?= $gl->id; ?>">
      <?php 				
								$anzahl = count($event_name_and_ids_a);								
								foreach($event_name_and_ids_a as $event => $val) {
									if($val[1] == $gl->event_id){
										echo $val[0];
									}
								}
								?>
      </option>
      <?php
							}
			        	?>
    </select>
    <?php
							$glist2 =  $wpdb->get_results("SELECT * FROM guestlist WHERE status = '0' ORDER BY datum ASC");
							foreach($glist2 as $gl2){
									for($u=0; $u<=1; $u++){
										if ($event_name_and_ids_a[$u][1] == $gl2->event_id){
										  if($update_id == $gl2->id){
											  echo '<input name="partyname" type="hidden" id="partyname" value="'.$event_name_and_ids_a[$u][0]." | ".$gl2->datum.'" />';
										  }
										}
									}
							}
						?>
  </div>
  <div class="form-group formularZeile">
    <?php 
						$bedingungencheck = $wpdb->get_row("SELECT * FROM guestlist WHERE id = '$update_id'");
	  							
						if ($bedingungencheck != '' ) { echo '<div class="alert well" role="alert">'.$bedingungencheck->bedinungen.'</div>'; } 
						?>
    <input id="bedingungen" name="bedingungen" value="<?= $bedingungencheck->bedinungen; ?>" type="hidden" class="form-control" />
  </div>
  <h4>Angaben</h4>
  <div class="form-group formularZeile">
    <input name="myname" type="text" class="textbox form-control" id="myname" placeholder="Name *" required />
  </div>
  <div class="form-group formularZeile">
    <input name="vorname" type="text" class="textbox form-control" id="vorname" placeholder="Vorname *" required />
  </div>
  <div class="form-group formularZeile">
    <input id="emailadr" name="email" type="text" class="textbox form-control" placeholder="E-Mail *" required />
  </div>
  <div class="form-group formularZeile">
    <input id="mobile" name="mobile" type="text" class="textbox form-control" placeholder="Mobile" />
  </div>
  <h4>Begleitung</h4>
  <div class="form-group formularZeile">
    <select id="begleitungen" name="begleitungen" class="textbox_select form-control">
      <option value="0">0</option>
      <?php
						$listencheck = $wpdb->get_row("SELECT * FROM guestlist where id = '$update_id'");
							for($l = $listencheck->begleitungen; $l > 0; $l--){
						?>
      <option value="<?= $l; ?>">+
      <?= $l; ?>
      </option>
      <?php 
							}
			        	?>
    </select>
  </div>
  <div class="formularZeile">
    <input class="btn btn-primary" name="guestlist_submit" type="submit" value="eintragen" />
  </div>
</form>
<?php 
function page_kontakt_function(){	
?>
 <script>
jQuery(document).ready(function($) {
	 $("#guestlist_form").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        }
    }).on('success.form.fv', function (e) {   // Formular send to Contact
            e.preventDefault();

	var form = $('#form-send'), 
	url = form.attr('action');	 
            
    var event_drop_down = $("#event_drop_down").val();
    var myname = $("#myname").val();
    var vorname = $("#vorname").val();
    var email = $("#emailadr").val(); 
	var mobile = $("#mobile").val();
	var begleitungen = $("#begleitungen").val();
//	var dataString = 'myname='+ myname + '&Guestlist_id='+ event_drop_down + '&name=' + vorname + '&email=' + email + '&begleitung=' + begleitungen + '&mobile=' + mobile;
		 
		 var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>"; 
		 	
				$.ajax({
				type: "POST",
				url: ajaxurl,
				data: {
					action : 'resign_write_db',
					id : event_drop_down,
					name : myname,
					vorname : vorname,
					email : email,
					mobile : mobile,
					begleitungen : begleitungen,
				},
				success: function(data){
//					$('.Ticket-zahl').html(data);
				}
			  });
		 });
	 });
</script>
<?php 

}
add_action('wp_footer','page_kontakt_function');
?>	

