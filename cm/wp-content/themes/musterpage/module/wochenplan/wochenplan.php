<?php

// Ausgabe für Wochenplan Desktop und Mobi

?>
<div class="container">
	<h2 class="text-center">Wochenplan</h2>
	<div class="wplan-table-desktop hidden-xs" id="wplan_desktop">
		<?php
		 echo show_wplan_desktop($weekdays_arr, calculate_times_from_wplan_settings(), $currentWeek , $currentYear);	
		?>
	</div>
	<div class="wplan-table-mobile hidden-sm hidden-md hidden-lg" id="wplan_mobile">
		<?php
		 echo show_wplan_mobile($weekdays_arr, calculate_times_from_wplan_settings(), $currentWeek , $currentYear);	 
		?>
	</div>

<!-- Modal Box Overlayer -->
    <div class="modal fade" id="terminModalBox" tabindex="-1" role="dialog" aria-hidden="true">
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
			<?php 
				require_once __WOCHENPLAN__ . '/anmelden/wplan_anmeldenform.php'; 
			  ?>
			</div>
        </div>
      </div>
    </div>

</div>