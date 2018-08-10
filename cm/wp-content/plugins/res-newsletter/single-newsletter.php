<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="de-DE">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Nl</title>
<meta name="viewport" content="width=600">

<style type="text/css">

	#outlook a {padding:0;} 
	body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; font-family: arial, sans-serif;}
	body{
		font-family: arial, sans-serif;
		background-repeat: repeat;
		background-position: center top;
		color: #666;
		background-color: #eee;
		padding: 0px;
		font-weight: normal;
		font-size: 80%;
	}

	a:link, a:active, a:visited{line-height: 140%;color: #999;text-decoration: none;}
	a:hover{color: #000;text-decoration: none;}
	
	.unsubscribeLink {font-size: 9px !important; letter-spacing: 1px; text-transform:uppercase; }
	
	/* Container Box 590px  */
	.container{width: 590px;border: none;margin-top: 20px;text-align: left; background-color: white;}
	
	.head{width: 100%;border: none;margin-bottom: 10px;}
	.footer{width: 100%;border: none;height: 50px;}
	.content{width: 100%;border: none;}
	
	.spaceLeft{width: 30px;}
	.spaceRight{width: 30px;}
	.center{width: 530px;}
	.postSpaceTop{font-size: 2px;}
	
	.postSpaceTopLine{font-size: 14px; border-top: 1px solid #cccccc;}
	.postSpaceDown{font-size: 5px;}
	.postSpaceDownLine{font-size: 1px; border-top: 1px solid #cccccc;}
	
	.postSpalteImg{width: 150px; vertical-align: top;}
	.postSpalteTxt{width: 380px;}
	
	.postBox {overflow: hidden;width: 530px;}
	.postImg{border: 0px solid #dedede;overflow: hidden;}	
	
	.postTitle{font-size: 22px;line-height: 120%;font-weight: 300;}
	
	.postTxt{font-size: 14px;line-height: 170%;margin-bottom: 10px;}
	.postTxtLink a{font-size: 16px; color: #000; font-weight: bold;}

	</style>


</head>

<?php
$url = "http://".$_SERVER['HTTP_HOST'];     //   Images NL-Links mit  /cm/wp-content/...
$url2 = $_SERVER['REQUEST_URI'];
$url3 = strstr($url2, 'wp-content', true);    
?>

<body>
<table width="100%"><tr><td align="center">

<!-- container 590 -->
<table class="container" cellspacing="0" cellpadding="0">
	<tr>
		<td class="hgColor">
		<table class="head" cellspacing="0" cellpadding="0">
			<tr>
				<td><img src="<?= $url ?>/nl/head.png" width="590" height="93" /></td>
			</tr>
		</table>

		<table class="content" cellspacing="0" cellpadding="0">
			<tr>
				<td class="spaceLeft">&nbsp;</td>
				<td class="center">

				<?php 
				global $_wp_additional_image_sizes;
					query_posts(array( 
						'post_type' => 'newsletter-entry',
						'order'     => 'ASC',
						'meta_key' => 'order',
						'orderby'   => 'meta_value',
						'meta_query' => array(
							array(
								'key' => 'newsletter_id',
								'value' => get_the_ID(),
								'compare' => 'LIKE'
						)
					)
				));
				
						 
				while (have_posts()) : the_post(); 
				//$imgBig = -1;
				$newsletter_entry_bild = get_post_meta(get_the_ID(), 'newsletter_entry_bild', true);
				$imgBig =  get_post_meta(get_the_ID(), 'newsletter_entry_bild_imgBig', true);
						 
				if(!empty($newsletter_entry_bild)){
//					$matches = array();
//					
//					preg_match("/([0-9]+)x([0-9]+).[a-zA-Z]+$/", $newsletter_entry_bild, $matches);
//										
//					//$imgBig = strcmp($_wp_additional_image_sizes['res-newsletter-big']['width'], $matches[1]);
//					$imgBig = strcmp($_wp_additional_image_sizes['res-newsletter-big']['width'], $matches[1]);
			
					global $wpdb;
					$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $newsletter_entry_bild )); 
					$img = wp_get_attachment_metadata($attachment[0]);	
					
					$upload_dir = wp_upload_dir();
					$baseurl = $upload_dir['baseurl'];
					
					if($imgBig == 1){
						$newsletter_entry_bild = $baseurl .'/'. $img['sizes']['res-newsletter-big']['file'];
					}else{
						$newsletter_entry_bild = $baseurl .'/'. $img['sizes']['res-newsletter-small']['file'];
					}
				}
						 
						 
						
				?>
                  <table class="postBox" cellpadding="0" cellspacing="0">
                    <!-- Post-Eintrag Start -->
							<tr>
								<td class="postSpaceTop" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td class="postSpaceTopLine" colspan="2">&nbsp;</td>
							</tr>
							<tr>
							<?php if($imgBig == 0 ){ ?>
								<td class="postSpalteImg"  rowspan="8">
									<img class="postImg" src="<?= $newsletter_entry_bild; ?>" width="" height="" />
				        		</td>
				        	<?php } ?>
								<td class="postTitle"><? the_title(); ?></td>
							</tr>
							<tr>
								<td class="postTxt"><p><?= get_post_meta(get_the_ID(), 'newsletter_entry_text', true); ?></p></td>
							</tr>
							
	                        <tr>
								<td class="postTxtLink"><a href="<?= get_post_meta(get_the_ID(), 'newsletter_entry_link', true); ?>"><?= get_post_meta(get_the_ID(), 'newsletter_entry_link_text', true); ?></a></td>
							</tr>                   
							
							<?php if($imgBig == 1){ ?>
							<tr>
								<td colspan="2" class="postSpaceDown">
									<img class="postImg"  src="<?= $newsletter_entry_bild; ?>" width="" height=""/>						
									<p>&nbsp;</p>
								</td>
							</tr>
							<?php } ?>
							
							<tr>
								<td colspan="2" class="postSpaceDown">&nbsp;</td>
					  		</tr>
					</table>
				<?php 
				endwhile;
				
				wp_reset_query();
				?>
				
				</td>
				<td class="spaceRight">&nbsp;</td>
			</tr>
		</table><!-- CONTENT-Tabelle ende -->
        
		<!-- FOOTER -->
		<table class="footer" cellspacing="0" cellpadding="0">
			<tr>
				<td><img src="<?= $url ?>/nl/footer.png" width="590" height="93" border="0" /></td>
			</tr>
		</table>
		<!-- FOOTER ende -->
        
		</td>
	</tr>
</table>
<!-- MASTER-Tabelle ende -->

</td></tr></table>


            <table align="center">
                <tr>
                    <td>
                    	<p>&nbsp;</p>
                        <a class="unsubscribeLink" href="[UnsubscribeLink]">Newsletter abmelden</a>
                        <p>&nbsp;</p>
                    </td>
                </tr>
            </table>



</body>

</html>