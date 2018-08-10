<?php

/** ¨berprpüfen ob alle Klasse,Funktionen vorhanden sind. */

// überprüft, ob die Klasse/plugin advanced custom fields und das Add-on 
// date time Picker existiert, falls nicht wird hier abgebrochen.
if ( !class_exists('acf') ) return;
if ( !class_exists('acf_field_date_picker') ) return;


/** Files einbinden */

// definiere die Konstante Wochenplan 
// /cm/wp-content/themes/musterpage/module/wochenplan
define( '__WOCHENPLAN__', dirname( dirname(__FILE__) ) );

/* Variablen Deklarieren */

// die jetzige Woche und Jahr, in der wir uns befinden.
$currentWeek = date( 'W' );
$currentYear = date( 'Y' );

// Wochentage Array
$weekdays_arr = array( '1' => 'Mo', '2' => 'Di', '3' => 'Mi', '4' => 'Do', '5' => 'Fr', '6' => 'Sa', '7' => 'So' );

/** Files registrieren */

// Einbinden der wplan_custom-post-types4
require_once __WOCHENPLAN__ . '/functions/wplan_functions-post-type.php';

// Einbinden der wplan_custom-post-types4
require_once __WOCHENPLAN__ . '/anmelden/wplan_anmelden-function.php';

// lädt das File, welches die Custom Fields genereiert
require_once __WOCHENPLAN__ . '/custom-fields/wplan_acf.php';


// ajaxurl wird benötigt für die ganzen Ajax calls
add_action( 'wp_footer', 'add_ajaxurl_footer' );
function add_ajaxurl_footer(){	
	?>
	<script>
		var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>"; 
	</script>
	<?php
}
// lädt Css und js Files Korrekt in WordPress
	// css
function wplan_styles() {
	wp_enqueue_style( 'wplan_css', get_template_directory_uri() . '/module/wochenplan/css/wplan_style.css', array(), '0.1', 'all' );
}
add_action( 'wp_enqueue_scripts', 'wplan_styles' );

	// JS
function wplan_js() {
	wp_enqueue_script( 'wplan_js',  get_template_directory_uri() . '/module/wochenplan/js/wplan_script.js', '0.1', true );
}
add_action( 'wp_enqueue_scripts', 'wplan_js' );

/** Shortcode */
/**
*	Info	Registriert im Template ein "shortcode" damit, der Wochenplan überall 
*			eingebaut werden kann, Funktioniert auch im CMS
*	return	den neu befüllten buffer - Ouptut	
*
*/
function wplan_shortcode() {
	
	// die jetzige Woche und Jahr, in der wir uns befinden.
	// damit mit den richtigen Daten gearbeitet wird müssen sie im Shortcode registriert werden
	$currentWeek = date( 'W' );
	$currentYear = date( 'Y' );

	// Mitgebend er Wochentage im Shortcode
	$weekdays_arr = array( '1' => 'Mo', '2' => 'Di', '3' => 'Mi', '4' => 'Do', '5' => 'Fr', '6' => 'Sa', '7' => 'So' );
	
	 //aktiviert Ausgabe buffer (Schreibt alles was nachher kommt in den Buffer)
	// alle schripts und functions ausser Header
	ob_start();
	// läd das File, wo die gesamte Strukur abhängt
	require( __WOCHENPLAN__ . '/wochenplan.php' );
	
	// holt den abgefüllten Buffer und löscht den Aktuelle.
	$content = ob_get_clean(); 
	
	return $content;
	
};
add_shortcode( 'res_wochenplan', 'wplan_shortcode') ;


/* Funktionen für Datenabfrage von Backend */

/**
* 	Info:	Auslagerung der Wordpress Query
*	return	Array mit Startzeit, Endzeit und Timeflag
*	
*/
function get_wplan_values(){
	
	//Variablen Definieren 	
	$wplanPostId = '';
	
	// holt die $post_id von den einstellungen
	$queryArgs = array( 'post_type' => 'wplan_einstellungen','posts_per_page' => '1' ); 	// Array für die Abfrage 
	$wplan_settings = get_posts( $queryArgs ); 											// alle Posts von wochenplaneinstellungen ( nur 1)
	
	
	foreach( $wplan_settings as $key ){
		// holt ID Wochenplaneinstellungs Objekt
		$wplanPostId = $key->ID; 
	}
	// füllt das Einstellungs Array
	$wplan_settings_arr = array(
				'startTime' 	=> get_field( 'wplan_startzeit' 	, $wplanPostId ),  		// Startzeit des Wochenplanes
				'endTime' 		=> get_field( 'wplan_endzeit' 		, $wplanPostId ),  		// Endzeit des Wochenplanes
				'timeflag' 		=> get_field( 'wplan_zeittakt' 		, $wplanPostId ),  		// Intervall des Wochenplanes
				'mailText' 		=> get_field( 'wplan_mailtext' 		, $wplanPostId ),  		// Mailtext des Wochenplanes
				'absenderName' 	=> get_field( 'wplan_absender_name' , $wplanPostId ),  	// Name des Absenders des Wochenplanes
				'absenderMail' 	=> get_field( 'wplan_absender_mail' , $wplanPostId ),  	// Mail des Absenders des Wochenplanes
				'succesMail' 	=> get_field( 'wplan_suc_text' 		, $wplanPostId ),  		// Efoglsmeldung im Mail des Wochenplanes
				'failMail' 		=> get_field( 'wplan_fail_text' 	, $wplanPostId ),  		// Fehler Meldung des Wochenplanes
	);
	
	return $wplan_settings_arr;
}

/**
* 	Info:	Holt alle Kurs Beiträge aus dem CMS Backend, die der Kunde erstellt han.
*	return	Array mit gefilterten Kursen
*/
function get_course_from_backend( $currentWeek ){
	
	$course_arr = array();
	
	$args = array(
		'post_per_page'		=> '-1',
		'post_type' 		=> 'kurs',
		'order' 			=> 'ASC',
	);
	// Pusht infos im WordPress loop in Array
	$the_query = new WP_Query($args);
	if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
	
	$courseStartTableTime 	= date('Hi', (get_field('kurs_wplan_startzeit')));
	$courseStartTime 		= date('H:i', (get_field('kurs_wplan_startzeit')));
	$courseStartMin 		= date('i', (get_field('kurs_wplan_startzeit')));
	$courseEndDate 			= str_replace('-','.', get_field('wplan_enddatum'));
	$courseEndWeek			= date('W' ,strtotime(get_field('wplan_enddatum')));
	$courseStartWeek		= date('W' ,strtotime(get_field('wplan_startdatum')));
	$course_title_short		= title(3);
	$course_title			= get_the_title();
	
	array_push($course_arr, array(
							'course_Id' 			=> get_the_ID(),
							'course_StartTableTime' => $courseStartTableTime,
							'course_StartMin' 		=> $courseStartMin,
							'course_StartTime' 		=> $courseStartTime,
							'course_Weekday'		=> get_field('wplan_wochentag'),
							'course_EndDay' 		=> $courseEndDate,
							'course_EndWeek' 		=> $courseEndWeek,
							'course_Title_Short'	=> $course_title_short,
							'course_Title' 			=> $course_title,
							'course_StartWeek' 		=> $courseStartWeek,
							)
			  );
	
	endwhile; endif; 
	wp_reset_postdata();
	
	$course_arr = check_time_by_kurse_and_by_date( $course_arr, $currentWeek );
	
	return $course_arr;
}


/* Funktionen für Datenaufbereitung */

/*
*	Info	Überprüft anhand des Intervalls ob die Zeit für die Ausgabe passt, falls nicht rundet hoch/runter
*			Überprüft anschliessend ob der Kurs, in der angezeigt Woche noch existieren darf oder nicht, löscht Array Eintrag.
*	return	Bereinigtes Kurs Array
*/
function check_time_by_kurse_and_by_date( $course_arr , $currentWeek ){
	
	$post_array = get_wplan_values();
	$timeFlag = intval( $post_array['timeflag'] );
	
	foreach( $course_arr as $key => $val ){
		// nimmt von 0716 nur 16 und wandelt es in einen String
		$time = substr( $val['course_StartTableTime'], 2 ,4 );		
		$time = intval( $time );
		
		// Halstündlich
		if($timeFlag == 1800){			
			if($time > 0 && $time <= 29){ 
				$course_arr[$key]['course_StartTableTime'] -= $time;  // 16 - 16
			} else if($time >= 31 && $time <= 59){
				$range = 30 - $time;
				$course_arr[$key]['course_StartTableTime'] += $range; // 16+(30-16)
			}			
			
		} else if($timeFlag == 3600){ // Stündlich
			if($time > 0 && $time <= 59){
				$course_arr[$key]['course_StartTableTime'] -= $time; // 54 - 54
			}
		}
		
		if(strlen($course_arr[$key]['course_StartTableTime']) == 3){
			$course_arr[$key]['course_StartTableTime'] = '0'.$course_arr[$key]['course_StartTableTime'];
		}
		
		// Endwoche des Termine und StartWoche des Termines
		$endWeek = $val['course_EndWeek'];
		$startWeek = $val['course_StartWeek'];
		
		// Im Falle keines Ablauf datums
		if($endWeek == 1){
			$endWeek = $currentWeek + 1;
		}
		// aktuelle Woche z.B 16 > Woche von Kurs - lösche aus Array
		if( $currentWeek > intval( $endWeek ) || $currentWeek <  intval( $startWeek )){
			unset( $course_arr[$key] );
		}
	}		
	return $course_arr;
}

/**
* 	Info:	Holt Anhand der ID von Wochenplaneinstellung die Start- und Endzeit und berechnet
*			anhand des Intervalls die Zeit dazwischen im 30 oder 60 min Takt
*	return 	Array mit den Zeiten
*	
*/
function calculate_times_from_wplan_settings(){
	
	// wplan_settings_arr
	$times_arr = get_wplan_values();
	
	$startTime	= $times_arr['startTime'];
	$endTime 	= $times_arr['endTime'];
	$timeflag	= $times_arr['timeflag'];
	
	$intervall_arr = get_hours_range( $startTime, $endTime, $timeflag, 'Hi' );
	
	return $intervall_arr;
}

/** 
*	Info		Berechnet die Zeit zwischen 2 Uhrzeiten 
*	@Param 1: 	Startzeit von wplan_Einstellungen
*	@Param 2:	Endzeit von wplan_Einstellungen
* 	#Param 3:	Intervall von wplan_Einstellungen
* 	#Param 4:	Format der Zeitdarstellung
*	return		Array mit Zeiten 
*
*/
function get_hours_range( $start, $end, $intervall, $format  ) {
	// Array vordefinieren
	$times_arr = array();
	
	foreach ( range( $start, $end, $intervall ) as $key => $timestamp ) {
			$hour_mins = date( 'Hi', $timestamp );
			// falls kein Format gewählt wird
			if ( ! empty( $format ) ) {				
				$times_arr[$hour_mins] = date( $format, $timestamp );
			} else {
				$times_arr[$key] = $hour_mins;
			}
	}	
	return $times_arr;
}

/**
*	Info	Berechnet Anhand der jetztigen Woche und Jahr die Daten von Montag - Freitag
*	return	Array mit, mit den Daten der jetztigen Woche	
* 
*/
function get_dates_of_current_week( $currentWeek, $currentYear ){
	// Neue Zeit initialisieren
	$date = new DateTime();
	// Array initialisieren
	$dates_arr = array();
	// für jeden Tag ein neues Datum erstellen, anhand der Woche und Jahr
	for ( $i = 1; $i <= 7; $i++ ) {
		$date->setISODate($currentYear, $currentWeek , $i);
		$dates_arr[$i] = $date->format( 'd.m.y' ); // z.B 19.04.18
	}
	return $dates_arr;	
} 


/** Funktionen für Frontend View */

/**
*	Info:		Erstellt die erste Reihe im Wochen plan (Zellen, Mo, Di, Mi....)
*	@Param 1: 	Wochentage
*	@Param 2:	Zeiten aus dem Backend 
* 	#Param 3:	Die jetztige Woche
* 	#Param 4:	Das jetztige Jahr
*/
function show_wplan_desktop( $weekdays_arr, $times, $currentWeek, $currentYear ){	
	// hollt die Daten der Jetztigen Woche
	$curren_week_dates_arr = get_dates_of_current_week( $currentWeek, $currentYear );
	?>
	<div id="res_wplan">
		<?php  week_of_current_view( $currentWeek ); //Kalenderwoche: 16 ?> 
		<div class="row table-row text-center">
			<div class="table-title wplan-col"> Zeit </div> 
		<?php
		//für jeden Wert im Wochendatum Array
		for($i = 1; $i <= count( $curren_week_dates_arr) ; $i++){
			?>
			<div class="table-title wplan-col">
				<div class="table-title-day weekday-<?php echo $i; ?>"> <?php echo $weekdays_arr[$i]; // Mo, Di, Mi ?></div>
				<div class="table-title-date weekdate-<?php echo $i; ?>"> <?php echo $curren_week_dates_arr[$i]; //Datum ?></div>
			</div>
			<?php
		}
		// Funktionsaufruf für die Tabelle
		create_wplan_board( $weekdays_arr, $times, $currentWeek );
		?>
		</div>
	</div>
<?php	
}
/**
*	Info:		Erstellt den kompletten Wochenplan für mobile
*	@Param 1: 	Wochentage
*	@Param 2:	Zeiten aus dem Backend 
* 	#Param 3:	Die jetztige Woche
* 	#Param 4:	Das jetztige Jahr
*/
function show_wplan_mobile( $weekdays_arr, $times, $currentWeek, $currentYear ){
	// WP Query für alle Kurse
	$args = array(
			'posts_per_page' => '-1',
			'post_type' => 'kurs',
			'meta_key' => 'wplan_wochentag', 
			'orderby'=> 'meta_value',	 
			'order'=> 'ASC'		
        );
	
        $the_query = new WP_Query($args); 
		// Z$hler für Kurse
		$courseCount = 0;
	
	?>

    <div id="wkpln_mobile"> 
		<div id="res_wplan_mobile">
			<?php  week_of_current_view( $currentWeek ); //Kalenderwoche: 16 
		// Ausgabe, falls keine Posts vorhanden sind.
		// loop durch Beiträge für dei Ausgabe
		if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
		//Variablen definieren
		$year 				= $currentYear; 										//2018
		$courseWeekDay 		= $weekdays_arr[get_field('wplan_wochentag')];			// Wochentag in Nr. 
		$kursStartTime		= date( "H:i", ( get_field('kurs_wplan_startzeit') ) );		// Startzeit in Normal zeit 07:00
		$courseEndWeek		= date( 'W' ,strtotime( get_field('wplan_enddatum') ) );	// Woche des Enddatums
		$courseStartWeek	= date( 'W' ,strtotime( get_field('wplan_startdatum') ) );	// Woche des Enddatums
	
	
		// Zeigt das Datum Anhand des Jahres, Woche und Wochentag
		$courseDate = new DateTime();
		$courseDate->setISODate ($year, $currentWeek, array_search( $courseWeekDay, $weekdays_arr ) ); 	//year , week num , day
		$courseDate = $courseDate->format('d.m.y');														// 04.24.16
		$output = $courseWeekDay. ', '. $courseDate. ' - '.  $kursStartTime .' Uhr';					//konkatenieren für den Output	
		// Falls das Enddatum nicht gesetzt ist.
		if ($courseEndWeek == 1){
			$courseEndWeek = $currentWeek + 1; // läuft unendlich
		}
	
		//Abfrage für Ablaufdatum, damit Kurs nicht geladen wird.
	
		if( intval($courseEndWeek) >= $currentWeek && intval($courseStartWeek) <= $currentWeek ){
			// erhöht den Zähler wenn ein Kurs in der Woche angezeigt wird.
			$courseCount++;
		?>
			<div class="well-bottom hasCourse">
				<a href="#" class="load-content" 
				onclick="javascript: jQuery('#terminModalBox').modal('show'); return false;"  
				data-value="<?php echo $kursStartTime; ?>" 
				data-date="weekdate-<?php the_field('wplan_wochentag') ?>"  
			   	data-title="<?php the_title(); ?>" 
			   	data-day="weekday-<?php the_field('wplan_wochentag') ?>" 
				data-id="<?php the_ID(); ?>">

					<div class="postContent mobileContent" id="<?php echo $courseWeekDay; ?>">
						<i class="fa fa-external-link"></i>
						<h3><?php the_title(); ?></h3>
						<h4><?php echo $output;  ?></h4>
					</div>
				</a>
			</div>
		  <?php 	
		} 
			wp_reset_postdata(); 		?>
		  <?php endwhile; endif; 
		// Fals keine Kurse in dieser Woche Sind.
		if( $courseCount == 0 ){
		?>
			<div class="well-bottom text-center">
				<p> Keine Kurse in dieser Kalenderwoche vorhanden </p>
			</div>
		  <?php 
		}
			?>
		</div>
	</div>

	<?php
}
/**
*	Info:		Erstellt die erste Reihe im Wochen plan (Zellen, Mo, Di, Mi....)
*	@Param 1: 	Wochentage
*	@Param 2:	Zeiten aus dem Backend    
* 	#Param 3:	Die jetztige Woche
* 	#Param 3:	Das jetztige Jahr
*/
function create_wplan_board( $weekdays_arr, $times, $currentWeek ){
	$course_arr = get_course_from_backend( $currentWeek );
	// foreach loop durch jede Zeit zwischen Startzeit und Endzeit im mitgegebenen Intervall
	foreach( $times as $singleTime ){	
			$beautifulSingleTime = strtotime( $singleTime) ;
			$beautifulSingleTime = date( 'H:i',$beautifulSingleTime ); //Ausgabe Zeit für Darstellung				
		?>
			<div class="table-zellen wplan-col" id="<?php echo $singleTime ?>"> <?php echo $beautifulSingleTime ?> </div>
		<?php
			// for-loop druch Anzahl Tage, damit die Tabelle nie breiter wird als 7
			for( $i = 1; $i <= count($weekdays_arr); $i++ ){
//				// loop durch alle Kurse, Pro einzelnen Tag und Uhrzeit
				foreach( $course_arr as $key => $value ){
					// loop durch anzahl Kurse, die im Array vorhanden sind.
					for( $j = 1; $j <= count($course_arr); $j++ ){
						// Abfrage ist: 0700_2 == 0700_2
						if($singleTime.'_'.$i == $value['course_StartTableTime'].'_'.$value['course_Weekday']){
							?>
						<div class="table-zellen hasCourse courseDesktop wplan-col course text-left" id="<?php echo $value['course_StartTableTime'] ?>">
         					<a href="#" class="courseTable load-content" 
							   onclick="javascript: jQuery('#terminModalBox').modal('show'); return false;" 
							   data-id="<?php echo $value['course_Id'] ?>"
							   data-value="<?php echo $value['course_StartTime']; ?>" 
							   data-title="<?php echo $value['course_Title'] ?>" 
							   data-day="weekday-<?php echo $i; ?>" 
							   data-date="weekdate-<?php echo $i; ?>" 
							   data-thumb="true"> 
								<?php echo $value['course_Title_Short'] ?>
							<i class="fa fa-external-link"></i>
							</a> 
						</div>
							<?php
						$i = $i + 1;
						} 
					}
				}		
				// Wenn der Termin am Sonntag ist, darf kein neues leeres Feld entstehen
				if($i <= 7){	?>
				<div class="table-zellen wplan-col" id="<?php echo $singleTime.'_'.$i ?>"></div> 
			<?php 
				}
			}
		?>
		<?php
	}
}

/**
*	Info	Anzeige für kalenderwoche, inkl. Vor und Zurück, löst Ajax Call aus.
*	param	Woche in der sicher der User befindet
*
*/
function week_of_current_view($week){
	
	$currentWeek = intval( date( 'W' ) );
	
	$nextWeek = intval( $week )+1;
	$lastWeek = intval( $week )-1;
	$week_nr = $week;	
	
	/* 
		Wenn Woche >52 ist setze es wieder auf 1 
		
	*/
	if($week > 52){
		$tmp = $week_nr - 52*intval( $week/52 ); //  tmp = angezeigte Woche - 52*(angezeigte Woche / 52 )
		if($tmp != 0) {
			$week_nr = $tmp; // Wenn nicht 0 dann  angezeigte Woche = tmp
		} else {
			$week_nr = 52; 	// week nr auf 52 setzen
		} 
	}
?>
<div class="calendarWeek text-center">
	<i <? if( $currentWeek >= $week ){ echo 'style="display: none"'; } ?> data-val="<?php echo $lastWeek; ?>" class="fa fa-chevron-left changeDate"></i>
		<h4>Kalenderwoche: <?php echo $week_nr; ?></h4> 
	<i data-val="<?php echo $nextWeek; ?>" class="fa fa-chevron-right changeDate"></i>
</div>
		<?php
}

/** Funktionen für Ajax */

/**
*	Info			Registriert die Ajax Funktion für Wochenwechsel im WordPress header
*	wp_ajax 		für eingeloggte User
*	wp_ajax_nopriv	nicht eingeloggte User
*	wp_die()		beendung der funktion
*
*/
add_action( 'wp_ajax_wplan_ajax_handling', 'wplan_ajax_handling' );
add_action( 'wp_ajax_nopriv_wplan_ajax_handling', 'wplan_ajax_handling' );
function wplan_ajax_handling(){
	// anschliessende oder Vergangene Woche als int
	$week = intval( $_POST['dataString'] );	
	
	// Initialisieren des Wochentag arrays
	$weekdays_arr = array( '1' => 'Mo', '2' => 'Di', '3' => 'Mi', '4' => 'Do', '5' => 'Fr', '6' => 'Sa', '7' => 'So' );
	$currentYear = date( 'Y' );
	
	// Funktions aufrufe mit den neuen Daten, anschliessende Woche oder vergangene Woche 
	echo show_wplan_desktop( $weekdays_arr, calculate_times_from_wplan_settings(), $week , $currentYear );
	echo show_wplan_mobile( $weekdays_arr, calculate_times_from_wplan_settings(), $week , $currentYear );
	
	// auflösen der Aktion
	wp_die();
}
/**
*	Info			Registriert die Ajax Funktion für Anzeige in er Modalbox im WordPress header
*	wp_die()		beendung der funktion
*
*/
add_action( 'wp_ajax_wplan_ajax_get_post_by_id', 'wplan_ajax_get_post_by_id' );
add_action( 'wp_ajax_nopriv_wplan_ajax_get_post_by_id', 'wplan_ajax_get_post_by_id' );
function wplan_ajax_get_post_by_id(){	
	// Die ID des Beitrages, welcher angeklickt wurde als int
    $post_id = intval( $_POST['dataPostId'] );	
	
	//holt die Infos von den Wochenplaneinstellungen
	$custom_mail_settings = get_wplan_values();	
	
	// erstellt das Beitrags-objekt Anhand der ID
	$post_object = get_post( $post_id );
	
	// Holt die URL des Beitrag-bildes mit der Grösse 440x270
	$post_img = wp_get_attachment_image_src(  get_post_thumbnail_id( $post_id ), 'res-crop-thumbnail' );
	
	// Füllt zusatzdaten in das Beitrags-objekt für die Darstellung und Mailversand
	$post_object->url 			= $post_img[0];
	$post_object->mailText 		= $custom_mail_settings['mailText'];
	$post_object->absenderName 	= $custom_mail_settings['absenderName'];
	$post_object->absenderMail 	= $custom_mail_settings['absenderMail'];
	$post_object->succesMail 	= $custom_mail_settings['succesMail'];
	$post_object->failMail 		= $custom_mail_settings['failMail'];
	
	// Verwandelt das Objekt in JSON
    $post_object = json_encode( $post_object );
	
	// ausgabe für den Ajax Response
	echo $post_object;	
	
	// auflösen der Aktion
	wp_die();	
}


?>








