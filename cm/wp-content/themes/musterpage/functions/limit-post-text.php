<?php 


	// Filter the excerpt
	function excerpt($limit) {
	  $excerpt = explode(' ', get_the_excerpt(), $limit);
	  if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	  } else {
		$excerpt = implode(" ",$excerpt);
	  }	
	  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	  return $excerpt;
	}
	 
	// Filter the content
	function content($limit) {
	  $content = explode(' ', get_the_content(), $limit);
	  if (count($content)>=$limit) {
		array_pop($content);
		$content = implode(" ",$content).'...';
	  } else {
		$content = implode(" ",$content);
	  }	
	  $content = preg_replace('/\[.+\]/','', $content);
	  $content = apply_filters('the_content', $content); 
	  $content = str_replace(']]>', ']]&gt;', $content);
	  return $content;
	}
	
	// Filter the title
	function title($limit) {
	  $title = explode(' ', get_the_title(), $limit);
	  if (count($title)>=$limit) {
		array_pop($title);
		$title = implode(" ",$title).'...';
	  } else {
		$title = implode(" ",$title);
	  }	
	  $title = preg_replace('/\[.+\]/','', $title);
	  $title = apply_filters('the_title', $title); 
	  $title = str_replace(']]>', ']]&gt;', $title);
	  return $title;
	}


?>