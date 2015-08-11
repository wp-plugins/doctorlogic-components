<?php // create custom plugin settings menu
add_action('admin_menu', 'dl_create_menu');

function dl_create_menu(){
	add_menu_page('DoctorLogic Plugin Settings', 'DoctorLogic', 'manage_options', __FILE__, 'dl_settings_page', plugins_url('../img/icon.png', __FILE__));
	add_submenu_page( __FILE__, 'DoctorLogic Plugin Settings', 'General', 'manage_options', __FILE__, 'dl_settings_page' );
	add_submenu_page( __FILE__, 'Advanced Styles', 'Advanced Styles', 'manage_options', 'dl__advancedstyles', 'dl__advancedstyles' );
	add_submenu_page( __FILE__, 'Shortcodes', 'Shortcodes', 'edit_pages', 'dl__shortcodes', 'dl__shortcodes' );
	add_submenu_page( __FILE__, 'Diagnostics', 'Diagnostics', 'edit_pages', 'dl__diagnostics', 'dl__diagnostics' );
	add_action('admin_init', 'register_dl_settings');
}

function register_dl_settings()	{
	register_setting('dl-settings-group', 'dl_site_key');
	register_setting('dl-settings-group', 'dl_review_path');
	register_setting('dl-settings-group', 'dl_gallery_path');
    register_setting('dl-settings-group', 'dl_environment');
	register_setting('dl-settings-group', 'dl_api');
    register_setting('dl-css-group', 'dl_css');
}



	function snapshot_data() {

		// call WP database
		global $wpdb;


		// do WP version check and get data accordingly
		$theme_data = wp_get_theme();
		$theme      = $theme_data->Name . ' ' . $theme_data->Version;

		// data checks for later
		$frontpage	= get_option( 'page_on_front' );
		$frontpost	= get_option( 'page_for_posts' );
		$mu_plugins = get_mu_plugins();
		$plugins	= get_plugins();
		$active		= get_option( 'active_plugins', array() );

		// multisite details
		$nt_plugins	= is_multisite() ? wp_get_active_network_plugins() : array();
		$nt_active	= is_multisite() ? get_site_option( 'active_sitewide_plugins', array() ) : array();
		$ms_sites	= is_multisite() ? get_blog_list() : null;

		// yes / no specifics
		$ismulti	= is_multisite() ? __( 'Yes', 'system-snapshot-report' ) : __( 'No', 'system-snapshot-report' );
		$safemode	= ini_get( 'safe_mode' ) ? __( 'Yes', 'system-snapshot-report' ) : __( 'No', 'system-snapshot-report' );
		$wpdebug	= defined( 'WP_DEBUG' ) ? WP_DEBUG ? __( 'Enabled', 'system-snapshot-report' ) : __( 'Disabled', 'system-snapshot-report' ) : __( 'Not Set', 'system-snapshot-report' );
		$tbprefx	= strlen( $wpdb->prefix ) < 16 ? __( 'Acceptable', 'system-snapshot-report' ) : __( 'Too Long', 'system-snapshot-report' );
		$fr_page	= $frontpage ? get_the_title( $frontpage ).' (ID# '.$frontpage.')'.'' : __( 'n/a', 'system-snapshot-report' );
		$fr_post	= $frontpage ? get_the_title( $frontpost ).' (ID# '.$frontpost.')'.'' : __( 'n/a', 'system-snapshot-report' );
		$errdisp	= ini_get( 'display_errors' ) != false ? __( 'On', 'system-snapshot-report' ) : __( 'Off', 'system-snapshot-report' );

		$jquchk		= wp_script_is( 'jquery', 'registered' ) ? $GLOBALS['wp_scripts']->registered['jquery']->ver : __( 'n/a', 'system-snapshot-report' );

		$sessenb	= isset( $_SESSION ) ? __( 'Enabled', 'system-snapshot-report' ) : __( 'Disabled', 'system-snapshot-report' );
		$usecck		= ini_get( 'session.use_cookies' ) ? __( 'On', 'system-snapshot-report' ) : __( 'Off', 'system-snapshot-report' );
		$useocck	= ini_get( 'session.use_only_cookies' ) ? __( 'On', 'system-snapshot-report' ) : __( 'Off', 'system-snapshot-report' );
		$hasfsock	= function_exists( 'fsockopen' ) ? __( 'Your server supports fsockopen.', 'system-snapshot-report' ) : __( 'Your server does not support fsockopen.', 'system-snapshot-report' );
		$hascurl	= function_exists( 'curl_init' ) ? __( 'Your server supports cURL.', 'system-snapshot-report' ) : __( 'Your server does not support cURL.', 'system-snapshot-report' );
		$hassoap	= class_exists( 'SoapClient' ) ? __( 'Your server has the SOAP Client enabled.', 'system-snapshot-report' ) : __( 'Your server does not have the SOAP Client enabled.', 'system-snapshot-report' );
		$hassuho	= extension_loaded( 'suhosin' ) ? __( 'Your server has SUHOSIN installed.', 'system-snapshot-report' ) : __( 'Your server does not have SUHOSIN installed.', 'system-snapshot-report' );
		$openssl	= extension_loaded('openssl') ? __( 'Your server has OpenSSL installed.', 'system-snapshot-report' ) : __( 'Your server does not have OpenSSL installed.', 'system-snapshot-report' );

		// start generating report
		$report	= '';
		$report	.= '<pre>';
		$report	.= '### Begin System Info ###'."\n";
		// add filter for adding to report opening
		$report	.= apply_filters( 'snapshot_report_before', '' );

		$report	.= "\n\t".'** WORDPRESS DATA **'."\n";
		$report	.= 'Multisite:'."\t\t\t\t".$ismulti."\n";
		$report	.= 'SITE_URL:'."\t\t\t\t".site_url()."\n";
		$report	.= 'HOME_URL:'."\t\t\t\t".home_url()."\n";
		$report	.= 'WP Version:'."\t\t\t\t".get_bloginfo( 'version' )."\n";
		$report	.= 'Permalink:'."\t\t\t\t".get_option( 'permalink_structure' )."\n";
		$report	.= 'Cur Theme:'."\t\t\t\t".$theme."\n";
		$report	.= 'Post Types:'."\t\t\t\t".implode( ', ', get_post_types( '', 'names' ) )."\n";
		$report	.= 'Post Stati:'."\t\t\t\t".implode( ', ', get_post_stati() )."\n";
		$report	.= 'User Count:'."\t\t\t\t".count( get_users() )."\n";

		$report	.= "\n\t".'** WORDPRESS CONFIG **'."\n";
		$report	.= 'WP_DEBUG:'."\t\t\t\t".$wpdebug."\n";
		$report	.= 'Table Prefix:'."\t\t\t\t".$wpdb->base_prefix."\n";
		$report	.= 'Prefix Length:'."\t\t\t\t".$tbprefx.' ('.strlen( $wpdb->prefix ).' characters)'."\n";
		$report	.= 'Show On Front:'."\t\t\t\t".get_option( 'show_on_front' )."\n";
		$report	.= 'Page On Front:'."\t\t\t\t".$fr_page."\n";
		$report	.= 'Page For Posts:'."\t\t\t\t".$fr_post."\n";

		if ( is_multisite() ) :
			$report	.= "\n\t".'** MULTISITE INFORMATION **'."\n";
			$report	.= 'Total Sites:'."\t\t\t\t".get_blog_count()."\n";
			$report	.= 'Base Site:'."\t\t\t\t".$ms_sites[0]['domain']."\n";
			$report	.= 'All Sites:'."\n";
			foreach ( $ms_sites as $site ) :
				if ( $site['path'] != '/' )
					$report	.= "\t\t".'- '. $site['domain'].$site['path']."\n";

			endforeach;
			$report	.= "\n";
		endif;

		$report	.= "\n\t".'** SERVER DATA **'."\n";
		$report	.= 'jQuery Version'."\t\t\t\t".$jquchk."\n";
		$report	.= 'PHP Version:'."\t\t\t\t".PHP_VERSION."\n";
		$report	.= 'MySQL Version:'."\t\t\t\t".mysql_get_server_info()."\n";
		$report	.= 'Server Software:'."\t\t\t".$_SERVER['SERVER_SOFTWARE']."\n";

		$report	.= "\n\t".'** PHP CONFIGURATION **'."\n";
		$report	.= 'Safe Mode:'."\t\t\t\t".$safemode."\n";
		$report	.= 'Memory Limit:'."\t\t\t\t".ini_get( 'memory_limit' )."\n";
		$report	.= 'Upload Max:'."\t\t\t\t".ini_get( 'upload_max_filesize' )."\n";
		$report	.= 'Post Max:'."\t\t\t\t".ini_get( 'post_max_size' )."\n";
		$report	.= 'Time Limit:'."\t\t\t\t".ini_get( 'max_execution_time' )."\n";
		$report	.= 'Max Input Vars:'."\t\t\t\t".ini_get( 'max_input_vars' )."\n";
		$report	.= 'Display Errors:'."\t\t\t\t".$errdisp."\n";
		$report	.= 'Sessions:'."\t\t\t\t".$sessenb."\n";
		$report	.= 'Session Name:'."\t\t\t\t".esc_html( ini_get( 'session.name' ) )."\n";
		$report	.= 'Cookie Path:'."\t\t\t\t".esc_html( ini_get( 'session.cookie_path' ) )."\n";
		$report	.= 'Save Path:'."\t\t\t\t".esc_html( ini_get( 'session.save_path' ) )."\n";
		$report	.= 'Use Cookies:'."\t\t\t\t".$usecck."\n";
		$report	.= 'Use Only Cookies:'."\t\t\t".$useocck."\n";
		$report	.= 'FSOCKOPEN:'."\t\t\t\t".$hasfsock."\n";
		$report	.= 'cURL:'."\t\t\t\t\t".$hascurl."\n";
		$report	.= 'SOAP Client:'."\t\t\t\t".$hassoap."\n";
		$report	.= 'SUHOSIN:'."\t\t\t\t".$hassuho."\n";
		$report	.= 'OpenSSL:'."\t\t\t\t".$openssl."\n";
		$report	.= "\n".'### End System Info ###';
		$report	.= '</pre>';

		return $report;
	}


function dl_settings_page(){

?>
    <div class="wrap" style="max-width: 1024px; background-color:#ffffff; padding:10px;" >
		<header style="background-color:#0083ac; color:#ffffff; font-size: 14px; font-weight: bold; padding:5px; vertical-align:middle">
			<img style="max-width: 180px;   vertical-align: middle;border: 0;"src="//assets.doctorlogicsites.com/Images/Sites/D/DoctorLogic/WordPress/logo_white.png" alt="DoctorLogic" />
			<div style="vertical-align: middle; text-align: right;"><a href="//doctorlogic.com/wordpress" style="color:#ffffff; "></a></div>
			<style type="text/css">
				th{font-weight:bold !important;}
			</style>
		</header>
        <main style="margin:10px;">
			<h2>DoctorLogic Components</h2>
			<?php echo get_option( 'plugin_error' );
			if (isset($_GET['settings-updated'])){ ?>
				<div class="updated">
					<p><strong><?php _e('Settings saved.') ?></strong></p>
				</div>
			 <?php
			 }
			 ?>
			<p>It's very easy to set up and use DoctorLogic Components!  But if you have any trouble at all, contact us at <a href="mailto:pluginsupport@doctorlogic.com">pluginsupport@doctorlogic.com</a>.</p>
			<p>DoctorLogic Components is a native WordPress plugin with two components and a variety of ways to use them.  The customer who owns this website may have licensed one or both components.</p>
			<ul>
				<li><b>Review Component</b>:  Allows you to create a page in the website which displays all of the doctor's published reviews.</li>
				<li><b>Gallery Component</b>:  Allows you to create a page in the website which displays all of the doctor's Before/After Galleries or Patient Stories</li>
			</ul>
			<p>Each of these components have Shortcodes that make adding them to pages easy.  Click "Shortcodes" under the DoctorLogic admin menu to see all available Shortcodes.</p>
		<form method="post" action="options.php">
			<?php settings_fields('dl-settings-group'); ?>
			<?php do_settings_sections('dl-settings-group'); ?>
			<table class="wp-list-table widefat striped">
				<tr>
					<th scope="row">
						DoctorLogic Site Key
					</th>
					<td>
						<input type="text" name="dl_site_key" value="<?php echo esc_attr(get_option('dl_site_key')); ?>"/>
					</td>
					<td>
						This unique identifier is supplied by DoctorLogic for each customer.  This value is required for the plugin to operate.  The key was sent to your customer or contact <a href="mailto:pluginsupport@doctorlogic.com">pluginsupport@doctorlogic.com</a> if you need help.
					</td>
				</tr>
				<tr>
					<th scope="row">
						Review Page
					</th>
					<td>
						<input type="text" name="dl_review_path" value="<?php echo esc_attr(get_option('dl_review_path')); ?>" />
					</td>
					<td>
						<p>If your Customer is using the DoctorLogic Review Component, you will need to create a full-width page to hold output of Reviews.  
							Type the page-slug for that page here.  If the page doesn't exist yet you <a href="post-new.php?post_type=page">can create it here</a>.</p>
													<?php
						if(get_option('dl_review_path')!=""){?>
						<p>
							<a href="/<?=get_option('dl_review_path')?>" target="_blank">Visit Page</a>
						</p>
						<?php
						}?>	

					</td>
				</tr>
				<tr>
					<th scope="row">
						Gallery Page
					</th>
					<td>
						<input type="text" name="dl_gallery_path" value="<?php echo esc_attr(get_option('dl_gallery_path')); ?>" />
					</td>
					<td>
						<p>If your Customer is using the DoctorLogic Gallery Component, you will need to create a full-width page to hold output of Before/After Galleries or Patient Stories.  
							Type the page-slug for that page here. If the page doesn't exist yet you <a href="post-new.php?post_type=page">can create it here</a>.</p>
						<?php
						if(get_option('dl_gallery_path')!=""){?>
						<p>
							<a href="/<?=get_option('dl_gallery_path')?>" target="_blank">Visit Page</a>
						</p>
						<?php
						}?>	
					</td>
				</tr>
				<tr>
					<th scope="row">
						DoctorLogic Environment
					</th>
					<td>
						<input type="text" name="dl_environment" value="<?php echo esc_attr(get_option('dl_environment')); ?>" />
						<input type="hidden" name="dl_api" value="<?php echo esc_attr(dl__environment()); ?>"
					</td>
					<td>
						Leave this blank unless instructed to modify by DoctorLogic Support Team.  This field is only used for testing.
					</td>
				</tr>
			</table>
			<?php submit_button();?>
		</form>
	</main>
</div>

<?php
}
function dl__advancedstyles(){
	$dl_css=get_option('dl_css');
	?>
	<div class="wrap" style="max-width: 1024px; background-color:#ffffff; padding:10px;" >
		<header style="background-color:#0083ac; color:#ffffff; font-size: 14px; font-weight: bold; padding:5px; vertical-align:middle">
			<img style="max-width: 180px;   vertical-align: middle;border: 0;"src="//assets.doctorlogicsites.com/Images/Sites/D/DoctorLogic/WordPress/logo_white.png" alt="DoctorLogic" />
			<div style="vertical-align: middle; text-align: right;"></div>
			<style type="text/css">
				th{font-weight:bold !important;}
			</style>
		</header>
        <main style="margin:10px;">
			<h2>DoctorLogic Advanced Styles</h2>
			<?php echo get_option( 'plugin_error' );
			if (isset($_GET['settings-updated'])){ ?>
				<div class="updated">
					<p><strong><?php _e('Settings saved.') ?></strong></p>
				</div>
			 <?php
			 }
			 $dl_css=get_option('dl_css');
			 ?>
			<form method="post" action="options.php">
				<?php settings_fields('dl-css-group'); ?>
				<?php do_settings_sections('dl-css-group'); ?>
				<p>You can customize any of the following selectors - use only valid CSS.</p>
				<p>For example, in the boxes below, you could type something like:</p>
				<pre>
				background-color:#ffffff;
				color:#000000;
				</pre>
				<table class="wp-list-table widefat striped">
				<thead>
				<tr><th>Class Name</th><th>Description</th><th>CSS<th>CSS for a tags</th><th>CSS for a:hover tags</tr>
				</thead>
					<?php
					echo dl__stylerow('heading', 'Used at the top of grids to clearly label a section');
					echo dl__stylerow('subheading', 'Used under headings to separate content');
					echo dl__stylerow('filter', 'Used as an in-page left navigation to filter results of a grid');
					echo dl__stylerow('review-result-row', 'A single row of results on the Review full-page component');
					echo dl__stylerow('gallery-result-row', 'A single row of results on the Gallery full-page component');
					echo dl__stylerow('gallery-result-row-view-button', 'Button which links from a Gallery row to a single Gallery');
					echo dl__stylerow('review-summary', 'Summary components for Reviews or Gallery');
					echo dl__stylerow('gallery-summary', 'Summary components for Reviews or Gallery');
					echo dl__stylerow('star', 'Stars used for ratings');
					?>
					<tr>
						<td>Ad-Hoc Styles</td>
						<td colspan="2">Use with great caution (and may not be forward compatible) to modify specific selectors that are not included in the choices above.  Here you must type selectors, curly braces, and styles. </td>
						<td colspan="2">
							<textarea rows="5" cols="60" name="dl_css[dl__adhoc]"><?=esc_attr($dl_css['dl__adhoc']); ?></textarea>
						</td>
					</tr>
				</table>
				<?php submit_button();?>
			</form>
		</main>
	</div>
<?php
}

function dl__stylerow($class, $description){
	$dl_css=get_option('dl_css');
	ob_start;
?>
				<tr>
					<td><?=$class?></td>
					<td><?=$description?></td>
					<td>
						<textarea rows="5" cols="30" name="dl_css[<?=$class?>]"><?=esc_attr($dl_css[$class]); ?></textarea>
					</td>
					<td>
						<textarea rows="5" cols="30" name="dl_css[<?=$class?> a]"><?=esc_attr($dl_css[$class.' a']); ?></textarea>
					</td>
					<td>
						<textarea rows="5" cols="30" name="dl_css[<?=$class?> a:hover]"><?=esc_attr($dl_css[$class.' a:hover']); ?></textarea>
					</td>
				</tr>
<?php
	$s= ob_get_contents();
	ob_end_clean();
	return $s;
	
}


function dl__shortcodes(){
?>
	<div class="wrap" style="max-width: 1024px; background-color:#ffffff; padding:10px;" >
		<header style="background-color:#0083ac; color:#ffffff; font-size: 14px; font-weight: bold; padding:5px; vertical-align:middle">
			<img style="max-width: 180px;   vertical-align: middle;border: 0;"src="//assets.doctorlogicsites.com/Images/Sites/D/DoctorLogic/WordPress/logo_white.png" alt="DoctorLogic" />
			<div style="vertical-align: middle; text-align: right;"></div>
			<style type="text/css">
				th{font-weight:bold !important;}
			</style>
		</header>
        <main style="margin:10px;">
		<div>
		<h2>Recommended Shortcodes</h2>
		<table class='wp-list-table widefat striped'><thead>
			<tr><th>On This Page</th><th>Place this Shortcode</th></tr></thead><tbody>
			<?php
			if(get_option('dl_review_path')!=""){
				echo "<tr><td>".get_option('dl_review_path')."</td><td>[DoctorLogicReviews]</td></tr>";
			}
			if(get_option('dl_gallery_path')!=""){
				echo "<tr><td>".get_option('dl_gallery_path')."</td><td>[DoctorLogicGallery]</td></tr>";
			}
			?>
		</tbody></table>
		</div>

		<h2>Available Shortcodes</h2>
		<p>These small components work nicely on pages about specific practitioners, facilities, or procedures.  If you have content about any of the following, you can add the Shortcodes shown to that page or section:</p>
		<table class='wp-list-table widefat striped'><thead><th colspan='2'><b>If you have content about</b></th>
		
	<?php
	$apiurl = dl__environment()."/gallery/listcomponent";
	$json = file_get_contents($apiurl);
	$json_output = json_decode($json);
	if  (get_option('dl_review_path')!=""){
	echo "<th><b>Shortcode for Review Summary</b></th>";
	}
	if  (get_option('dl_gallery_path')!=""){
		 echo "<th><b>Shortcode for Gallery Summary</b></th></thead><tbody>";
	}
	echo dl__Shortcode('Facility', 'facility', $json_output->MasterPage->Facilities);
	echo dl__Shortcode('Practitioner', 'personnel', $json_output->MasterPage->Practitioners);
	echo dl__Shortcode('Person', 'personnel', $json_output->MasterPage->PersonnelList);
	echo dl__Shortcode('Procedure', 'procedure', $json_output->MasterPage->Procedures);
	echo "</div></tbody></table>";
	?>
		</main>
	</div>
	<?php
}


function dl__Shortcode($type, $id, $object){
	$s="";
	foreach($object as $p){
		$o = (array)$p;
		$s.=dl_Shortcoderow($type, $id, $o);
	}
	return $s;
}

function dl__diagnostics(){
	$info = plugin_dir_path(__FILE__) . 'inc/info.php'
	?>
		<div class="wrap" style="max-width: 1024px; background-color:#ffffff; padding:10px;" >
		<header style="background-color:#0083ac; color:#ffffff; font-size: 14px; font-weight: bold; padding:5px; vertical-align:middle">
			<img style="max-width: 180px;   vertical-align: middle;border: 0;"src="//assets.doctorlogicsites.com/Images/Sites/D/DoctorLogic/WordPress/logo_white.png" alt="DoctorLogic" />
			<div style="vertical-align: middle; text-align: right;"></div>
			<style type="text/css">
				th{font-weight:bold !important;}
				.dashicons-yes {color:green;}
				.dashicons-no {color:red;}
			</style>
		</header>
        <main style="margin:10px;">
		<div>
		<h2>Diagnostics</h2>
		<p>The tools below may help you trouble-shoot problems in your environment that prevent DoctorLogic Plugins for working correctly.</p>
		<table class="wp-list-table widefat striped">
			<thead>
				<tr>
					<th>Status</th><th>Test</th><th>Value</th><th>Fixes</th>
			</thead>
			<tbody>
				<?=dl__TestEnvironment()?>
				<?=dl__allow_url_fopen()?>
				<?=dl__TestGalleryList()?>
				<?=dl__TestReviewList()?>
			</tbody>
		</table>
		<h3>PHP Info</h3>
			<p><?php echo snapshot_data(); ?></p>
		</div>
	</main>

	<?php 
}
function dl__TestEnvironment(){
	$pass = ( get_option('dl_environment')=="https://pulse.doctorlogic.com" ||  get_option('dl_environment')=="");
	?>
	<tr>
		<td><?=dl__pass($pass)?></td>
		<td>DoctorLogic Environment String</td>
		<td><?= get_option('dl_environment')?></td>
		<td>
			<?php if(!$pass) { echo "On DoctorLogic > General tab, make sure DoctorLogic Environment does not contain content - click Save.";}	?>
		</td>
	</tr>
	<?php
}

function dl__allow_url_fopen(){
	
	$pass=ini_get("allow_url_fopen");
	?>
	<tr>
		<td><?=dl__pass($pass)?></td>
		<td>allow_url_fopen Setting</td>
		<td><?=ini_get("allow_url_fopen")?></td>
		<td>
			<?php
			if(!$pass){
				echo "Modify your server's php.ini and set allow_url_fopen = on";
			}
			?>
		</td>
	</tr>

	<?php

}



function dl__TestGalleryList(){
	$apiurl = dl__environment()."/gallery/listcomponent";
	$response = wp_remote_get($apiurl);
	$pass=true;
	$error_message="";
	if(is_wp_error($response)){
		$pass = false;
		$error_message =  $response->get_error_message();
	}
	?>
	<tr>
		<td><?=dl__pass($pass)?></td>
		<td>Gallery API Request</td>
		<td><a href="<?=$apiurl?>" target="_blank">Gallery List API</a></td>
		<td>
			<?=$error_mesage?>
		</td>
	</tr>

	<?php

}
function dl__TestReviewList(){
	$apiurl = dl__environment()."/testimonial?isPublished=true";
	$response = wp_remote_get($apiurl);
	$pass=true;
	$error_message="";
	if(is_wp_error($response)){
		$pass = false;
		$error_message =  $response->get_error_message();
	}
	?>
	<tr>
		<td><?=dl__pass($pass)?></td>
		<td>Review API Request</td>
		<td><a href="<?=$apiurl?>" target="_blank">Gallery List API</a></td>
		<td>
			<?=$error_mesage?>
		</td>
	</tr>

	<?php

}

function dl__pass($pass) {
	if($pass){
		$state="yes";
	} else {
		$state="no";
	}
	return "<span class='dashicons dashicons-".$state."'></span>";
}

function dl_Shortcoderow($type, $id, $o){
	$s= '<tr><td>The ' . $type . '</td><td>' . $o['Label']. '</td>';

	if  (get_option('dl_review_path')!=""){
		$s .='<td>[DoctorLogicReviewSummary '. $id .'="' . reset($o). '" label="' . $o['Label'] . '"]</td>';
	}
	if  (get_option('dl_gallery_path')!=""){
		$s .='<td>[DoctorLogicGallerySummary '. $id .'="' . reset($o). '" label="' . $o['Label'] . '"]</td>';
	}
	$s .='</tr>';
	return $s;
}

function dl__environment(){
	if(get_option('dl_environment')=="1" or get_option('dl_environment')==""){
		$apiurl = "https://pulse.doctorlogic.com";
	}
	else{
		$apiurl = get_option('dl_environment');	
	}
	$apiurl.="/api/site/".get_option('dl_site_key');
	return $apiurl;
}
?>

