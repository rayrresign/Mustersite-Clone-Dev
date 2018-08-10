=== Resign Gallery-Slider ===
Contributors: Phillip Schmanau
Tags: carousel slider, bootstrap
Requires at least: 2.7
Tested up to: 4.1
Stable tag: 1.1

== Description ==

Dieses Plugin generiert ein verwaltbares Bootstrap 3.0 -Carousel mithilfe der Wordpress-Mediathek. 

== Installation ==

1. Lade den Ordner gallery-slider` in das Verzeichnis `/wp-content/plugins/`
2. Aktiviere das Plugin durch das 'Plugins' Menu im Admin-Panel
3. Die Funktion resign_gallery_slider($columns, $mode, $interval, $width ) an gewünschter Position im Template einfügen.
4. Damit der Slider nicht aus dem Viewport läuft, die Funktion in ein DIV mit der Klasse 'container-fluid' einbetten.

== Funktionsbeschreibung ==

$columns = Spalten gemäss Bootstrap-Grid (z.B. 1, 2, 3, 4, 6 -> default: 3)
$mode = Transition-Modus ('fade' -> default: '' = slide)
$interval = Interval der Transition im Milisekunden (default: 5000)
$width = Breite des Sliders ('full' = Fullscreen)

== Upgrade Notice ==

= 1.1 = 21.01.2015
Mobile-Implementierung mit der WP-Funktion wp_is_mobile(). 
Unabhängig von den Anzahl Columns wird die Ansicht in der Mobile-Ansicht auf eine Spalte reduziert.
Bei Tablets sind automatisch zwei Spalten ersichtlich
