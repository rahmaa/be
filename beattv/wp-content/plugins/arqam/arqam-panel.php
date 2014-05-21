<?php
/*-----------------------------------------------------------------------------------*/
# Register main Scripts and Styles
/*-----------------------------------------------------------------------------------*/
function arqam_admin_register() {

	if ( isset( $_GET['page'] ) && $_GET['page'] == 'arqam' ) {
		wp_enqueue_script( array('jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-sortable' ) );
	 ?>
<style type="text/css" media="all">
	.arq-content .links-table{ border-right:1px solid #CCC; padding-right: 15px; margin-right:15px; width: 65%; float:left;}
	.arq-content .links-table th{vertical-align: middle;}
	.js.toplevel_page_arqam .postbox .hndle{cursor: auto;}
	#arq-sortables li.arq-sort-item{list-style: decimal; list-style-position: inside !important;text-transform: capitalize;border: 1px solid #DDD; padding:5px; background:#FFF;cursor: move;-webkit-border-radius: 3px;border-radius: 3px; opacity:0.8;-webkit-transition: opacity ease-in-out 0.2s;  -moz-transition: opacity ease-in-out 0.2s;  -o-transition: opacity ease-in-out 0.2s;  transition: opacity ease-in-out 0.2s;}
	#arq-sortables li.arq-sort-item:hover{opacity:1;}
	#arq-sortables li.ui-state-highlight {background-color: #fffdea;border: 1px dashed #ffd38c;height: 30px;}
	.arq-content .links-table th {min-width: 145px;}
	body.rtl .arq-content .links-table{ border-left:1px solid #CCC;  border-right:0 none;  padding-right: 0; padding-left: 15px; margin-left:15px; margin-right:0;  float:right;}
	#tie_linkedin_group, #tie_linkedin_company{display:none;}
</style>
	<?php
	}
}
add_action( 'admin_enqueue_scripts', 'arqam_admin_register' ); 


/*-----------------------------------------------------------------------------------*/
# Add Panel Page
/*-----------------------------------------------------------------------------------*/
add_action('admin_menu', 'arqam_add_admin'); 
function arqam_add_admin() {
	global $arq_options;

	$current_page = isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';

	$icon = plugins_url('assets/images/general.png' , __FILE__);
	add_menu_page(ARQAM_Plugin.' Settings', ARQAM_Plugin ,'install_plugins', 'arqam' , 'arqam_options', $icon  );
	$theme_page = add_submenu_page('arqam',ARQAM_Plugin.' Settings', ARQAM_Plugin.' Settings','install_plugins', 'arqam' , 'arqam_options');

	if( isset( $_REQUEST['action'] ) ){
		if( 'save' == $_REQUEST['action']  && $current_page == 'arqam' ) {
			$arq_options['social'] = $_REQUEST['social'];
			$arq_options['sort'] = $_REQUEST['sort'];
			$arq_options['css'] = htmlspecialchars(stripslashes( $_REQUEST['css'] ) );
			$arq_options['cache'] = (int) $_REQUEST['cache'];
			$arq_options['data'] = '';
				
			update_option( 'arq_options' , $arq_options);
			delete_transient('arq_counters');
			delete_option('arqam_TwitterToken');
	
			header("Location: admin.php?page=arqam&saved=true");
			die;
		}elseif( 'linkedin' == $_REQUEST['action']  && $current_page == 'arqam' ){
			
			set_transient( 'linkedin_api_key', $_REQUEST['api_key'] , 60*60 );
			set_transient( 'linkedin_api_secret', $_REQUEST['api_secret'] , 60*60 );

			tie_linkedin_getAuthorizationCode( $_REQUEST['api_key'] );
		}
	}
}
	
/*-----------------------------------------------------------------------------------*/
# arqam Panel
/*-----------------------------------------------------------------------------------*/
function arqam_options() { 
	global $arq_options, $arq_social_items;
	$current_page = isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';

if( isset( $_REQUEST['service'] ) && 'arq-linkedin' == $_REQUEST['service'] && $current_page == 'arqam' ){
			
	if (isset($_GET['error'])) {
		print $_GET['error'] . ': ' . $_GET['error_description'];
	} elseif (isset($_GET['code'])) {
		if ( get_transient( 'linkedin_state' ) == $_GET['state']) {
			$api_key	= get_transient( 'linkedin_api_key' );
			$api_secret = get_transient( 'linkedin_api_secret' );

			tie_linkedin_getAccessToken($api_key , $api_secret);
		} else {
			echo 'ERROR';
		}
	} 
?>
<div class="wrap">	
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e( 'LinkedIn App info' , 'arq' ) ?></h2>
	<br />
	<form method="post">
		<div id="poststuff">
			<div id="post-body" class="columns-2">
				<div id="post-body-content" class="arq-content">
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'LinkedIn App info' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="api_key"><?php _e( 'API Key' , 'arq' ) ?></label></th>
										<td><input type="text" name="api_key" class="code" id="api_key" value=""></td>
									</tr>
									<tr>
										<th scope="row"><label for="api_secret"><?php _e( 'Secret Key' , 'arq' ) ?></label></th>
										<td><input type="text" name="api_secret" class="code" id="api_secret" value=""></td>
									</tr>
								</tbody>
							</table>
							<div>
								<strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your APP API Key and Secret Key ,' , 'arq' ) ?> <a href="http://plugins.tielabs.com/docs/arqam/#linkedin" target="_blank"><?php _e( 'Click Here' , 'arq' ) ?></a> <?php _e( 'For More Details.' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
				</div> <!-- Post Body COntent -->

							
				<div id="publishing-action">								
					<input type="hidden" name="action" value="linkedin" />
					<input name="save" type="submit" class="button-large button-primary" id="publish" value="<?php _e( 'Submit' , 'arq' ) ?>">
				</div>
				<div class="clear"></div>
				
			</div><!-- post-body /-->
				
		</div><!-- poststuff /-->
	</form>
</div>
<?php		
}else{
	
	if ( isset($_REQUEST['saved'])) echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>'. __( 'Settings saved.' , 'arq' ) .'</strong></p></div>'; ?>
<script type="text/javascript">	
	jQuery(function() {
		jQuery( "#arq-sortables" ).sortable({placeholder: "ui-state-highlight"});
	});
</script>
<div class="wrap">	
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e( 'Arqam Settings' , 'arq' ) ?></h2>
	<br />
	<form method="post">
		<div id="poststuff">
			<div id="post-body" class="columns-2">
				<div id="post-body-content" class="arq-content">
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'FaceBook' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[facebook][id]"><?php _e( 'Page ID/Name' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[facebook][id]" class="code" id="social[facebook][id]" value="<?php if( !empty($arq_options['social']['facebook']['id']) ) echo $arq_options['social']['facebook']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[facebook][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[facebook][text]" class="code" id="social[facebook][text]" value="<?php if( !empty($arq_options['social']['facebook']['text']) ) echo $arq_options['social']['facebook']['text'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<div>
								<strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Facebook Page Name or ID ,' , 'arq' ) ?> <a href="http://plugins.tielabs.com/docs/arqam/#facebook" target="_blank"><?php _e( 'Click Here' , 'arq' ) ?></a> <?php _e( 'For More Details.' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
						
								
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Twitter' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[twitter][id]"><?php _e( 'UserName' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[twitter][id]" class="code" id="social[twitter][id]" value="<?php if( !empty($arq_options['social']['twitter']['id']) ) echo $arq_options['social']['twitter']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[twitter][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[twitter][text]" class="code" id="social[twitter][text]" value="<?php if( !empty($arq_options['social']['twitter']['text']) ) echo $arq_options['social']['twitter']['text'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[twitter][key]"><?php _e( 'Consumer key' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[twitter][key]" class="code" id="social[twitter][key]" value="<?php if( !empty($arq_options['social']['twitter']['key']) ) echo $arq_options['social']['twitter']['key'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[twitter][secret]"><?php _e( 'Consumer secret' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[twitter][secret]" class="code" id="social[twitter][secret]" value="<?php if( !empty($arq_options['social']['twitter']['secret']) ) echo $arq_options['social']['twitter']['secret'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Twitter Account Username , your APP Consumer key and Consumer secret ,' , 'arq' ) ?> <a href="http://plugins.tielabs.com/docs/arqam/#twitter" target="_blank"><?php _e( 'Click Here' , 'arq' ) ?></a> <?php _e( 'For More Details.' , 'arq' ) ?></em></p>
							</div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
					
					
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Google+' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[google][id]"><?php _e( 'Page ID' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[google][id]" class="code" id="social[google][id]" value="<?php if( !empty($arq_options['social']['google']['id']) ) echo $arq_options['social']['google']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[google][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[google][text]" class="code" id="social[google][text]" value="<?php if( !empty($arq_options['social']['google']['text']) ) echo $arq_options['social']['google']['text'] ?>"></td>
									</tr>
								</tbody>
							</table>
								<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Google+ Page ID ,' , 'arq' ) ?> <a href="http://plugins.tielabs.com/docs/arqam/#google" target="_blank"><?php _e( 'Click Here' , 'arq' ) ?></a> <?php _e( 'For More Details.' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
										
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Youtube' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[youtube][id]"><?php _e( 'Username or Channel ID' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[youtube][id]" class="code" id="social[youtube][id]" value="<?php if( !empty($arq_options['social']['youtube']['id']) ) echo $arq_options['social']['youtube']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[youtube][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[youtube][text]" class="code" id="social[youtube][text]" value="<?php if( !empty($arq_options['social']['youtube']['text']) ) echo $arq_options['social']['youtube']['text'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[youtube][type]"><?php _e( 'Type' , 'arq' ) ?></label></th>
										<td>
											<select name="social[youtube][type]" id="social[youtube][type]">
											<?php
											$youtube_type = array('User', 'Channel');
											foreach ( $youtube_type as $type ){ ?>
												<option <?php if( !empty($arq_options['social']['youtube']['type']) && $arq_options['social']['youtube']['type'] == $type ) echo'selected="selected"' ?> value="<?php echo $type ?>"><?php echo $type ?></option>
											<?php } ?>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Youtube username or Channel ID and choose User or Channel from Type menu ,' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
						
															
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Vimeo' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[vimeo][id]"><?php _e( 'Channel Name' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[vimeo][id]" class="code" id="social[vimeo][id]" value="<?php if( !empty($arq_options['social']['vimeo']['id']) ) echo $arq_options['social']['vimeo']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[vimeo][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[vimeo][text]" class="code" id="social[vimeo][text]" value="<?php if( !empty($arq_options['social']['vimeo']['text']) ) echo $arq_options['social']['vimeo']['text'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Vimeo Channel Name ,' , 'arq' ) ?> </em></p></div>

							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->

					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Dribbble' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[dribbble][id]"><?php _e( 'UserName' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[dribbble][id]" class="code" id="social[dribbble][id]" value="<?php if( !empty($arq_options['social']['dribbble']['id']) ) echo $arq_options['social']['dribbble']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[dribbble][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[dribbble][text]" class="code" id="social[dribbble][text]" value="<?php if( !empty($arq_options['social']['dribbble']['text']) ) echo $arq_options['social']['dribbble']['text'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Dribbble Account Username .' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
					
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Github' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[github][id]"><?php _e( 'UserName' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[github][id]" class="code" id="social[github][id]" value="<?php if( !empty($arq_options['social']['github']['id']) ) echo $arq_options['social']['github']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[github][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[github][text]" class="code" id="social[github][text]" value="<?php if( !empty($arq_options['social']['github']['text']) ) echo $arq_options['social']['github']['text'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Github Account Username .' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
					
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Envato' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[envato][id]"><?php _e( 'UserName' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[envato][id]" class="code" id="social[envato][id]" value="<?php if( !empty($arq_options['social']['envato']['id']) ) echo $arq_options['social']['envato']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[envato][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[envato][text]" class="code" id="social[envato][text]" value="<?php if( !empty($arq_options['social']['envato']['text']) ) echo $arq_options['social']['envato']['text'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[envato][site]"><?php _e( 'Marketplace' , 'arq' ) ?></label></th>
										<td>
											<select name="social[envato][site]" id="social[envato][site]">
											<?php
											$envato_markets = array('3docean', 'activeden', 'audiojungle', 'codecanyon', 'graphicriver', 'photodune', 'themeforest', 'videohive');
											foreach ( $envato_markets as $market ){ ?>
												<option <?php if( !empty($arq_options['social']['envato']['site']) && $arq_options['social']['envato']['site'] == $market ) echo'selected="selected"' ?> value="<?php echo $market ?>"><?php echo $market ?></option>
											<?php } ?>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Envato Account Username .' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
										
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'SoundCloud' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[soundcloud][id]"><?php _e( 'UserName' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[soundcloud][id]" class="code" id="social[soundcloud][id]" value="<?php if( !empty($arq_options['social']['soundcloud']['id']) ) echo $arq_options['social']['soundcloud']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[soundcloud][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[soundcloud][text]" class="code" id="social[soundcloud][text]" value="<?php if( !empty($arq_options['social']['soundcloud']['text']) ) echo $arq_options['social']['soundcloud']['text'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[soundcloud][api]"><?php _e( 'API Key' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[soundcloud][api]" class="code" id="social[soundcloud][api]" value="<?php if( !empty($arq_options['social']['soundcloud']['api']) ) echo $arq_options['social']['soundcloud']['api'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your SoundCloud Account Username and the API Key,' , 'arq' ) ?> <a href="http://plugins.tielabs.com/docs/arqam/#soundcloud" target="_blank"><?php _e( 'Click Here' , 'arq' ) ?></a> <?php _e( 'For More Details.' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
						
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Behance' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[behance][id]"><?php _e( 'UserName' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[behance][id]" class="code" id="social[behance][id]" value="<?php if( !empty($arq_options['social']['behance']['id']) ) echo $arq_options['social']['behance']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[behance][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[behance][text]" class="code" id="social[behance][text]" value="<?php if( !empty($arq_options['social']['behance']['text']) ) echo $arq_options['social']['behance']['text'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[behance][api]"><?php _e( 'API Key' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[behance][api]" class="code" id="social[behance][api]" value="<?php if( !empty($arq_options['social']['behance']['api']) ) echo $arq_options['social']['behance']['api'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Behance Account Username and the API Key,' , 'arq' ) ?> <a href="http://plugins.tielabs.com/docs/arqam/#behance" target="_blank"><?php _e( 'Click Here' , 'arq' ) ?></a> <?php _e( 'For More Details.' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
					
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Forrst' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[forrst][id]"><?php _e( 'UserName' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[forrst][id]" class="code" id="social[forrst][id]" value="<?php if( !empty($arq_options['social']['forrst']['id']) ) echo $arq_options['social']['forrst']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[forrst][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[forrst][text]" class="code" id="social[forrst][text]" value="<?php if( !empty($arq_options['social']['forrst']['text']) ) echo $arq_options['social']['forrst']['text'] ?>"></td>
									</tr>

								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Forrst Account Username .' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
					
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Delicious' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[delicious][id]"><?php _e( 'UserName' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[delicious][id]" class="code" id="social[delicious][id]" value="<?php if( !empty($arq_options['social']['delicious']['id']) ) echo $arq_options['social']['delicious']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[delicious][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[delicious][text]" class="code" id="social[delicious][text]" value="<?php if( !empty($arq_options['social']['delicious']['text']) ) echo $arq_options['social']['delicious']['text'] ?>"></td>
									</tr>

								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Delicious Account Username .' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
									
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Instagram' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[instagram][id]"><?php _e( 'UserName' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[instagram][id]" class="code" id="social[instagram][id]" value="<?php if( !empty($arq_options['social']['instagram']['id']) ) echo $arq_options['social']['instagram']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[instagram][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[instagram][text]" class="code" id="social[instagram][text]" value="<?php if( !empty($arq_options['social']['instagram']['text']) ) echo $arq_options['social']['instagram']['text'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[instagram][api]"><?php _e( 'Access Token Key' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[instagram][api]" class="code" id="social[instagram][api]" value="<?php if( !empty($arq_options['social']['instagram']['api']) ) echo $arq_options['social']['instagram']['api'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Instagram Username and your Access Token,' , 'arq' ) ?> <a target="_blank" href="http://plugins.tielabs.com/arqam/instagram-tool" target="_blank"><?php _e( 'Click Here' , 'arq' ) ?></a> <?php _e( 'For How to get your Access Token.' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
					
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'MailChimp' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[mailchimp][id]"><?php _e( 'List ID' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[mailchimp][id]" class="code" id="social[mailchimp][id]" value="<?php if( !empty($arq_options['social']['mailchimp']['id']) ) echo $arq_options['social']['mailchimp']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[mailchimp][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[mailchimp][text]" class="code" id="social[mailchimp][text]" value="<?php if( !empty($arq_options['social']['mailchimp']['text']) ) echo $arq_options['social']['mailchimp']['text'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[mailchimp][url]"><?php _e( 'List URL' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[mailchimp][url]" class="code" id="social[mailchimp][url]" value="<?php if( !empty($arq_options['social']['mailchimp']['url']) ) echo $arq_options['social']['mailchimp']['url'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[mailchimp][api]"><?php _e( 'API Key' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[mailchimp][api]" class="code" id="social[mailchimp][api]" value="<?php if( !empty($arq_options['social']['mailchimp']['api']) ) echo $arq_options['social']['mailchimp']['api'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your' , 'arq' ) ?> <a target="_blank" href="http://kb.mailchimp.com/article/how-can-i-find-my-list-id" target="_blank"><?php _e( 'List ID' , 'arq' ) ?></a> , <a target="_blank" href="http://kb.mailchimp.com/article/how-do-i-share-my-signup-form" target="_blank"><?php _e( 'List URL' , 'arq' ) ?></a> <?php _e( 'and' , 'arq' ) ?> <a target="_blank" href="http://kb.mailchimp.com/article/where-can-i-find-my-api-key" target="_blank"><?php _e( 'API Key' , 'arq' ) ?></a></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
					
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Foursquare' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[foursquare][id]"><?php _e( 'UserName' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[foursquare][id]" class="code" id="social[foursquare][id]" value="<?php if( !empty($arq_options['social']['foursquare']['id']) ) echo $arq_options['social']['foursquare']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[foursquare][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[foursquare][text]" class="code" id="social[foursquare][text]" value="<?php if( !empty($arq_options['social']['foursquare']['text']) ) echo $arq_options['social']['foursquare']['text'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[foursquare][api]"><?php _e( 'Access Token Key' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[foursquare][api]" class="code" id="social[foursquare][api]" value="<?php if( !empty($arq_options['social']['foursquare']['api']) ) echo $arq_options['social']['foursquare']['api'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your Foursquare Username and your Access Token,' , 'arq' ) ?> <a target="_blank" href="http://plugins.tielabs.com/arqam/foursquare-tool" target="_blank"><?php _e( 'Click Here' , 'arq' ) ?></a> <?php _e( 'For How to get your Access Token.' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
									
					<div class="postbox" id="linkedin">
						<h3 class="hndle"><span><?php _e( 'LinkedIn' , 'arq' ) ?></span></h3>
						<div class="inside">
						<script>
						jQuery(document).ready(function() {
							var selected_item = jQuery("select[name='social[linkedin][type]'] option:selected").val();
							
							if (selected_item == 'Company') {jQuery('#tie_linkedin_company').show();}
							if (selected_item == 'Group') {jQuery('#tie_linkedin_group').show();}

							jQuery("select[name='social[linkedin][type]']").change(function(){
								var selected_item = jQuery("select[name='social[linkedin][type]'] option:selected").val();
								if (selected_item == 'Company') {
									jQuery( '#tie_linkedin_group' ).hide();
									jQuery( '#tie_linkedin_company' ).fadeIn();
								}
								if (selected_item == 'Group') {
									jQuery( '#tie_linkedin_company' ).hide();
									jQuery( '#tie_linkedin_group' ).fadeIn();
								}
							 });
						});</script>
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[linkedin][type]"><?php _e( 'Type' , 'arq' ) ?></label></th>
										<td>
											<select name="social[linkedin][type]" id="social[linkedin][type]">
											<?php
											$linkedin_type = array('Company', 'Group');
											foreach ( $linkedin_type as $type ){ ?>
												<option <?php if( !empty($arq_options['social']['linkedin']['type']) && $arq_options['social']['linkedin']['type'] == $type ) echo'selected="selected"' ?> value="<?php echo $type ?>"><?php echo $type ?></option>
											<?php } ?>
											</select>
										</td>
									</tr>
									<tr id="tie_linkedin_company">
										<th scope="row"><label for="social[linkedin][id]"><?php _e( 'Company ID' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[linkedin][id]" class="code" id="social[linkedin][id]" value="<?php if( !empty($arq_options['social']['linkedin']['id']) ) echo $arq_options['social']['linkedin']['id'] ?>"></td>
									</tr>
									<tr id="tie_linkedin_group">
										<th scope="row"><label for="social[linkedin][group]"><?php _e( 'Group Slug' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[linkedin][group]" class="code" id="social[linkedin][group]" value="<?php if( !empty($arq_options['social']['linkedin']['group']) ) echo $arq_options['social']['linkedin']['group'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[linkedin][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[linkedin][text]" class="code" id="social[linkedin][text]" value="<?php if( !empty($arq_options['social']['linkedin']['text']) ) echo $arq_options['social']['linkedin']['text'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[linkedin][api]"><?php _e( 'Access Token Key' , 'arq' ) ?></label></th>
										<td>
											<input type="text" style="color: #999; width:218px" name="social[linkedin][api]" disabled="disabled" class="code" id="social[linkedin][api]" value="<?php if( get_option( 'linkedin_access_token' ) ) echo get_option( 'linkedin_access_token' ) ?>">
											<a href="<?php echo admin_url().'admin.php?page=arqam&service=arq-linkedin' ?>"><strong><?php _e( 'Get Access Token' , 'arq' ) ?></strong></a>
										</td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your LinkedIn Company ID or Group Slug click on Get Access Token link to get your app Access Token,' , 'arq' ) ?> <a href="http://plugins.tielabs.com/docs/arqam/#linkedin" target="_blank"><?php _e( 'Click Here' , 'arq' ) ?></a> <?php _e( 'For More Details.' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
					
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'VK' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" cellpadding="0">
								<tbody>
									<tr>
										<th scope="row"><label for="social[vk][id]"><?php _e( 'Community ID/Name' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[vk][id]" class="code" id="social[vk][id]" value="<?php if( !empty($arq_options['social']['vk']['id']) ) echo $arq_options['social']['vk']['id'] ?>"></td>
									</tr>
									<tr>
										<th scope="row"><label for="social[vk][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[vk][text]" class="code" id="social[vk][text]" value="<?php if( !empty($arq_options['social']['vk']['text']) ) echo $arq_options['social']['vk']['text'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<div><strong><?php _e( 'Need Help?' , 'arq' ) ?></strong><p><em><?php _e( 'Enter Your VK Community Name/ID .' , 'arq' ) ?></em></p></div>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
										
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Posts and Comments' , 'arq' ) ?></span></h3>
						<div class="inside">
							<table class="links-table" style="float:none; width:auto; border:0 none; padding:0; margin:0;" cellpadding="0">
								<tbody>
									<tr>
										<th style="min-width: 180px;" scope="row"><label for="social[posts][active]"><?php _e( 'Enable Posts Counter ?' , 'arq' ) ?></label></th>
										<td style="width: 80px;"><input type="checkbox" name="social[posts][active]" class="code" id="social[posts][active]" value="" <?php if( isset($arq_options['social']['posts']['active']) ) echo ' checked="checked"' ?>></td>
										
										<th scope="row"><label for="social[posts][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[posts][text]" class="code" id="social[posts][text]" value="<?php if( !empty($arq_options['social']['posts']['text']) ) echo $arq_options['social']['posts']['text'] ?>"></td>
									</tr>
									<tr>
										<th style="min-width: 180px;" scope="row"><label for="social[comments][active]"><?php _e( 'Enable Comments Counter ?' , 'arq' ) ?></label></th>
										<td style="width: 80px;"><input type="checkbox" name="social[comments][active]" class="code" id="social[comments][active]" value="" <?php if( isset($arq_options['social']['comments']['active']) ) echo ' checked="checked"'?>></td>
										
										<th scope="row"><label for="social[comments][text]"><?php _e( 'Text Below The Number' , 'arq' ) ?></label></th>
										<td><input type="text" name="social[comments][text]" class="code" id="social[comments][text]" value="<?php if( !empty($arq_options['social']['comments']['text']) ) echo $arq_options['social']['comments']['text'] ?>"></td>
									</tr>


								</tbody>
							</table>
							<div class="clear"></div>
						</div>
					</div> <!-- Box end /-->
					
				</div> <!-- Post Body COntent -->

							
				<div id="postbox-container-1" class="postbox-container">
				
						<div class="inside" style="background-color: #ffffe0; border:1px solid #e6db55; padding:10px; margin-bottom:15px;">
							<strong><?php _e( 'Need Help?' , 'arq' ) ?></strong>
							<ul>
								<li><a href="http://plugins.tielabs.com/docs/arqam/" target="_blank"><?php _e( 'Plugin Docs' , 'arq' ) ?></a></li>
								<li><a href="http://codecanyon.net/item/arqam-retina-responsive-wp-social-counter-plugin/discussion/5085289" target="_blank"><?php _e( 'Support' , 'arq' ) ?></a></li>
								<li><a href="http://codecanyon.net/downloads" target="_blank"><?php _e( 'Rate Arqam' , 'arq' ) ?></a></li>
							</ul>
							<div class="clear"></div>
						</div>

					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Drag and Drop To Sort The Items' , 'arq' ) ?></span></h3>
						<div class="inside">
							<ul id="arq-sortables">
								<?php
									if( !empty( $arq_options['sort'] ) )
										$arq_sort_items = $arq_options['sort'];
										
									if( empty( $arq_options['sort'] ) || !is_array($arq_sort_items) || $arq_social_items != array_intersect($arq_social_items , $arq_sort_items ) ){
										$arq_sort_items = $arq_social_items ;
									}
									foreach ( $arq_sort_items as $arq_item ){ ?>
										<li class="arq-sort-item"><strong><?php echo $arq_item; ?></strong><input type="hidden" name="sort[]" class="code" id="social[]" value="<?php echo $arq_item; ?>"></li>
								<?php } ?>
							</ul>
							<div class="clear"></div>
						</div>
					</div>

					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'Custom CSS' , 'arq' ) ?></span></h3>
						<div class="inside">
							<p>
								<textarea name="css" rows="10" cols="50" id="css" class="large-text code"><?php if( !empty( $arq_options['css'] ) ) echo htmlspecialchars_decode( $arq_options['css'] ); ?></textarea>
							</p>
						</div>
					</div>
					
					
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( 'General Settings' , 'arq' ) ?></span></h3>
						<div class="inside">
							<p>
								<label for="cache"><?php _e( 'Cache Time' , 'arq' ) ?></label>
								<select name="cache" id="cache">
									<?php
									for ( $i = 1; $i <= 24 ; $i++ ){ ?>
									<option <?php if( !empty($arq_options['cache']) && $arq_options['cache'] == $i ) echo'selected="selected"' ?> value="<?php echo $i ?>"><?php echo $i ?> <?php _e( 'hours' , 'arq' ) ?> </option>
									<?php } ?>
								</select>
							</p>
							
							<div id="publishing-action">								
								<input type="hidden" name="action" value="save" />
								<input name="save" type="submit" class="button-large button-primary" id="publish" value="<?php _e( 'Save' , 'arq' ) ?>">
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div><!-- postbox-container /-->
			</div><!-- post-body /-->
				
		</div><!-- poststuff /-->
	</form>
</div>	

<?php
	}
}

//Get LinkedIn Authorization Code
function tie_linkedin_getAuthorizationCode( $api_key ) {
	$params = array('response_type' => 'code',
					'client_id' => $api_key,
					'scope' => 'r_fullprofile rw_groups',
					'state' => uniqid('', true), // unique long string
					'redirect_uri' => admin_url().'admin.php?page=arqam&service=arq-linkedin',
			);
			 
	$url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
				 
	set_transient( 'linkedin_state', $params['state'] , 60*60 );
			 
	header("Location: $url");
	exit;
}

//Get LinkedIn Access Token
function tie_linkedin_getAccessToken($api_key , $api_secret) {
	$params = array('grant_type' => 'authorization_code',
					'client_id' => $api_key,
					'client_secret' => $api_secret,
					'code' => $_GET['code'],
					'redirect_uri' => admin_url().'admin.php?page=arqam&service=arq-linkedin',
			);
				 
	$url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
	$token = arq_remote_get( $url, true );

	// Store access token and expiration time
	set_transient( 'linkedin_expires_in', $token['expires_in'] , 60*60 );
	set_transient( 'linkedin_expires_at',  time() + $token['expires_in'] , 60*60 );
	update_option( 'linkedin_access_token' , $token['access_token']);

	echo "<script type='text/javascript'>window.location='".admin_url()."admin.php?page=arqam#linkedin';</script>";
	exit;
}
?>