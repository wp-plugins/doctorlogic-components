<?php
function DoctorLogicGallery($args, $instance) {

		$GalleryPageName = "/".get_option('dl_gallery_path');
		$ReviewPageName = get_option('dl_review_path');
		$API = get_option('dl_api');

		$galleryid = $_GET[galleryid];
        $label = $_GET[label];
        $personid =$_GET[personid];
        $categoryid = $_GET[categoryid];
		$procedureid = $_GET[procedureid];
		

        if($galleryid!=""){
        	//$apiurl = "https://2.doctorlogicsites.com/item/gallery/".$galleryid."?dumpmode=json";
			$apiurl = $API."/page/gallery/".$galleryid;
		}
		else {

        $apiurl = $API."/page/gallerylist?";
		if($personid!=""){$apiurl.="&personid=" . $personid; }
        if($facilityid!=""){$apiurl.="&facilityid=" . $facilityid; }
		if($categoryid!=""){$apiurl.="&categoryid=" . $categoryid; }
        if($procedureid!=""){$apiurl.="&procedureid=" . $procedureid; }
        if($_GET[patientage]!=""){$apiurl.="&patientage=" .  $_GET[patientage]; }
        if($_GET[genderpath]!=""){$apiurl.="&genderpath=" .  $_GET[genderpath]; }
        if($_GET[ethnicitypath]!=""){$apiurl.="&ethnicitypath=" .  $_GET[ethnicitypath]; }
        if($_GET[height]!=""){$apiurl.="&height=" .  $_GET[height]; }
        if($_GET[weight]!=""){$apiurl.="&weight=" .  $_GET[weight]; }
        if($_GET[tagpath]!=""){$apiurl.="&tagpath=" .  $_GET[tagpath]; }
        }
        
        $json = file_get_contents($apiurl);
        $json_output = json_decode($json);
        $filingName = $json_output->MasterPage->SiteInfo->FilingName;
        $assetPath = "//assets.doctorlogicsites.com/Images/Sites/" . substr($filingName, 0, 1) . "/" . $filingName ;

        echo dl__palette();

        //GalleryList page
        if ($galleryid == "") {
			$GalleryCount=0;
			foreach($json_output->GalleryGroups as $group){
				$GalleryCount+=count($group->Galleries);
			}
?>
        
        <div class="dl__grid" id="dl__main-grid">
            <div class="dl__col dl__col--1-of-4 dl__filter" id="dl__filter">
                <div class="dl__heading">
                    Show Only:
                </div>
 					<?php
					$previous = 0;
					foreach($json_output->SearchToolItems as $search)
					{
						if ($search->ParentId==-1){
							?>
							</ul>
							<div class='dl__subheading'>
								<a href="<?=$GalleryPageName."?categoryid=".$search->CategoryId."&label=".$search->Label?>">
									<?= $search->Label ." (".$search->GalleryCount.")"?>
								</a>
							</div>
							<ul class="dl__ul">
							<?php
						} else 
						{
							?>
								<a href="<?=$GalleryPageName."?procedureid=".$search->ProcedureId."&label=".$search->Label?>">
							<li>
								<?= $search->Label ." (".$search->GalleryCount.")" ?>
								</a>
							</li>
							<?php
						}
						if ($previous==-1 && $search->ParentId==-1){
						?>
						</ul>
						<?php
						}
						$previous = $search->ParentId;
					}
					?>
			</div>
            <div class="dl__col dl__col--3-of-4">
                <div class="dl__grid">
                    <div class="dl__heading">
					<?php
                    echo $GalleryCount." Galleries";

                    if ($label != "") {
						?>
                		for <?=$label?>
                		<a href="<?=$GalleryPageName?>"><span class="dl__no-wrap">&nbsp;(See All Galleries)</span></a>
						<?php
                    }
					?>
                    </div>
					<?php
	        		foreach ($json_output->GalleryGroups as $group) {
						$thisGroup=$group;
						$previousProcedure=0;
						foreach ($group->Galleries as $g) 
						{
							if(($g->ProcedureId!=$previousProcedure) && $procedureid==""){
							?>
							<div class="dl__col dl__col--2-of-2 dl__subheading">
								<?=count($thisGroup->Galleries)?> Result<?=(count($thisGroup->Galleries)==1?"":"s")?> for <?=$g->ProcedureLabel?>
							</div>
							<?php
							}
							?>
							<div class="dl__grid dl__gallery-result-row">
								<div class="dl__col  dl__col--2-of-4">
									<img class="dl__gallery_list_image" src="<?=imagePath1($assetPath, $g)?>&w=400&deviceType=Desktop" alt="Before" />
									<img class="dl__gallery_list_image" src="<?=imagePath2($assetPath, $g)?>&w=400&deviceType=Desktop" alt="After" />
								</div>
								<div class="dl__col dl__col--2-of-4">
									<div class="dl__grid">
										<div class="dl__col dl__col--2-of-2 dl__procedurelabel"><?=$g->ProcedureLabel?> <a href="<?=$GalleryPageName."?galleryid=".$g->GalleryId?>" class="dl__gallery-result-row-view-button dl__buttonlink dl__buttonnarrow">View</a></div>
											<div class="dl__col dl__col--1-of-2 " >
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
												</dl>
											</div>
											<div class="dl__col dl__col--1-of-2 " >
												<dl class="table">
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
											</div>
										<div class="dl__col  dl__col--2-of-2 "><a class="dl__buttonlink dl__buttonwide" href="<?=$GalleryPageName."?galleryid=".$g->GalleryId?>">View</a></div>
									</div>
								</div>
							</div>
							<?php
							$previousProcedure=$g->ProcedureId;
							}
						}
					?>
                </div>
            </div>
        </div>
<?php
		}
		else
		{
		$g=$json_output->Gallery[0];
		?>
				


        <div class="dl__grid" style="max-width:1170px; margin-left:auto; margin-right:auto;">
			
			<div class="dl__col dl__col--4-of-4 dl__heading"><?=$g->Headline?></div>
			<div class="dl__grid dl__subheading">
					<div class="dl__col dl__col--1-of-4">
						<div class="dl__gallery_section_title">
							Patient<a class="dashicons dashicons-plus-alt dl__hideshow" href="#">&nbsp;</a>
						</div>
						<dl class="table dl__m_hidden">
							<span>
								<dt>Age:</dt>
								<dd><a href="<?=$GalleryPageName."?patientage=".$g->PatientAgePath."&label=Ages ".$g->AgeLabel?>"><?=$g->AgeLabel?></a></dd>
							</span>
							<span>
								<dt>Gender:</dt>
								<dd><a href="<?=$GalleryPageName."?genderpath=".$g->GenderPath."&label=".$g->GenderPath?>"><?=$g->GenderLabel?></a></dd>
							</span>
							<span>
								<dt>Ethnicity:</dt>
								<dd><a href="<?=$GalleryPageName."?ethnicitypath=".$g->EthnicityPath."&label=".$g->EthnicityLabel?> Patients"><?=$g->EthnicityLabel?></a></dd>
							</span>
							<span>
								<dt>Height:</dt>
								<dd><a href="<?=$GalleryPageName."?height=".$g->HeightPath."&label=Height: ".$g->HeightLabel?>"><?=$g->HeightLabel?></a></dd>
							</span>
							<span>
								<dt>Weight:</dt>
								<dd><a href="<?=$GalleryPageName."?weight=".$g->WeightPath."&label=Weight: ".$g->WeightLabel?>"><?=$g->WeightLabel?></a></dd>
							</span>
							<span>
								<dt>Case #:</dt>
								<dd><?=$g->GalleryId?></dd>
							</span>
						</dl>
					</div>
					<div class="dl__col dl__col--1-of-4">
						<div class="dl__gallery_section_title">
							Procedure<a class="dashicons dashicons-plus-alt dl__hideshow" href="#">&nbsp;</a>
						</div>
						<ul class="dl__m_hidden dl__only6">
							

							<?php
							foreach($json_output->Gallery as $p){
								?>
								<li><strong><a href="<?=$GalleryPageName."?procedureid=".$p->ProcedureId."&label=".$p->ProcedureLabel?>"><?=$p->ProcedureLabel?></a></strong></li>
								<?php
							}
							foreach($json_output->Tags as $t){
								?>
								<li><a href="<?=$GalleryPageName."?tagpath=".$t->Path."&label=".$t->Label?>"><?=$t->Label?></a></li>
								<?php
							}
							?>
						</ul>
					</div>
					<div class="dl__col dl__col--1-of-4">
						<div class="dl__gallery_section_title">
							Facility<a class="dashicons dashicons-plus-alt dl__hideshow" href="#">&nbsp;</a>
						</div>
						<div class="dl__m_hidden">
							<div><?=$json_output->Facility->Label?></div>
							<div style="font-weight:normal; margin-bottom:5px;"><?=$json_output->Facility->City?>, <?=$json_output->Facility->State?></div>
							
							<ul class="">
								<li><a href="<?=$GalleryPageName."?facility=".$json_output->Facility->FacilityId."&label=".$json_output->Facility->Label?>">Galleries</a></li>
								<?php
								if($ReviewPageName!=""){
									?>
									<li><a href="<?=$ReviewPageName."?facility=".$json_output->Facility->FacilityId."&label=".$json_output->Facility->Label?>">Reviews</a></li>
									<?php
								}
								?>
							</ul>	
						</div>
					</div>
					<div class="dl__col dl__col--1-of-4">
						<div class="dl__gallery_section_title">
							Practitioner<a class="dashicons dashicons-plus-alt dl__hideshow" href="#">&nbsp;</a>
						</div>
						<div class="dl__m_hidden">
							<div><?=$json_output->Person->Label?></div>
							<div style="font-weight:normal; margin-bottom:5px;"><?=$json_output->Person->Title?></div>
							
							<ul class="">
								<li><a href="<?=$GalleryPageName."?person=".$json_output->Person->PersonId."&label=".$json_output->Person->Label?>">Galleries</a></li>
								<?php
								if($ReviewPageName!="" && $json_output->Person->TestimonialCount>1){
									?>
									<li><a href="<?=$ReviewPageName."?person=".$json_output->Person->PersonId."&label=".$json_output->Person->Label?>">Reviews</a></li>
									<?php
								}
								?>
							</ul>	
						</div>
					</div>
			</div>	
			<div class="dl__col dl__col--4-of-4 dl__subheading">
				Procedure Details
				<a class="dashicons dashicons-plus-alt dl__hideshow" href="#">&nbsp;</a> 

			</div>
			<div class="dl__col dl__col--4-of-4 dl__gallery_description dl__m_hidden">
				<?=$g->Description?>
			</div>

			<?php 
			foreach($json_output->Views as $v){
			?>
			<div class="dl__col dl__col--4-of-4 dl__subheading">
				<?=$v->Label?>
			</div>
			<div class="dl__col dl__col--4-of-4 dl__gallery_description">
				<?=$v->Description?>
			</div>
			<div class="dl__col dl__col--4-of-4 dl__galleryview">
				<figure class="dl__before">
					<img class="dl__modal dl__image" name="v<?=$v->ViewId?>1" href="#v<?=$v->ViewId?>1" src="<?=imagePath1($assetPath, $v)?>&w=538&deviceType=Desktop" />
					<div style="display:none" id="v<?=$v->ViewId?>1">
					<img src="<?=imagePath1($assetPath, $v)?>" />
					</div>					
					<figcaption><div class="dl__subheading"><?=$v->Image1Label?></div></figcaption>
				</figure>
				<figure class=" dl__after">
					<img class="dl__modal dl__image" name="v<?=$v->ViewId?>2" href="#v<?=$v->ViewId?>2" src="<?=imagePath2($assetPath, $v)?>&w=538&deviceType=Desktop" />
					<div style="display:none" id="v<?=$v->ViewId?>2">
					<img src="<?=imagePath2($assetPath, $v)?>" />
					</div>					
					<figcaption><div class="dl__subheading"><?=$v->Image2Label?></div></figcaption>
				</figure>
			</div>

			<?php
			}
			?>
			<div class="dl__col dl__col--4-of-4 dl__subheading">
				<?=$json_output->Blurbs[0]->Label?><a class="dashicons dashicons-plus-alt dl__hideshow" href="#">&nbsp;</a>
			</div>
			<div class="dl__col dl__col--4-of-4 dl__gallery_description dl__m_hidden">
				<?=$json_output->Blurbs[0]->Blurb?>
			</div>
        </div>
		<?php
		}
	}

?>