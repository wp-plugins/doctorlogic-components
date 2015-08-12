<?php

function dl__palette(){
	$dl_css=get_option('dl_css');
	$s = "<style type=\"text/css\">";
        $s.= "/*These styles are configured through the DoctorLogic WordPress plugin under the 'Advanced Styles'  menu*/\r\n";


if(isset($dl_foo->a)){


	foreach($dl_css as $key => $value)
	{

		if($value!=""){$s.=".dl__grid .dl__".$key."{".$value."}\r\n";}
	}

        $s.= "/*End of DoctroLogic 'Advanced Styles'*/\r\n";
		$s.= "</style>";

	return $s;
	}
}

dl__palette();

?>