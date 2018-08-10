jQuery( document ).ready( function($) {	
	
	/**
	*	Info	Wochenwechsel Klick funktion 
	*			leert das bestehende Div und füllt Div mit dem neuen Wert 
	*
	*/
	$( document ).on( 'click', '.changeDate', function(){		
		// vergangen oder nächste Woche
		var dataString = $(this).data('val');
		
		$.ajax({
				type: "POST",
				url: ajaxurl, //wp-admin/admin-ajax.php
				data: {
					action : 'wplan_ajax_handling', // Zielfunktion, welche mit den Daten Arbeiten soll
					dataString : dataString,		// Daten
				},
				success: function(data){					
					// denn Response in HTML speichern 
					var response = $( '<html />' ).html(data);
										
					// die ID des Wochenplanes suchen, damit nur die Sektion ausgewählt wird
					var res = response.find( '#res_wplan' );
					var resMobile = response.find( '#res_wplan_mobile' );
					// das Div, welches die Tabelle für den Desktop beinhaltet leeren, und mit dem Repsonse abfüllen
					$( '#wplan_desktop' ).empty(); // 
					$( '#wplan_desktop' ).html( res );
					
					// das Div, welches die Tabelle für den Mobile View beinhaltet leeren, und mit dem Repsonse abfüllen
					$( '#wplan_mobile' ).empty(); // 
					$( '#wplan_mobile' ).html( resMobile );					
				}
			  });
	});
	
	/**
	*	Info 	2 Handler für Infos in Modal laden
	*			damit nach Wochenwechsel click immernoch funktioniert
	*
	*/
	$( '.hasCourse a' ).on( 'click', function(){		
		show_info_in_modal( $(this) );
	});
	$( document ).on( 'click', '.hasCourse a', function(){	
		show_info_in_modal( $(this) );	
	});
	
	/**
	*	Info	Handelt den response, wenn auf ein Kurs geklickt wird
	*			Holt die von Info des Kurs Div und holt Anhand der Beitrag ID
	*			das Beitrags-Objekt
	*
	*/
	function show_info_in_modal(course){
		// vorbereitung Daten
		var dataId 		= course.data( 'id' ), 			// Kurs ID
			dataVal 	= course.attr( 'data-value' ), 	// Kurs Zeit
			courseDay 	= course.attr( 'data-day' ),	// Kurs Tag - (1,2,3)
			courseDate 	= course.attr( 'data-date' ),	// Kurs Datum
			title 		= course.attr( 'data-title' ),	// Kurs Titel
			getDay 		= $( '.' + courseDay ).text(),		// Tage anzeige - Mo,Di
			getDate 	= $( '.' + courseDate ).text(),		// Datum anzeige von Titel Reihe 
			courseInfo	= $( '#courseInfos' );			// Div für abfüllen
				
		$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action : 'wplan_ajax_get_post_by_id', 	// Zielfunktion
					dataPostId : dataId,					// ID des angeklickten Beitrages
				},
				success: function(data){
					// wandelr den JSON-String in JS Wert um 
					var response = JSON.parse(data);
					// Abfüllen der Bild URL in img html tag
					var img = $( "<img class='img-responsive imgmodal' />" ).attr( 'src', response.url );
					
					// leert das Div in der Modalbox, damit keine doppelte Anzeige entsteht
					courseInfo.empty();
					// Hinzufügen des Titel in Modalbox
					courseInfo.append(
						$('<div>').addClass('postContent well-bottom')
						.append($('<h4>').attr('id', 'coursTitel').text(title))
					);
					// Hinzufügen des des Datum und der Zeit in Modalbox
					courseInfo.append(
						$('<div>').addClass('row well-bottom infomodal')
						.append($('<div>').addClass('col-xs-6 col-sm-4')
							.append($('<div>').addClass('postContent'))
								.append($('<div>').attr('id', 'courseDate'))
									.append('<i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp' + getDay + ', ' + getDate)
							   )
						.append($('<div>').addClass('col-xs-6 col-sm-3')
							.append($('<div>').addClass('postContent'))
								.append($('<div>').attr('id', 'courseTime'))
									.append('<i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;&nbsp;' + dataVal + ' Uhr')
							   )
					);
					/**
					*	überprüfen ob Bild leer ist und Bildschirmbreite grösser als Tablet quer
					*
					*/
					if( response.url !== null && $(window).width() > 970 ){	
					// Falls true und Browser ist Desktop - Text und Bild mit col-6 				
						courseInfo.append(
							$('<div>').addClass('row well-bottom')
							.append($('<div>').addClass('col-xs-12 col-sm-6')
										.append($('<div>').addClass('postContent')
												.append($('<div>').attr('id', 'courseContent').text(response.post_content))
											   )			
								   )
							.append($('<div>').addClass('col-xs-12 col-sm-6')
										.append($('<div>').addClass('postContent')
												.append($('<div>').attr('id', 'courseImg').append(img))
											   )			
								   )
						);
					} else if( $(window).width() <= 970 ) {
					// Falls Browser  Mobile ist 
						if(response.url !== null){
							// Fals Bild vorhanden Bild und Text mit col-12
							courseInfo.append(
								$('<div>').addClass('row well-bottom')
								.append($('<div>').addClass('col-xs-12')
											.append($('<div>').addClass('postContent well-bottom')
													.append($('<div>').attr('id', 'courseImg').append(img))
												   )			
									   )
								.append($('<div>').addClass('col-xs-12')
											.append($('<div>').addClass('postContent')
													.append($('<div>').attr('id', 'courseContent').text(response.post_content))
												   )			
									   )
							);							
						} else {
							// Nur Text
							courseInfo.append(
								$('<div>').addClass('row well-bottom')
								.append($('<div>').addClass('col-xs-12')
											.append($('<div>').addClass('postContent well-bottom')
													.append($('<div>').attr('id', 'courseContent').text(response.post_content))
												   )			
									   )
							);		
						}
					} else {			
					// Falls nein - Text mit col-12	ohne Bild
						courseInfo.append(
							$('<div>').addClass('row well-bottom')
							.append($('<div>').addClass('col-xs-12 col-sm-12')
										.append($('<div>').addClass('postContent')
												.append($('<div>').attr('id', 'courseContent').text(response.post_content))
											   )			
								   )
						);
					}
					// Füllt das Formular mit den Daten vom Webmaster 
					// Infos von Wochenplaneinstellungen
					$( '#mailText' ).empty();
					$( '#mailText' ).val( response.mailText) ;
					 
					$( '#absenderName' ).empty();
					$( '#absenderName' ).val( response.absenderName );
					 
					$( '#absenderMail' ).empty();
					$( '#absenderMail' ).val( response.absenderMail );
					 
					$( '#kontakt-alert-success' ).empty();
					$( '#kontakt-alert-success' ).text( response.succesMail );
					 
					$( '#kontakt-alert-fail' ).empty();
					$( '#kontakt-alert-fail' ).text( response.failMail );
					 
					$( '#kursInfo' ).empty();
					$( '#kursInfo' ).val(title +' am ' + getDay + ' ' + getDate + ' um ' + dataVal); 	
					
				}
			  });
		}
});