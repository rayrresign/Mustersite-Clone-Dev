<?php
if(isset($_GET["settings"])){
			$subject		= strip_tags(esc_sql($_POST["subject"]));
			$absendermail 	= strip_tags(esc_sql($_POST["absendermail"]));
			$absendertitel 	= strip_tags(esc_sql($_POST["absendertitel"]));
			$successtitel 	= strip_tags(esc_sql($_POST["successtitel"]));
			$successmsg 	= strip_tags(esc_sql($_POST["successmsg"]));
			$errortitel 	= strip_tags(esc_sql($_POST["errortitel"]));
			$errormsg 		= strip_tags(esc_sql($_POST["errormsg"]));
			
			$settings_query1 = $wpdb->get_results("SELECT * from guestlist_settings");
			
			if(!empty($settings_query1)){
				$update_settings = $wpdb->query("UPDATE guestlist_settings SET subject = '$subject' , absendermail = '$absendermail' , absendertitel = '$absendertitel' , successtitel = '$successtitel' , successmsg = '$successmsg' , errortitel = '$errortitel' , errormsg = '$errormsg'");			
			}
			else{
				$insert_settings = $wpdb->query("INSERT INTO guestlist_settings SET subject = '$subject' , absendermail = '$absendermail' , absendertitel = '$absendertitel' , successtitel = '$successtitel' , successmsg = '$successmsg' , errortitel = '$errortitel' , errormsg = '$errormsg'");			
			}
	}


	if(isset($_GET["edit"])){
		$edit_id = sanitize_text_field($_GET["edit"]);
	}
	
	if(isset($_GET["insert"])||isset($_GET["edit_input"])){
		
		
		if(isset($_POST["submit"])){
			$partyname = esc_sql($_POST["partyname"]);
			$datum = esc_sql($_POST["datum"]);
			$bedienungen = esc_sql($_POST["bedienungen"]);
			$event_id = esc_sql($_POST["event_id"]);
			$begleitungen = esc_sql($_POST["begleitungen"]);
					
			if(isset($_GET["insert"])){
				$wpdb->insert(
						'guestlist',
						array(
							'partyname' => $partyname,
							'datum' => $datum,
							'bedinungen' => $bedienungen,
							'begleitungen' => $begleitungen,
							'event_id' => $event_id
						));
			}
			
			if(isset($_GET["edit_input"])){
			$edit_input = sanitize_text_field($_GET["edit_input"]);
				$wpdb->update(
							'guestlist',
							array(
								'partyname' => $partyname,
								'datum' => $datum,
								'bedinungen' => $bedienungen,
								'begleitungen' => $begleitungen,
								'event_id' => $event_id,
							),
							array(
							'id' => $edit_input
							)
						);
			}
		}
	}
	
	if(isset($_GET["del"])){
		$del_id = strip_tags(esc_sql($_GET["del"]));
		$wpdb->query("DELETE from entries where Guestlist_id='$del_id'");
		$wpdb->query("DELETE from guestlist where id = '$del_id'");
	}
	
	if(isset($_GET["close"])){
		$close_id = strip_tags(esc_sql($_GET["close"]));
		$update = $wpdb->query("update guestlist set status = '2' where id = '$close_id'");
	}
	
	if(isset($_GET["open"])){
		$open_id = strip_tags(esc_sql($_GET["open"]));
		$update = $wpdb->query("update guestlist set status = '0' where id = '$open_id'");
	}
	
	if(isset($_GET["csv"])){
		
		$header_row = array(
			'Name',
			'Vorname',
			'Begleitungen',
			'email',
			'mobile'
		);	
		
		$filename = 'Guestlist - '.time() .'.csv';
		$results = strip_tags(esc_sql($_GET["csv"]));
		$fh = @fopen("".ABSPATH."wp-content/plugins/resign-guestlist/csv/guestlist.csv", "w");
		$res = $wpdb->get_results("SELECT * FROM entries where Guestlist_id='$results'", ARRAY_A);
		
		foreach($res as $key){
			$row = array(
				$key['name'],	
				$key['vorname'],	
				$key['begleitungen'],
				$key['email'],
				$key['mobile']
			);
		$data_rows[] = $row;
		}
		fprintf( $fh, chr(0xEF) . chr(0xBB) . chr(0xBF) );
		fputcsv( $fh, $header_row , ";" );
		foreach ( $data_rows as $data_row ) {
			fputcsv( $fh, $data_row , ";" );
		}
    fclose( $fh );
		echo '<meta http-equiv="refresh" content="0; url=../wp-content/plugins/resign-guestlist/guestlistdownload.php" />'; 

	}
	
?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="../wp-content/plugins/resign-guestlist/css/animate-custom.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<style>
.cdGrid2{
	width: 100%;
	float:left;
	}

</style>

<script>
jQuery(function($){
        $.datepicker.regional['de'] = {clearText: 'löschen', clearStatus: 'aktuelles Datum löschen',
                closeText: 'schließen', closeStatus: 'ohne Änderungen schließen',
                prevText: '<zurück', prevStatus: 'letzten Monat zeigen',
                nextText: 'Vor>', nextStatus: 'nächsten Monat zeigen',
                currentText: 'heute', currentStatus: '',
                monthNames: ['Januar','Februar','März','April','Mai','Juni',
                'Juli','August','September','Oktober','November','Dezember'],
                monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
                'Jul','Aug','Sep','Okt','Nov','Dez'],
                monthStatus: 'anderen Monat anzeigen', yearStatus: 'anderes Jahr anzeigen',
                weekHeader: 'Wo', weekStatus: 'Woche des Monats',
                dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
                dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
                dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
                dayStatus: 'Setze DD als ersten Wochentag', dateStatus: 'Wähle D, M d',
                dateFormat: 'dd.mm.yy', firstDay: 1, 
                initStatus: 'Wähle ein Datum', isRTL: false};
        $.datepicker.setDefaults($.datepicker.regional['de']);
});

$(function() {
	$( "#datepicker" ).datepicker();
});
</script>

<link href="../wp-content/plugins/resign-guestlist/pluginSkin.css" rel="stylesheet" media="all" type="text/css" />

<?php
	$settings_query2 = $wpdb->get_results("SELECT * from guestlist_settings");
?>



<div class="wrap">
	<div class="postbox">
		<h3 class="hndle">Guestlist Manager</h3>
        
		<div class="form_NewEntry"> 
		<?php 
		if(isset($_GET["edit"])){
			$edit = $wpdb->get_row('SELECT * FROM guestlist WHERE id='.$edit_id.'');
		?>
			<form method="POST" action="admin.php?page=resignguestlist&edit_input=<?= $edit->id; ?>" name="guestlist_form" enctype="multipart/form-data" >
		<?php 
		}else{
		?>
			<form method="POST" action="admin.php?page=resignguestlist&insert" name="guestlist_form" enctype="multipart/form-data" >
		<?php 
		}
		?>
                <div class="form_NewEntryTxt">
					<div class="form_row">
						<div class="form_left">List Name</div>
						<div class="form_right">
							<input name="partyname" type="text" value="<?php if(isset($edit->partyname)){ echo $edit->partyname; } ?>" />
						</div>
					</div>
                    
					<div class="form_row">
						<div class="form_left">Datum</div>
						<div class="form_right">
                            <input id="datepicker" name="datum" type="text" value="<?php if(isset($edit->datum)){ echo $edit->datum; } ?>" />
						</div>
					</div>
                    
					<div class="form_row">
						<div class="form_left">Event</div>
						<div class="form_right">
						<?php 
							
//					$edit = $wpdb->get_row('SELECT * FROM guestlist WHERE id='.$edit_id.'');
//							var_dump($edit);
							$wp_posts = array();
							$term_id_sql = $wpdb->get_var("SELECT term_id from wp_terms where slug='events'"); // events 	
							
							$all_object_ids = $wpdb->get_results("SELECT object_id from wp_term_relationships where term_taxonomy_id = '".$term_id_sql."'"); 
							$f = 0;
							$g = 0;	
	
	
							foreach($all_object_ids as $object_id){
								// single event muen überprüefe, damit bim Dropdown bi ediete srichtige usgwählt isch obe chani ja edit scho hole 
								$post = $wpdb->get_results("SELECT * from wp_posts where ID='".$object_id->object_id."' AND (post_status = 'publish' OR post_status = 'future')"); // Alle Posts	
								
									if(!empty($post)){
										if(empty($edit)){											
											$check = $wpdb->get_results("SELECT * from guestlist where event_id='".$object_id->object_id."'");
										}	
									}									
									
								
								
									if(empty($check)){
										foreach($post as $postres){
											$wp_posts[$f] = $postres;
											$f = $f + 1;
										}
									}
							}
						?>
                        
							<select name="event_id">
								<option value="0">Kein</option>	
									<?php 			
									$arrayLength = count($wp_posts);
									for($i=0; $i<$arrayLength; $i++){
										if(!empty($wp_posts[$i]->ID)){
									?>
											<option <?php if($wp_posts[$i]->ID == $edit->event_id ){ ?> selected="selected" <?php } ?> value="<?= $wp_posts[$i]->ID; ?>">
												<?php
												echo $wp_posts[$i]->post_title." | "; 
												$newdate = date("d.m.Y", strtotime($wp_posts[$i]->post_date));
												$newdate = $newdate . "";
												echo str_replace("01.01.1970", "", $newdate);
												?>
                                            </option>
									<?php 
										}
									}
									?>
							</select>	
						</div>
					</div>
					<div class="form_row">
						<div class="form_left">Bedingungen</div>
						<div class="form_right">
							<textarea name="bedienungen" rows="5" cols="30"><?php  if(isset($edit->bedinungen)){ echo $edit->bedinungen; } ?></textarea>
						</div>
					</div>
					<div class="form_row">
						<div class="form_left">Begleitungen</div>
						<div class="form_right">
							<input name="begleitungen" type="text" value="<?php  if(isset($edit->begleitungen)){ echo $edit->begleitungen; } ?>" />
						</div>
					</div>
                </div>

				<div class="form_row">
					<div class="form_left">&nbsp;</div>
					<div class="form_right">
						<p class="submit">
							<input name="submit" type="submit" value="<? if(isset($_GET["edit"])){ ?>Speichern<?php } else{?>Neue Liste hinzuf&uuml;gen<?php } ?>" class="button-primary">
						</p>
					</div>
				</div>

			</form>
		</div>
	</div>
    </div> <!-- 01 END -->
	<div class="clear"></div>
    
    
    
    
    

	<div class="wrap postbox">
	<h3 class="hndle">Aktuelle Gästelisten</h3>
	<div class="postbox cdGrid">
		<div id="release_row_one" class="release_row">
			<div class="release_col titleTab spalteBtnEdit">Edit</div>
			<div class="release_col titleTab spalteTitel">Name</div>
			<div class="release_col titleTab spalteLabel">Datum</div>
			<div class="release_col titleTab spalteTitel">Eventname</div>
			<div class="release_col titleTab spalteLabel">Einträge</div>
			<div class="release_col titleTab spalteText">Exportieren</div>
			<div class="release_col titleTab spalteLink">Liste Schliessen</div>
			<div class="release_col titleTab spalteLink">Löschen</div>
		</div>
	<?php 
//		$guestlists = mysql_query('SELECT * FROM guestlist WHERE STR_TO_DATE(datum, "%d.%m.%Y") >= NOW() - INTERVAL 3 DAY ORDER BY STR_TO_DATE(datum, "%d.%m.%Y") DESC');
		$guestlists = $wpdb->get_results('SELECT * FROM guestlist WHERE datum >= DATE(NOW())');
//		$guestlists = $wpdb->get_results('SELECT * FROM guestlist WHERE datum >= DATE(NOW()) - INTERVAL 3 DAY ORDER BY datum DESC ');
		
		foreach ($guestlists as $key){
			$event = $wpdb->get_row("
								 SELECT 	*
								 FROM 		$wpdb->posts
								 WHERE		ID=$key->event_id
								 ORDER BY	ID ASC
								 ");			
			$entries_number = $key->id;
			$entries = $wpdb->get_var('		SELECT		COUNT(Guestlist_id)
											FROM		entries
											WHERE 		Guestlist_id = '.$key->id.'
											');
			?>
			<div class="release_row">
				<div class="release_col spalteBtnEdit">
					<a href="admin.php?page=resignguestlist&edit=<?= $key->id; ?>">
						<img src="../wp-content/plugins/resign-guestlist/css/button_edit.jpg" />
					</a>
				</div>
				<div class="release_col spalteTitel"><?= $key->partyname; ?></div>
				<div class="release_col spalteLabel"><?= $key->datum; ?>&nbsp;</div>
				<div class="release_col spalteTitel"><?php if(isset($event->ID)){ echo $event->post_title; }else{ echo "kein"; } ?></div>
				<div class="release_col spalteLabel"><?php echo $entries; ?> </div> 
				<?php
				if($entries_number>0){ ?><div class="release_col spalteText"><a href="admin.php?page=resignguestlist&csv=<?= $key->id; ?>">Excel speichern</a></div><?php } else{ ?><div class="release_col spalteText">Leer</div> <?php } ?>
				<div class="release_col spalteLink"><?php if($key->status == 0){ ?><a href="admin.php?page=resignguestlist&close=<?= $key->id; ?>">Schliessen</a><?php }else{ ?><a href="admin.php?page=resignguestlist&open=<?= $key->id; ?>">Öffnen</a><?php } ?></div>
				<div class="release_col spalteLink"><a href="admin.php?page=resignguestlist&del=<?= $key->id; ?>"><img src="../wp-content/plugins/resign-guestlist/css/bt_delete.jpg" ></a></div>
				
			</div> 
			<?php 
		} ?>
	</div>
</div>
<div class="clear"></div><div class="clear"></div><div class="clear"></div> 
	<?php 
//	  open = 0   |   close = 1    |   user close = 2
	$datecheck_andclose = $wpdb->get_results('SELECT 		*
		  							  FROM 			guestlist
									  WHERE 		status = 0
									  AND			STR_TO_DATE(datum, "%d.%m.%Y") <= CURRENT_DATE() - INTERVAL 1 DAY
									  ORDER BY 		STR_TO_DATE(datum, "%d.%m.%Y") DESC');
	foreach($datecheck_andclose as $key){
		$num_rows_closer = $key->status;
		if($num_rows_closer != 0){			
			$sql = '	UPDATE 	guestlist
						SET 	status = 1
						WHERE 	STR_TO_DATE(datum, "%d.%m.%Y") <= CURRENT_DATE() - INTERVAL 1 DAY';
			$wpdb->query($sql);
		}
	}
	// date update 
	$datechecker = $wpdb->get_results('SELECT 		*
		  							  FROM 			guestlist
									  WHERE 		status = 0
									  AND			STR_TO_DATE(datum, "%d.%m.%Y") <= NOW() - INTERVAL 3 DAY
									  ORDER BY 		STR_TO_DATE(datum, "%d.%m.%Y") DESC');
	foreach($datechecker as $key){
		$num_rows = $key->status;
		if($num_rows != 0){			
			$sql = '	UPDATE 		guestlist 
						SET			status = 1
						WHERE		STR_TO_DATE(datum, "%d.%m.%Y") <= NOW() - INTERVAL 3 DAY';
			$wpdb->query($sql);
		}
	}
	// date back 
	$datechecker = $wpdb->get_results('SELECT 		*
		  							   FROM			guestlist
									   WHERE		status = 1
									   AND			STR_TO_DATE(datum, "%d.%m.%Y") > NOW() - INTERVAL 1 DAY
									   ORDER BY		STR_TO_DATE(datum, "%d.%m.%Y") DESC');
	foreach($datechecker as $key){
		$num_rows = $key->status;
		if($num_rows != 0){			
			$sql = '	UPDATE		guestlist
					   	SET			status = 0
					   	WHERE		STR_TO_DATE(datum, "%d.%m.%Y") > NOW() - INTERVAL 1 DAY';
			$wpdb->query($sql);
		}
	}
		  ?>







<?php
 if(isset($_GET["archiv"])){
?>
	<div id="settingspoint" class="wrap postbox animated flash">
	<h3 class="hndle">Gästeliste Archiv</h3>
	<div class="postbox cdGrid2">
		<div id="release_row_one" class="release_row">
			<div class="release_col titleTab spalteBtnEdit">Edit</div>
			<div class="release_col titleTab spalteTitel">Name</div>
			<div class="release_col titleTab spalteLabel">Datum</div>
			<div class="release_col titleTab spalteTitel">Eventname</div>
			<div class="release_col titleTab spalteLabel">Einträge</div>
			<div class="release_col titleTab spalteText">Exportieren</div>
			<div class="release_col titleTab spalteLink">Löschen</div>
		</div>
	<?php 
	 	$guestlists_archive = $wpdb->get_results('SELECT * FROM guestlist WHERE status BETWEEN 1 AND 2 ORDER BY datum DESC');
	 	foreach($guestlists_archive as $key_archive){
			$event_archive = $key_archive->event_id;
			$entries_number_archive = $key_archive->id;
			$entries_archive = $wpdb->get_var('		SELECT		COUNT(Guestlist_id)
											FROM		entries
											WHERE 		Guestlist_id = '.$key_archive->id.'
											');
		?>
		<div style="opacity: 0.5;">  
			<div class="release_row">
				<div class="release_col spalteBtnEdit">
					<a href="admin.php?page=resignguestlist&edit=<?= $key_archive->id; ?>">
						<img src="../wp-content/plugins/resign-guestlist/css/button_edit.jpg" />
					</a>
				</div>
				<div class="release_col spalteTitel"><?= $key_archive->partyname; ?></div>
				<div class="release_col spalteLabel"><?= $key_archive->datum; ?>&nbsp;</div>
				<div class="release_col spalteTitel"><?php if(isset($event2["post_title"])){ echo $event2["post_title"]; }else{ echo "kein"; } ?></div>
				<div class="release_col spalteLabel"><?php echo $entries_archive; ?> </div>
				
				<?php if($entries_number_archive>0){ ?><div class="release_col spalteText"><a href="admin.php?page=resignguestlist&csv=<?= $key_archive->id; ?>">Excel speichern</a></div><?php } else{ ?><div class="release_col spalteText">Leer</div> <?php } ?>
				<div class="release_col spalteLink"><a href="admin.php?page=resignguestlist&del=<?= $key_archive->id; ?>"><img src="../wp-content/plugins/resign-guestlist/css/bt_delete.jpg" ></a></div>
			</div>
		</div>
		<?php 	
		}
	?>
	</div>
</div>
<div class="clear"></div><div class="clear"></div><div class="clear"></div>
<script>
	$("html, body").animate({ scrollTop: $('#settingspoint').offset().top }, 1000);
</script>
<?php
}
?>
<?php
 if(isset($_GET["showsettings"])){
?>
<div id="settingspoint" class="animated flash">
	<div class="postbox cdGrid">
		<h3 class="hndle">
			<span>Einstellungen</span>
		</h3>        
		<div class="form_NewEntry">
			<form method="POST" action="admin.php?page=resignguestlist&showsettings=showsettings&settings=settings" name="guestlist_form_settings" enctype="multipart/form-data" >

                <div class="form_NewEntryTxt">
					<div class="form_row">
						<div class="form_left">Email-Betreff</div>
						<div class="form_right">
							<input name="subject" type="text" value="<?php if(isset($settings_query2["subject"])){ echo $settings_query2["subject"]; } ?>" />
						</div>
					</div>
					<div class="form_row">
						<div class="form_left">Absender-Emailadresse</div>
						<div class="form_right">
							<input name="absendermail" type="text" value="<?php if(isset($settings_query2["absendermail"])){ echo $settings_query2["absendermail"]; } ?>" />
						</div>
					</div>
					<div class="form_row">
						<div class="form_left">Absender-Titeltext</div>
						<div class="form_right">
							<input name="absendertitel" type="text" value="<?php if(isset($settings_query2["absendertitel"])){ echo $settings_query2["absendertitel"]; } ?>" />
						</div>
					</div>


					<div class="form_row">
						<div class="form_left">Success-Titel</div>
						<div class="form_right">
                        	<input name="successtitel" type="text" value="<?php if(isset($settings_query2["successtitel"])){ echo $settings_query2["successtitel"]; } ?>" />
						</div>
					</div>
					<div class="form_row">
						<div class="form_left">Success-Message</div>
						<div class="form_right">
                        	<textarea name="successmsg"><?php if(isset($settings_query2["successmsg"])){ echo $settings_query2["successmsg"]; } ?></textarea>
						</div>
					</div>
                    
					<div class="form_row">
						<div class="form_left">Error-Titel</div>
						<div class="form_right">
                        	<input name="errortitel" type="text" value="<?php if(isset($settings_query2["errortitel"])){ echo $settings_query2["errortitel"]; } ?>" />
                         </div>
					</div>
					<div class="form_row">
						<div class="form_left">Error-Message</div>
						<div class="form_right">
                        	<textarea name="errormsg"><?php if(isset($settings_query2["errormsg"])){ echo $settings_query2["errormsg"]; } ?></textarea>
                         </div>
					</div>
                    
				<div class="form_row">
					<div class="form_left">&nbsp;</div>
					<div class="form_right">
						<p class="submit">
							<input name="submit" type="submit" value="Speichern" class="button-primary" style="width:140px;">
						</p>
					</div>
				</div>
            </div>
		   </form>
        </div>
</div>
<script>
	$("html, body").animate({ scrollTop: $('#settingspoint').offset().top }, 1000);
</script>
<?php } ?>



          <div style="clear:both;">
              <div style="width:140px; height:26px; float:left; margin-top: 1px; cursor:pointer; padding-right:5px; background-image:url(../wp-content/plugins/resign-guestlist/css/greybtn.jpg); background-repeat:no-repeat; font-family:Arial; font-weight:700; text-align:center;">
                <a style="float:left; height:20px; width:100%; text-align:center; padding-top:5px; text-shadow: 1px 1px 1px #FFF; color:#8a8a8a !important;" href="admin.php?page=resignguestlist&showsettings=showsettings">Einstellungen</a>
              </div>
              <div style="width:140px; height:26px; float:left; margin-top: 1px; cursor:pointer; padding-right:5px; background-image:url(../wp-content/plugins/resign-guestlist/css/greybtn.jpg); background-repeat:no-repeat; font-family:Arial; font-weight:700; text-align:center;">
                <a style="float:left; height:20px; width:100%; text-align:center; padding-top:5px; text-shadow: 1px 1px 1px #FFF; color:#8a8a8a !important;" href="admin.php?page=resignguestlist&archiv=archiv">Gästeliste Archiv</a>
              </div>
          </div>