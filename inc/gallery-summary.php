<?php
function DoctorLogicGallerySummary($atts, $instance) {
		$GalleryPageName = get_option('dl_gallery_path');
		$API = get_option('dl_api');

		$a = shortcode_atts(array('label' => '', 'personnel' => '', 'facility' => '', 'procedure' => ''), $atts);
		$label = $a['label'];
        $personnel = $a['personnel'];
        $facility = $a['facility'];
        $procedure = $a['procedure'];


        $apiurl = $API."/list/gallerylist?dumpmode=json";
        $json = file_get_contents($apiurl);
        $json_output = json_decode($json);
        $filingName = $json_output->GalleryListViewModel->MasterPage->SiteInfo->FilingName;
        $assetPath = "//assets.doctorlogicsites.com/Images/Sites/" . substr($filingName, 0, 1) . "/" . $filingName;
        $g = $json_output->GalleryPage->Gallery->Gallery_Load_Result;
		$GalleryCount = 0;
        foreach($g as $gallery){
            $GalleryCount++;
        }
if(($personnel=="")||$galleryCount==0){
$s= "<div class='dl__gallerysummary'>";
$s.="<h2>Photo Gallery</h2>";
$s.=$GalleryCount. " Procedure Pictures <br />";
$s.="<a href=''>View All " . $GalleryCount. "Pictures</a><br />";
$s.="<h2>Featured Photo Galleries</h2>";

$s.="</div>";
}
return $s;
}
?>
