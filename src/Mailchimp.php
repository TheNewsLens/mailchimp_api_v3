<?php

namespace Mailchimp;


class Mailchimp
{
    private $server = 'us1.';

    private $apikey;

    public function __construct($apikey = '')
    {
        $this->apikey = $apikey;
        
    }

    function subscribe( $listid, $data) {
        $data['apikey'] = $this->apikey;
dd($data);

print_r($data);
exit();
        return $this->getdatabycurl($data,$listid);
    }

    function checksub($listid, $data) {
        $data['apikey'] = $this->apikey;

        return $this->getdatabycurl($data,$listid,'GET',false);
    }

    function editsub($listid, $data) {
        $data['apikey'] = $this->apikey;

        return $this->getdatabycurl($data,$listid,'PATCH',false);
    }


    private function getdatabycurl($data,$listid,$met='',$new=true){
        $auth = base64_encode( 'user:'.$this->apikey );
        $userid = $new ? '' : md5($data['email_address']);
        $json_data = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://'.$this->server.'api.mailchimp.com/3.0/lists/'.$listid.'/members/'.$userid);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.$auth));
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        if($met!='') curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $met);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
