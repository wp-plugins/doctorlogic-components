<?php
function DoctorLogicReviewSummary($atts, $instance) {

    //get plugin settings
    $ReviewPageName = get_option('dl_review_path');
    $API = get_option('dl_api');

    //decode query strings
    $a = ShortCode_atts(array('label' => '', 'personnel' => '', 'facility' => '', 'procedure' => ''), $atts);
    $label = $a['label'];
    $personnel = $a['personnel'];
    $facility = $a['facility'];
    $procedure = $a['procedure'];

    
    //build API URL
    $qs="";
    $apiurl = $API."/testimonial?isPublished=true";
	if($personnel!=""){$qs.="&personnel=" . $personnel; }
	if($facility!=""){$qs.="&facility=" . $facility; }
	if($procedure!=""){$qs.="&procedure=" . $procedure; }

    //get Calculate summary ReviewCount (for one person, facility & procedure
    $json = file_get_contents($apiurl . $qs);
    $ReviewCount = count(json_decode($json, true));

    
    //get Site Stats
    $apiurl = $API."/testimonial/statistics";
    $json = file_get_contents($apiurl);
    $Stats = json_decode($json);
    foreach ($Stats as $key => $value) {
        if ($value->CountType == "IsPublished") {
			$SiteCount = $value->Count;}
				if ($value->CountType == "RatedIsPublished"){
			$SiteRating = $value->AverageReview;
        }
    };

	//calculate itemtype 
	$itemType="https://schema.org/MedicalEntity";
	if($personnel!="" && $facility=="" && $procedure==""){ $itemType="https://schema.org/Physician";}
	if($facility!="" && $personnel=="" && $procedure==""){$itemType="https://schema.org/MedicalClinic";}
	if($procedure!="" && $facility=="" && $personnel==""){$itemType="https://schema.org/MedicalProcedure";}

	//build "stars" string
	$stars="";
	for ($i = 0; $i < intval($SiteRating); $i++) {
		$stars.="<span class=\"dashicons dashicons-star-filled  dl__star\"></span>";
	}
	if (intval($SiteRating) < $SiteRating) {
		$stars.="<span class=\"dashicons dashicons-star-half  dl__star\"></span>";
	};
	ob_start();
?>

	<div class="dl__grid dl--no-gutter" itemtype="<?=$itemType?>" itemscope="">
		<span itemprop="name" style="display:none;"><?=$label?></span>
		<div class="dl__review_summary">
			<div class="dl__col" itemtype="https://schema.org/AggregateRating" itemprop="aggregateRating" itemscope="">
				<div class="dl__rating">
					<span class="dl__rating-number" itemscope="" itemprop="ratingValue"><?=$SiteRating?></span>
					<span class="dl__stars"><?=$stars?></span>
				</div>
				<div style="height:1px; font-size:1px; clear:both;">&nbsp;</div>
				<?php if($ReviewCount!=0){?><div><a href="/<?=$ReviewPageName?>?label=<?=$label?><?=$qs?>"><?=$ReviewCount?> <?=$label?> Reviews</a></div><?php }?>
				<div><a href="/<?=$ReviewPageName?>">
				<span itemprop="reviewCount"><?=$SiteCount;?></span> Total Site Reviews</a></div>
				<meta itemprop="bestRating" content="5">
			</div>
		</div>
	</div>

<?php
	$s = dl__palette();
	$s.= ob_get_contents();
	ob_end_clean();
	return $s;
}
?>
