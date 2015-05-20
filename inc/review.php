<?php
function DoctorLogicReviews($atts, $instance) {

		$ReviewPageName = get_option('dl_review_path');
        $API = get_option('dl_api');

        $label = $_GET[label];
        $personnel =$_GET[personnel];
        $facility = $_GET[facility];
        $procedure = $_GET[procedure];
        $rating = $_GET[rating];
        $testimonialsource = $_GET[source];
        $sort = $_GET[sort];

		$apiurl = $API."/testimonial?isPublished=true";
		if($personnel!=""){$apiurl.="&personnel=" . $personnel; }
        if($facility!=""){$apiurl.="&facility=" . $facility; }
        if($procedure!=""){$apiurl.="&procedure=" . $procedure; }
        if($rating!=""){$apiurl.="&rating=" . $rating; }
        if($testimonialsource!=""){$apiurl.="&source=" . $testimonialsource; }

		$json = file_get_contents($apiurl);
		$json_Testimonial = json_decode($json);
		$ReviewCount = count($json_Testimonial);

        $apiurl = $API."/testimonial/filters?isPublished=true";
        $json = file_get_contents($apiurl);
		$json_filter = json_decode($json);
        ob_start();
        ?>
<div class="dl__grid" id="dl__main-grid">

    <div class="dl__col dl__col--1-of-4  dl__filter">
        <div class="dl__heading">
        Show Only:
        </div>
        <?=dl_filter_item($json_filter, 'Rating', 'rating');?>
        <?=dl_filter_item($json_filter, 'Source', 'source') ;?>
        <?=dl_filter_item($json_filter, 'Personnel', 'personnel') ;?>
        <?=dl_filter_item($json_filter, 'Procedure', 'procedure') ; ?>
    </div>

    <div class="dl__col dl__col--3-of-4 ">
        <div class="dl__grid">
            <div class="dl__col dl__col--3-of-3 dl__heading">
            <?=$ReviewCount?>
            Review<?=($ReviewCount==1)?"":"s"?>
            <?php
            if ($label != ""){?>
                 -
                 <?=$label?>
        		 <span style="font-weight:normal; font-size:15px;"><a href="/<?=$ReviewPageName?>">
                 <span style="white-space: nowrap;">&nbsp;(See More Reviews)</span></a></span>
            <?php
            }
            ?>
            </div>
        </div>
            <?php
            foreach ($json_Testimonial as $key => $value) {
        		$NormalizedRating = number_format($value->NormalizedRating, 1);
        		If ($NormalizedRating == "0.0") {
        				$NormalizedRating = "";
        		}
        		$Rating = number_format($value->Rating, 1);
        		If ($Rating == "0.0") {
        				$Rating = "";
        		}
                ?>

        		<div class="dl__grid dl__review_result_row" >
                    <div class="dl__col dl__col--1-of-3">
                    <?php
                    if ($Rating != "" && $Rating<=5) {
                    ?>
                    <div class="dl__rating">
                        <div class="dl__rating-number">
                            <?=$Rating?>
                        </div>
						<div class="dl__stars">
                        <?php
                        $stars="";
                        for ($i = 0; $i < intval($Rating); $i++) {
                            $stars.="<span class=\"dashicons dashicons-star-filled  dl__star\"></span>";
                        }
                        if (intval($Rating) < $Rating) {
                            $stars.="<span class=\"dashicons dashicons-star-half  dl__star\"></span>";
                        };
                        ?>
                        <?=$stars;?>
						</div>
                    </div>
                    <?php
                    } else {
                    ?>
                    <div class="dl__rating">Patient Story</div>
                    <?php
                    }
                    ?>
                    <img src="<?=$value->TestimonialSourceLogoPath?>?mobilewidth=96&w=150" />
                </div>
                <div class="dl__col dl__col--2-of-3">
                    <div style="font-weight:bold;">
                        <span class="dl__no-wrap">Review from <?=$value->Author?></span> -
                        <?php
                        if($value->Source!=1){
                        ?>
                        <span class="dl__no-wrap">Source: <a href ="<?=$value->ExternalURL?>" target="_blank"> <?=$value->TestimonialSourceLabel?> </a></span>  -
                        <?php
                        }
                        ?>
                        <span class="dl__no-wrap"><?=date_create($value->DateReviewed)->format("M d, Y")?></span>
                    </div>
                    <div>
                        <div class="dl__showhide">
                            <div><?=$value->LongDescription?></div>
                        </div>
						<?php
						
						foreach ($value->Media as $media) {
						?>
						<img class="dl__modal" name="<?=$media->MediaId?>" href="#<?=$media->MediaId?>" src="<?=$media->Url?>?mobilewidth=96&w=150" />
						<div style="display:none" id="<?=$media->MediaId?>">
						<img src="<?=$media->Url?>" />
						</div>
						<?php
						}
						?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<?php
$s = dl__palette();
$s.= ob_get_contents();
ob_end_clean();
return $s;
}

function dl_filter_item($json_filter, $Filter, $QS){
    $t = "<div class='dl__subheading'>" . $Filter . "</div>
    <ul class='dl__ul'>";
   foreach ($json_filter as $f){
       if ($f->Filter==$Filter){
        $t.= "<li><a href='?label=" . $f->Label . "&". $QS . "=" . $f->Id ."'>" .  $f->Label . "</a> (" . $f->Count . ")</li>"  ;
        }
    }
    $t .="</ul>";
    return $t;
}
?>