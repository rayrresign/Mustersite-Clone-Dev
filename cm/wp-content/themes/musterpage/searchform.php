
<div class="suche-form">

<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<input type="text" placeholder="Suche..." value="<?php echo get_search_query(); ?>" name="s" id="s" class="search-field form-control"/>
    </label>
	<input type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'suchen', 'submit button' ); ?>" class="search-submit btn btn-xs btn-default" />
</form>

</div>