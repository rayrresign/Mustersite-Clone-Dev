<?php
/** Implemntieren von den ACF Fields im Backend */

/** 
*	Info	acf Field für Wochenplan Einstellungen
*/

if (function_exists("register_field_group")) {
	register_field_group(array(
		'id'		=> 'acf_wplan_einstellungen',
		'title'		=> 'wochenplaneinstellungen',
		'fields'	=> array(
			array(
				'key'				=> 'field_wplan_1',
				'label'				=> 'Startzeit für den Wochenplan',
				'name'				=> 'wplan_startzeit',
				'type'				=> 'date_time_picker',
				'instructions'		=> 'Um welche Uhrzeit soll der Arbeitstag starten (z.B. 07:00 oder 07:30)',
				'show_date'			=> 'false',
				'required'			=> 1,
				'date_format'		=> 'd-m-y',
				'time_format'		=> 'H:mm',
				'show_week_number'	=> 'false',
				'picker'			=> 'select',				
				'save_as_timestamp' => 'true',
				'get_as_timestamp'	=> 'true',
			),
			array(
				'key'				=> 'field_wplan_2',
				'label'				=> 'Endzeit für den Wochenplan',
				'name'				=> 'wplan_endzeit',
				'type'				=> 'date_time_picker',
				'show_date'			=> 'false',
				'date_format'		=> 'd-m-y',
				'instructions'		=> 'Um welche Uhrzeit ist der Arbeitstag fertig (z.B. 17:00 oder 17:30)',
				'required'			=> 1,
				'time_format'		=> 'H:mm',
				'show_week_number'	=> 'false',
				'picker'			=> 'select',				
				'save_as_timestamp' => 'true',
				'get_as_timestamp'	=> 'true',
			),
			array(
				'key'				=> 'field_wplan_3',
				'label'				=> 'Zeit Intervall',
				'name'				=> 'wplan_zeittakt',
				'type'				=> 'radio',
				'instructions'		=> 'Definieren sie in welche abstanänden sie Ihre Kurse anbieten',
				'choices'			=> array(
										'3600'	=> 'Stundentakt',
										'1800'	=> 'Halbstundentakt',
										),
				'other_choice'		=> 0,
				'required'			=> 1,
				'save_other_choice'	=> 0,
				'default_value'		=> '',
				'layout'			=> 'vertical',
			),
			array(
				'key'				=> 'field_wplan_4',
				'label'				=> 'Mailtext',
				'name'				=> 'wplan_mailtext',
				'type'				=> 'textarea',
				'instructions'		=> 'Nachricht, die in der E-Mail an den Kunden geschickt wird',
				'required'			=> 1,
				'default_value'		=> '',
				'placeholder'		=> 'Beispiel: Vielen das für Ihre Anmeldung, wir kontaktieren Sie so bald wie möglich. max. 150 Zeichen',
				'formatting'		=> 'html',
				'maxlength'			=> '160',
			),
			array(
				'key'				=> 'field_wplan_5',
				'label'				=> 'Name für den Absender',
				'name'				=> 'wplan_absender_name',
				'type'				=> 'text',
				'instructions'		=> 'Geben sie den Name an, welcher als Absender im E-Mail gezeigt wird',
				'required'			=> 1,
				'default_value'		=> '',
				'placeholder'		=> 'z.B. Ihr Vor- oder Nachname',
				'formatting'		=> 'html',
				'maxlength'			=> '60',
			),
			array(
				'key'				=> 'field_wplan_6',
				'label'				=> 'Absender E-Mail Adresse',
				'name'				=> 'wplan_absender_mail',
				'type'				=> 'email',
				'instructions'		=> 'E-Mail Adresse, an welche die Anmeldung geschickt wird.',
				'required'			=> 1,
				'default_value'		=> '',
				'placeholder'		=> 'info@example.ch',
			),
			array(
				'key'				=> 'field_wplan_7',
				'label'				=> 'Erfolgreiches Anmelden',
				'name'				=> 'wplan_suc_text',
				'type'				=> 'textarea',
				'instructions'		=> 'Mitteilung, welche nach erfolgreichem Senden erscheint',
				'required'			=> 1,
				'default_value'		=> '',
				'placeholder'		=> 'Beispiel: Die Anmeldung wurde erfolgreich übermittelt. max. 150 Zeichen',
				'rows'				=> '3',
				'formatting'		=> 'html',
				'maxlength'			=> '160',
			),
			array(
				'key'				=> 'field_wplan_8',
				'label'				=> 'Fehlerhaftes Anmelden',
				'name'				=> 'wplan_fail_text',
				'type'				=> 'textarea',
				'instructions'		=> 'Erscheint nach nicht erfolgreicher Anmeldung unter dem Anmeldeformular',
				'required'			=> 1,
				'default_value'		=> '',
				'placeholder'		=> 'Beispiel: Die Anmeldung konnte nicht übermittelt werden. Bitte überprüfen Sie Ihre Eingaben  max. 150 Zeichen',
				'rows'				=> '3',
				'formatting'		=> 'html',
				'maxlength'			=> '',
			),
		),		
		'location'	=> array(
			array(
				array(
					'param'			=> 'post_type',
					'operator'		=> '==',
					'value'			=> 'wplan_einstellungen',
					'order_no'		=> 0,
					'group_no'		=> 0,
				),
			),
		),
		'options'	=> array(
			'position'				=> 'normal',
			'layout'				=> 'no_box',
			'hide_on_screen'	=> array(
				0					=> 'permalink',
				1					=> 'the_content',
				2					=> 'featured_image',
				3					=> 'categories',
			),
		),		
		
		'menu_order'			=> 0,
		
	));
}

/** 
*	Info	acf Field für einzelne Kurse
*/
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_wplan_kurs',
		'title' => 'Kurs',
		'fields' => array (
			array(
				'key'				=> 'field_kurs_wplan_1',
				'label'				=> 'Startzeit für den Kurs',
				'name'				=> 'kurs_wplan_startzeit',
				'type'				=> 'date_time_picker',
				'instructions'		=> 'Um welche Uhrzeit startet der Kurs (Stündlich oder Halbstündlich).',
				'show_date'			=> 'false',
				'required'			=> 1,
				'date_format'		=> 'd-m-y',
				'time_format'		=> 'H:mm',
				'show_week_number'	=> 'false',
				'picker'			=> 'select',				
				'save_as_timestamp' => 'true',
				'get_as_timestamp'	=> 'true',
			),
			array(
				'key'				=> 'field_kurs_wplan_2',
				'label'				=> 'Endzeit für den Kurs',
				'name'				=> 'wplan_endzeit',
				'type'				=> 'date_time_picker',
				'show_date'			=> 'false',
				'date_format'		=> 'd-m-y',
				'instructions'		=> 'Um welche Uhrzeit endet der Kurs (Stündlich oder Halbstündlich).',
				'required'			=> 0,
				'time_format'		=> 'H:mm',
				'show_week_number'	=> 'false',
				'picker'			=> 'select',				
				'save_as_timestamp' => 'true',
				'get_as_timestamp'	=> 'true',
			),
			array (
				'key' 				=> 'field_kurs_wplan_3',
				'label' 			=> 'Wochentag',
				'name' 				=> 'wplan_wochentag',
				'type' 				=> 'radio',
				'instructions'		=> 'An Welchen Wochentag findet der Kurs statt.',
				'required'			=> 1,
				'choices' => array (
					'1' => 'Montag',
					'2' => 'Dienstag',
					'3' => 'Mittwoch',
					'4' => 'Donnerstag',
					'5' => 'Freitag',
					'6' => 'Samstag',
					'7' => 'Sonntag',
				),
				'other_choice' 		=> 0,
				'save_other_choice' => 0,
				'default_value' 	=> '',
				'layout' 			=> 'vertical',
			),
			array (
				'key' 				=> 'field_kurs_wplan_4',
				'label' 			=> 'Startdatum',
				'name' 				=> 'wplan_startdatum',
				'instructions'		=> 'An welchem Datum startet der Kurs',
				'required'			=> 1,
				'type'			 	=> 'date_picker', 
				'date_format' 		=> 'dd-mm-yy',
				'display_format' 	=> 'dd.mm.yy',
				'first_day'			 => 1,
			),
			array (
				'key' 				=> 'field_kurs_wplan_5',
				'label' 			=> 'Enddatum',
				'name' 				=> 'wplan_enddatum',
				'instructions'		=> 'Wann ist Kurs fertig <br>Ganzjährige Kurse: &nbsp;&nbsp;Leer lassen <br>Einmalige Kurse:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Enddatum auf die jetztige Woche setzen.',
				'required'			=> 0,
				'type'			 	=> 'date_picker', 
				'date_format' 		=> 'dd-mm-yy',
				'display_format' 	=> 'dd.mm.yy',
				'first_day'			 => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' 		=> 'post_type',
					'operator' 		=> '==',
					'value'			=> 'kurs',
					'order_no' 		=> 0,
					'group_no' 		=> 0,
				),
			),
		),
		'options' 				=> array (
			'position'	 			=> 'normal',
			'layout' 				=> 'no_box',
			'hide_on_screen' 		=> array (),
		),	
		'menu_order' 				=> 0,
	));
}

register_field_group(array(
		'id'		=> 'acf_wplan_einstellungen',
		'title'		=> 'wochenplaneinstellungen',
		'fields'	=> array(
			array(
				'key'				=> 'field_wplan_4',
				'label'				=> 'Mailtext',
				'name'				=> 'wplan_mailtext',
				'type'				=> 'textarea',
				'instructions'		=> 'Nachricht, die in der E-Mail an den Kunden geschickt wird',
				'required'			=> 1,
				'default_value'		=> '',
				'placeholder'		=> 'max. 150 Zeichen',
				'formatting'		=> 'html',
				'maxlength'			=> '160',
			),
		),
		'location' => array (
			array (
				array (
					'param' 		=> 'post_type',
					'operator' 		=> '==',
					'value'			=> 'kurs',
					'order_no' 		=> 0,
					'group_no' 		=> 0,
				),
			),
		),
		'options' 				=> array (
			'position'	 			=> 'normal',
			'layout' 				=> 'no_box',
			'hide_on_screen' 		=> array (),
		),	
		'menu_order' 				=> 0,
	));
?>