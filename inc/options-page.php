<?php // create custom plugin settings menu
add_action('admin_menu', 'dl_create_menu');

function dl_create_menu(){
	add_menu_page('DoctorLogic Plugin Settings', 'DoctorLogic', 'manage_options', __FILE__, 'dl_settings_page', plugins_url('../img/icon.png', __FILE__));
	add_submenu_page( __FILE__, 'DoctorLogic Plugin Settings', 'General', 'manage_options', __FILE__, 'dl_settings_page' );
	add_submenu_page( __FILE__, 'Advanced Styles', 'Advanced Styles', 'manage_options', 'dl__advancedstyles', 'dl__advancedstyles' );
	add_submenu_page( __FILE__, 'Shortcodes', 'Shortcodes', 'edit_pages', 'dl__shortcodes', 'dl__shortcodes' );
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
						If your Customer is using the DoctorLogic Review Component, you will need to create a full-width page to hold output of Reviews.  Type the page-slug for that page here.  If the page doesn't exist yet you <a href="post-new.php?post_type=page">can create it here</a>.
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
						If your Customer is using the DoctorLogic Gallery Component, you will need to create a full-width page to hold output of Before/After Galleries or Patient Stories.  Type the page-slug for that page here. If the page doesn't exist yet you <a href="post-new.php?post_type=page">can create it here</a>.
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
