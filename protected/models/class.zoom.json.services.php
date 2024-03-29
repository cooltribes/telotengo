<?php

// **************************************************************************************
// (c) 2011 - Carlos De Oliveira - Zoom International Services C.A. - cardeol@gmail.com
// **************************************************************************************

// Implementacion del objeto proxy (PHP4)

class ZoomJsonService {
    var $URL;
	
    function ZoomJsonService($url)
    {
        $this->URL = $url;
    }
	
	function setUrl($url) {
		$this->URL = $url;	
	}
	
    function call($method, $args, $successCallback = false, $errorCallback = false)
    {
        $ch = curl_init();		
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_URL, $this->URL."/".$method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
        $resposeText = curl_exec($ch);
        $resposeInfo = curl_getinfo($ch);
        //return json_decode($resposeInfo);
        if($resposeInfo["http_code"] == 200)
        {
            return json_decode($resposeText);
                
        }
        else
        {
            return NULL;
        }
    }
}
?>