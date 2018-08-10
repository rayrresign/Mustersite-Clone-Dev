<?php

//Erstellt im CMS die Post type (wocheplane Einstellungen und Wochenplan Kurse)
function wplan_custom_post_type() {
	
	// ID , CMS Name, Position
	resign_register_post_type('wplan_einstellungen', 'Wochenplan Einstellungen', 5.0);
	resign_register_post_type('kurs', 'Wochenplan Kurse', 5.0);
	
}

// Lade die Funktion in die init stage 
add_action('init', 'wplan_custom_post_type', 0);


?>