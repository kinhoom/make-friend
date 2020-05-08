<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
*/

class templateSms {
    
    private $accessToken;
    private $url;
    
    public function __construct($accessToken,$url) {
        $this->accessToken = trim($accessToken);
        $this->url = trim($url);
    }
    
    public function sendSmsTm20702951($openId,$templateId,$data = array(),$url=''){
        
        $openId = trim($openId);
        $templateId = trim($templateId);
        $data = $this->arrayToUtf8($data);
        $url = trim($url);
        if(!empty($url)){
            $this->url = $url;
        }
        
        $templateData = <<<EOF
        {
           "touser":"{$openId}",
           "template_id":"{$templateId}",
           "url":"{$this->url}",
           "topcolor":"#FF0000",
           "data":{
                   "first": {
                       "value":"{$data['first']}",
                       "color":"#173177"
                   },
                   "keyword1": {
                       "value":"{$data['keyword1']}",
                       "color":"#173177"
                   },
                   "keyword2": {
                       "value":"{$data['keyword2']}",
                       "color":"#173177"
                   },
                   "remark": {
                       "value":"{$data['remark']}",
                       "color":"#173177"
                   }
           }
       }
EOF;
                       
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->accessToken;
        
        $response = $this->postDataCurl($templateData, $url);
        
        $returnData = json_decode($response,true);
        
        if(isset($returnData['errmsg']) && $returnData['errmsg'] == 'ok'){
            return true;
        }else{
            return false;
        }
        
    }
    
    public function arrayToUtf8($data = array()){
        $outArr = array();
        foreach ($data as $key => $value){
            $outArr[$key] = diconv($value,CHARSET,'utf-8');
        }
        return $outArr;
    }

    public function postDataCurl($data, $url){
        
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$return = curl_exec($ch);
		if($return){
			curl_close($ch);
			return $return;
		} else { 
			$error = curl_errno($ch);
			curl_close($ch);
			return false;
		}
	}
}