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
}
