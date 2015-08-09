<?php
	function imagepath1($assetPath, $v){
		if ($v->MediaUrl1==""){
			if (property_exists($v, 'PrimaryViewId')){
				$v->ViewId=$v->PrimaryViewId;
			}
			return $assetPath.'/Gallery/'.$v->ViewId.'/1.jpg?format=jpg&'.crop1($v);
		}
		else{
			return $assetPath.$v->MediaUrl1.'?format=jpg&'.crop1($v);
		}
	}
	function imagepath2($assetPath, $v){
		if ($v->MediaUrl2==""){
			if (property_exists($v, 'PrimaryViewId')){
				$v->ViewId=$v->PrimaryViewId;
			}
			return $assetPath.'/Gallery/'.$v->ViewId.'/2.jpg?format=jpg&'.crop2($v);
		}
		else{
			return $assetPath.$v->MediaUrl2.'?format=jpg&'.crop2($v);
		}
	}
	function crop1($obj){
		$s = "crop=(";
		$s.=$obj->Image1X1.",";
		$s.=$obj->Image1Y1.",";
		$s.=$obj->Image1X2.",";
		$s.=$obj->Image1Y2.")";
		return $s;
	}
		function crop2($obj){
		$s = "crop=(";
		$s.=$obj->Image2X1.",";
		$s.=$obj->Image2Y1.",";
		$s.=$obj->Image2X2.",";
		$s.=$obj->Image2Y2.")";
		return $s;
	}

?>