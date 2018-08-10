<?php 

// Breadcrumb Funktion 
function breadcrumbz($post){
	if($post != null){
		$title = get_the_title($post); // get title
		$current_url = get_permalink(); // get link		
		if(!is_singular(array('post','page') ) ){ 
			// CUSTOM POST TYPES			
			// Last Page
			if(isset($_SERVER['HTTP_REFERER'])){
				if(strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])){
					$last_visited_url = $_SERVER['HTTP_REFERER'];
				}
				$url_parts = explode('/', parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
				$path = $url_parts[count($url_parts)-2];
				if(get_page_by_path('/'.$path)){
					$post_type_label = get_page_by_path('/'.$path)->post_title;	
					echo '<div class="breadcrumb"><a href="'.$last_visited_url.'">'.$post_type_label.'</a> | <a href="'.$current_url.'">'. $title.'</a></div>';
				}else{
					echo '<div class="breadcrumb"> | <a href="'.$current_url.'">'. $title.'</a></div>';
				}
			}else{
				echo '<div class="breadcrumb"> | <a href="'.$current_url.'">'. $title.'</a></div>';
			}				
		}else{
			if(is_singular(array('post'))){
				// Post
				$post_type_label = get_the_category($post)[0]->name;
				$last_visited_url = get_category_link(get_the_category($post)[0]->term_id);				
				echo '<div class="breadcrumb"><a href="'.$last_visited_url.'">'.$post_type_label.'</a> | <a href="'.$current_url.'">'. $title.'</a></div>';
			}else{
				echo '<div class="breadcrumb"> | <a href="'.$current_url.'">'. $title.'</a></div>';
			}			
		}
	}	
}	

?>
