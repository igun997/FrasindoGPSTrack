<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	public function index()
	{
		  redirect(base_url(),"refresh");
	}
    public function getData()
    {
        if($this->input->is_ajax_request())
        {
            // Get cURL resource
            $curl = curl_init();
            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://gps.id/engine/userspace.php?user=sandysal0882&session=4e78e7f4160a9a6e6219a25ce74283f3',
                CURLOPT_USERAGENT => 'Mozila/5.0'
            ));
            // Send the request & save response to $resp
            $resp = curl_exec($curl);
            echo "<script>".$resp."</script>";
            // Close request to clear up some resources
            curl_close($curl);// Get cURL resource
            $curl = curl_init();
            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://gps.id/engine/userpoi.php?user=sandysal0882&session=4e78e7f4160a9a6e6219a25ce7428',
                CURLOPT_USERAGENT => 'Mozila/5.0'
            ));
            // Send the request & save response to $resp
            $resp = curl_exec($curl);
            echo "<script>".$resp."</script>";
            // Close request to clear up some resources
            curl_close($curl);
        }else{
            show_404();
        }
    }
    public function getAddr($lat,$long)
    {
        if($this->input->is_ajax_request())
        {
            // Get cURL resource
            $curl = curl_init();
            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://api.geonames.org/findNearbyJSON?formatted=true&lat='.$lat.'&lng='.$long.'&username=igun997&style=full',
                CURLOPT_USERAGENT => 'Mozila/5.0'
            ));
            // Send the request & save response to $resp
            $resp = curl_exec($curl);
            $data = json_decode($resp);
            echo json_encode(array("nama"=>$data->geonames[0]->toponymName,"kota"=>$data->geonames[0]->adminName1));
            // Close request to clear up some resources
            curl_close($curl);
        }else{
            show_404();
        }
    }
    public function getDetailInfo()
    {
        // Get cURL resource
            $curl = curl_init();
            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://gps.id/engine/GPS.php',
                CURLOPT_USERAGENT => 'Mozila/5.0',
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => "MfcISAPICommand=Getdata&data=".urldecode("<ROOT><USERID></USERID><CMDTYPE>CM_LOGIN</CMDTYPE
><PARADATA><USERNAME>sandysal0882</USERNAME><PASSWORD>S1ngapore</PASSWORD>
</PARADATA></ROOT>")

            ));
            // Send the request & save response to $resp
            $resp = curl_exec($curl);
            $xml = simplexml_load_string($resp);
            $json = json_encode($xml);
            echo $json;
            // Close request to clear up some resources
            curl_close($curl);// Get cURL resource
    
    }
    public function getTrack($teuid,$start,$end)
    {
        $cookiefile = '_storedSession';
        $url = 'http://gps.id/main.php';

        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, 'http://gps.id/engine/GPS.php');
        $data = "<ROOT><USERID>sandysal0882</USERID><CMDTYPE>CM_QUERY_GPSDATABYCONDITION</CMDTYPE><PARADATA><TEUID>".$teuid."</TEUID><CONDITION>0</CONDITION><STARTTIME>".$start."</STARTTIME><ENDTIME>".$end."</ENDTIME></PARADATA></ROOT>: undefined";
        curl_setopt($ch, CURLOPT_POSTFIELDS, "MfcISAPICommand=Getdata&data=".urlencode($data));
        $output = curl_exec($ch);
        $xml = simplexml_load_string($output);
        echo json_encode($xml);
            
       
    }
    public function getStatus($teuid)
    {
        $cookiefile = '_storedSession';
        $url = 'http://gps.id/main.php';

        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, 'http://gps.id/engine/GPS.php');
        $data = "<ROOT><USERID>sandysal0882</USERID><CMDTYPE>CM_QUERY_GPSDATA</CMDTYPE><PARADATA><TEUID>".$teuid."</TEUID></PARADATA></ROOT>";
        curl_setopt($ch, CURLOPT_POSTFIELDS, "MfcISAPICommand=Getdata&data=".urlencode($data));
        $output = curl_exec($ch);
        $xml = simplexml_load_string($output);
        echo json_encode($xml);
            
       
    }
}
