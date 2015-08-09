<?php
function DoctorLogicGallerySummary($atts, $instance) {
	$GalleryPageName = "/".get_option('dl_gallery_path')."?";
	$API = get_option('dl_api');

	$a = shortcode_atts(array('label' => '', 'personnel' => '', 'facility' => '', 'procedure' => ''), $atts);
	$label = $a['label'];
    $personid = $a['personnel'];
    $facilityid = $a['facility'];
    $procedureid = $a['procedure'];

    $apiurl = $API."/page/gallerylist?";
    $qs="";
    if($personid!=""){$qs.="&personid=" . $personid; }
    if($facilityid!=""){$qs.="&facilityid=" . $facilityid; }
    if($categoryid!=""){$qs.="&categoryid=" . $categoryid; }
    if($procedureid!=""){$qs.="&procedureid=" . $procedureid; }
    $apiurl.=$qs;
    
    $json = file_get_contents($apiurl);
    $json_output = json_decode($json);
    $filingName = $json_output->MasterPage->SiteInfo->FilingName;

    $assetPath = "//assets.doctorlogicsites.com/Images/Sites/" . substr($filingName, 0, 1) . "/" . $filingName;
    $GalleryCount = $json_output->TotalGalleryCount;
    $FilteredGalleryCount = $json_output->FilteredGalleryCount;

    ob_start();
    if($FilteredGalleryCount>0){
        $g=$json_output->GalleryGroups[0]->Galleries[0];

        ?>
        <div class="dl__grid dl--no-gutter" >
            <div class="dl__gallerysummary">
                <div class="dl__heading">Photo Gallery</div>
                <a href="<?=$GalleryPageName.$qs.'&label='.$label?>">View All <?=$FilteredGalleryCount?> <?=$label?> Results</a><br />
                <a href="<?=$GalleryPageName?>">View All <?=$GalleryCount?> Results</a><br />
                <br />
                <div class="dl__subheading">Featured Galleries</div>
                <div class="dl__gallery-result-row" style="padding:10px 10px 20px 10px;">
                        <a href="<?=$GalleryPageName."?galleryid=".$g->GalleryId?>"><img class="dl__gallery_list_image" src="<?=imagePath1($assetPath, $g)?>w=400&deviceType=Desktop" alt="Before" /></a>
                        <a href="<?=$GalleryPageName."?galleryid=".$g->GalleryId?>"><img class="dl__gallery_list_image" src="<?=imagePath2($assetPath, $g)?>&w=400&deviceType=Desktop" alt="After" /></a>
                        <div class="dl__col dl__procedurelabel"><?=$g->ProcedureLabel?></div>
                            <dl class="table">
                                <span>
                                <dt>Age: </dt>
                                <dl><a href="<?=$GalleryPageName."?patientage=".$g->PatientAgePath."&label=Ages ".$g->AgeLabel?>"><?=$g->AgeLabel?></a></dl>
                                </span>
                                <span>
                                <dt>Gender: </dt>
                                <dl><a href="<?=$GalleryPageName."?genderpath=".$g->GenderPath."&label=".$g->GenderPath?>"><?=$g->GenderLabel?></a></dl>
                                </span>
                                <span>
                                <dt>Ethnicity: </dt>
                                <dl><a href="<?=$GalleryPageName."?ethnicitypath=".$g->EthnicityPath."&label=".$g->EthnicityLabel?> Patients"><?=$g->EthnicityLabel?></a></dl>
                                </span>
                                <span>
                                <dt>Height: </dt>
                                <dl><a href="<?=$GalleryPageName."?height=".$g->HeightPath."&label=Height: ".$g->HeightLabel?>"><?=$g->HeightLabel?></a></dl>
                                </span>
                                <span>
                                <dt>Weight: </dt>
                                <dl><a href="<?=$GalleryPageName."?weight=".$g->WeightPath."&label=Weight: ".$g->WeightLabel?>"><?=$g->WeightLabel?></a></dl>
                                </span>
                                <span>
                                <dt>Gallery: </dt>
                                <dl><?=$g->GalleryId?></dl>
                                </span>
                            </dl>
                            <div>
                                <br />
                            <a class="dl__buttonlink" href="<?=$GalleryPageName."?galleryid=".$g->GalleryId?>">View Photos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } 
        else 
    {
        ?>
        <div class="dl__grid dl--no-gutter" >
            <div class="dl__gallerysummary">
                <div class="dl__heading">Photo Gallery</div>
                <a href="<?=$GalleryPageName.$qs.'&label='.$label?>">View All <?=$GalleryCount?> Results</a><br />
                <br />
            </div>
        </div>

    <?php
    }
    $s = dl__palette();
    $s.= ob_get_contents();
    ob_end_clean();
    return $s;
}
?>
