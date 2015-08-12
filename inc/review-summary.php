<?php
function DoctorLogicReviewSummary($atts, $instance) {

    //get plugin settings
    $ReviewPageName = get_option('dl_review_path');
    $API = get_option('dl_api');

    //decode query strings
    $a = ShortCode_atts(array('label' => '', 'personnel' => '', 'facility' => '', 'procedure' => '', 'slideshow' => ''), $atts);
    $label = $a['label'];
    $personnel = $a['personnel'];
    $facility = $a['facility'];
    $procedure = $a['procedure'];
    $slideshow = $a['slideshow'];


    //build API URL
    $qs="";
    $apiurl = $API."/testimonial?isPublished=true";
	if($personnel!=""){$qs.="&personnel=" . $personnel; }
	if($facility!=""){$qs.="&facility=" . $facility; }
	if($procedure!=""){$qs.="&procedure=" . $procedure; }
	$apiurl.=$qs;
    
    //get Calculate summary ReviewCount (for one person, facility or procedure)
    $json = file_get_contents($apiurl);
    
    $json_list = json_decode($json, true);
    $ReviewCount = count($json_list);
    
    //echo $apiurl;
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
	if($personnel!="" && $facility=="" && $procedure==""){$itemType="https://schema.org/Physician";}
	if($facility!="" && $personnel=="" && $procedure==""){$itemType="https://schema.org/MedicalClinic";}
	if($procedure!="" && $facility=="" && $personnel==""){$itemType="https://schema.org/MedicalProcedure";}

	//build "stars" string
	$stars="";
	for ($i = 0; $i < intval($SiteRating); $i++) {
		$stars.="<span class='dashicons dashicons-star-filled  dl__star'></span>";
	}
	if (intval($SiteRating) < $SiteRating) {
		$stars.="<span class='dashicons dashicons-star-half  dl__star'></span>";
	};


	if($slideshow==""){

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
				<div style="dl__clear">&nbsp;</div>
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
else
{
	ob_start();
?>
	<div class="dl__grid">
		<div class="dl__col dl__col--2-of-3" id="dl__slider">
			<ul>
				<?php
				foreach ($json_list as $review) {
				?>
					<li>
						<div class="dl__review-slide">
						<div class="dl__review-label">
						<?php
						if($label<>""){echo $label;}
						?> Reviews
						</div>
						<div class="dl__review-body">
							<?php
							$lines = explode("\n", wordwrap(str_replace("\n"," - ",$review["LongDescription"]), 200, "\n"));
							echo $lines[0];
							if (count($lines)>1){echo "...";}
							?>
						</div>
						<div class="dl__review-byline">
							- <?=$review["Author"]?> / <?=$review["TestimonialSourceLabel"]?> / 
							<?php
							$d=date_create($review["DateReviewed"]);
							echo $d->format("M d, Y");
							?>
							
						</div>
					</div>
					</li>
				<?php
				}
				?>
			</ul>
		</div>
		<div class="dl__col dl__col--1-of-3">
		<div class="dl__review_summary" style="height:200px;">
			<span itemprop="name" style="display:none;"><?=$label?></span>
			<div class="dl__col" itemtype="https://schema.org/AggregateRating" itemprop="aggregateRating" itemscope="">
				<div class="dl__rating">
					<span class="dl__rating-number" itemscope="" itemprop="ratingValue"><?=$SiteRating?></span>
					<span class="dl__stars"><?=$stars?></span>
				</div>
				<div style="dl__clear">&nbsp;</div>
				<?php 
				if($ReviewCount!=0){
				?>
					<div><a href="/<?=$ReviewPageName?>?label=<?=$label?><?=$qs?>"><?=$ReviewCount?> <?=$label?> Reviews</a></div>
				<?php 
				}
				?>
				
				<div class="dl__button">
					<a href="/<?=$ReviewPageName?>"><span itemprop="reviewCount"><?=$SiteCount;?></span> Total Site Reviews</a>
				</div>
				<div>&nbsp;</div>
				<div>
					<a class="dl__buttonlink" href="/<?=$ReviewPageName?>">See All <?=$SiteCount;?></span> Reviews</a>
				</div>
				<meta itemprop="bestRating" content="5">
			</div>
		</div>
		</div>
	</div>


	<?php
	$s = dl__palette();
	$s.= ob_get_contents();
	ob_end_clean();
	return $s;

}
	

}
?>