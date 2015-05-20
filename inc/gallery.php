<?php
function DoctorLogicGallery($args, $instance) {

		$GalleryPageName = get_option('dl_gallery_path');
		$API = get_option('dl_api');

        $procedure="";
		$galleryid = $_GET[galleryid];
        $label = $_GET[label];
        $personnel =$_GET[personnelid];
        $facility = $_GET[facilityid];
        $category = $_GET[categoryid];
		$procedure .= $_GET[procedureid];
        $rating = $_GET[rating];
        $testimonialsource = $_GET[source];
        $sort = $_GET[sort];
		$apiurl = $API."/gallery/listcomponent";
        
		if($personnel!=""){$apiurl.="?personnelid=" . $personnel; }
        if($facility!=""){$apiurl.="?facilityid=" . $facility; }
		if($category!=""){$apiurl.="?categoryid=" . $category; }
        if($procedure!=""){$apiurl.="?procedureid=" . $procedure; }
        if($galleryid!=""){$apiurl.="?galleryid=" . $galleryid; }

        $json = file_get_contents($apiurl);
        $json_output = json_decode($json);
        $filingName = $json_output->MasterPage->SiteInfo->FilingName;
        $assetPath = "//assets.doctorlogicsites.com/Images/Sites/" . substr($filingName, 0, 1) . "/" . $filingName ."/Gallery/";

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
								<a href="<?php echo $GalleryPageName."?categoryid=".$search->CategoryId."&label=".$search->Label?>">
									<?php echo  $search->Label ." (".$search->GalleryCount.")"?>
								</a>
							</div>
							<ul class="dl__ul">
							<?php
						} else 
						{
							?>
								<a href="<?php echo $GalleryPageName."?procedureid=".$search->ProcedureId."&label=".$search->Label?>">
							<li>
								<?php echo  $search->Label ." (".$search->GalleryCount.")" ?>
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
                		<a href="/<?=$GalleryPageName?>"><span class="dl__no-wrap">&nbsp;(See All Galleries)</span></a>
						<?php
                    }
					?>
                    </div>
					<?php
	        		foreach ($json_output->GalleryGroups as $group) {
						$thisGroup=$group;
						if($procedure==""){
						?>
							<div class="dl__col dl__col--2-of-2 dl__heading">
								<?php echo count($group->Galleries)?> Result<?=(count($group->Galleries)==1?"":"s")?> for <?=$group->Galleries[0]->CategoryLabel?>
							</div>
						<?php
						}
						$previousProcedure=0;
						foreach ($group->Galleries as $g) 
						{
							if($g->ProcedureId!=$previousProcedure){
							?>
							<div class="dl__col dl__col--2-of-2 dl__subheading">
								<?=count($thisGroup->Galleries)?> Result<?=(count($thisGroup->Galleries)==1?"":"s")?> for <?=$g->ProcedureLabel?>
							</div>
							<?php
							}
							?>
							
							<div class="dl__grid dl__gallery_result_row">
								<div class="dl__col  dl__col--2-of-4">
									<img class="dl__gallery_list_image" src="<?php echo $assetPath.$g->PrimaryViewId?>/1.jpg?format=jpg&crop=(0,0,3648,2736)&w=400&deviceType=Desktop" alt="Before" />
									<img class="dl__gallery_list_image" src="<?php echo $assetPath.$g->PrimaryViewId?>/2.jpg?format=jpg&crop=(0,0,3648,2736)&w=400&deviceType=Desktop" alt="Before" />
								</div>
								<div class="dl__col dl__col--2-of-4">
									<div class="dl__grid">
										<div class="dl__col dl__col--2-of-2 dl__procedurelabel"><?php echo $g->ProcedureLabel?> <a href="<?php echo "/".$GalleryPageName."?galleryid=".$g->GalleryId?>" class="dl__buttonlink dl__buttonnarrow">View</a></div>
											<div class="dl__col dl__col--1-of-2 " >
												<dl class="table">
												<span>
												<dt>Age: </dt>
												<dl><?php echo $g->AgeLabel?></dl>
												</span>
												<span>
												<dt>Gender: </dt>
												<dl><?php echo $g->GenderLabel?></dl>
												</span>
												<span>
												<dt>Ethnicity: </dt>
												<dl><?php echo $g->EthnicityLabel?></dl>
												</span>
												</dl>
											</div>
											<div class="dl__col dl__col--1-of-2 " >
												<dl class="table">
												<span>
												<dt>Height: </dt>
												<dl><?php echo $g->HeightLabel?></dl>
												</span>
												<span>
												<dt>Weight: </dt>
												<dl><?php echo $g->WeightLabel?></dl>
												</span>
												<span>
												<dt>Gallery: </dt>
												<dl><?php echo $g->GalleryId?></dl>
												</span>
												</dl>
											</div>
										<div class="dl__col  dl__col--2-of-2 "><a class="dl__buttonlink dl__buttonwide" href="/<?php echo $GalleryPageName."?galleryid=".$g->GalleryId?>">View</a></div>
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
		?>
			<div>Gallery Item Page Goes Here</div>
		<?php
		}
	}
?>