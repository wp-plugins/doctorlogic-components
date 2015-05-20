<?php

function dl__palette(){
	$dl_css=get_option('dl_css');
	$s = "<style type=\"text/css\">";
        $s.= "/*These styles are configured through the DoctorLogic WordPress plugin under the 'Advanced Styles'  menu*/";
        $s.= ".dl__grid .dl__heading{".$dl_css['heading']."}";
		$s.= ".dl__grid .dl__heading a, .dl__grid .dl__heading a:visited{".$dl_css['heading a']."}";
		$s.= ".dl__grid .dl__heading a:hover{".$dl_css['heading a:hover']."}";

        $s.= ".dl__grid .dl__subheading{".$dl_css['subheading']."}";
		$s.= ".dl__grid .dl__subheading a, .dl__grid .dl__subheading a:visited{".$dl_css['subheading a']."}";
		$s.= ".dl__grid .dl__subheading a:hover{".$dl_css['subheading a:hover']."}";

        $s.= ".dl__grid .dl__filter{".$dl_css['filter']."}";
		$s.= ".dl__grid .dl__filter a, .dl__grid .dl__filter a:visited{".$dl_css['filter a']."}";
		$s.= ".dl__filter a:hover{".$dl_css['filter a:hover']."}";

        $s.= ".dl__grid .dl__review_result_row{".$dl_css['review result row']."}";
		$s.= ".dl__grid .dl__review_result_row a, .dl__grid .dl__review_result_row a:visited{".$dl_css['review result row a']."}";
		$s.= ".dl__grid .dl__review_result_row a:hover{".$dl_css['review result row hover']."}";
		
		$s.= ".dl__grid .dl__gallery_result_row{".$dl_css['gallery result row']."}";
		$s.= ".dl__grid .dl__gallery_result_row a, .dl__grid .dl__gallery_result_row a:visited{".$dl_css['gallery result row a']."}";
		$s.= ".dl__grid .dl__gallery_result_row a:hover{".$dl_css['gallery result row a:hover']."}";
		
		$s.= ".dl__grid .dl__review_summary{".$dl_css['review-summary']."}";
		$s.= ".dl__grid .dl__review_summary a, .dl__grid .dl__review_summary a:visited{".$dl_css['review-summary a']."}";
		$s.= ".dl__grid .dl__review_summary a:hover{".$dl_css['review-summary a:hover']."}";
		
		$s.= ".dl__grid .dl__gallery_summary{".$dl_css['gallery-summary']."}";
		$s.= ".dl__grid .dl__gallery_summary a, .dl__grid .dl__gallery_summary a:visited{".$dl_css['gallery-summary a']."}";
		$s.= ".dl__grid .dl__gallery_summary a:hover{".$dl_css['gallery-summary a:hover']."}";
		
		
		$s.= ".dl__grid .dl__star{".$dl_css['star']."}";
		$s.= ".dl__grid .dl__star a, .dl__grid .dl__star a:visited{".$dl_css['star a']."}";
		$s.= ".dl__grid .dl__star a:hover{".$dl_css['star a:hover']."}";
		
		$s.=$dl_css['dl__adhoc'];
	$s.= "</style>";

return $s;
}
dl__palette();

?>
