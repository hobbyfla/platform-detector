<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detect extends CI_Controller {

	/**
	* Development - Flavio Nunes
	*/
	public function index()
	{
		$this->load->library('user_agent');

    if (($found = file_exists(APPPATH.'config/user_agents.php'))) {
        include(APPPATH.'config/user_agents.php');
    }
    if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/user_agents.php')) {
        include(APPPATH.'config/'.ENVIRONMENT.'/user_agents.php');
    }

		if ($this->agent->is_browser())		{
		        $agent = $this->agent->browser().' '.$this->agent->version();
			
		} elseif ($this->agent->is_robot())		{
		        $agent = $this->agent->robot();
			
		}	elseif ($this->agent->is_tablet())	{
		        $agent = $this->agent->tablet().' '.$this->agent->version();
			
		} elseif ($this->agent->is_mobile()) {
		        $agent = $this->agent->mobile().' '.$this->agent->version();
			
		}	else	{
		        $agent = 'Unidentified User Agent';
		}
		
		$data = array(
				'agent' => $agent,
				'platform'  => $this->agent->platform(),
				'browser'		=> $this->agent->browser(),
		);
		
		if($this->agent->is_mobile() && $this->agent->platform() == 'Symbian' && $this->agent->has_small_screen()){
			$data['type'] = 0; // simple page without javascript and video ( Old Phne - Nokia )
			$data['model'] = $this->agent->mobile().'- Symbian';
			
		} elseif($this->agent->is_mobile() && $this->agent->platform() == 'BlackBerry' && $this->agent->has_small_screen()) {
			$data['type'] = 0; // simple page without javascript and video ( Old Phne )
			$data['model'] = 'BackBerry';			
			
		} elseif($this->agent->is_mobile() && $this->agent->mobile() == 'BlackBerry' && $this->agent->platform() == 'Android' 
						 && $this->agent->has_small_screen()) {
			$data['type'] = 1; // simple page without javascript and video ( New Blackberry Phone with Android )
			$data['model'] = 'BackBerry';
						
		} elseif($this->agent->is_mobile() && $this->agent->has_small_screen() && $this->agent->platform() != 'Android'
						 && $this->agent->platform() != 'iOS' && $this->agent->platform() != 'Windows Phone' ) {
			$data['type'] = 0; // simple page without javascript and video ( Old Phne )
			$data['model'] = $this->agent->mobile();
			
		} elseif($this->agent->is_mobile() && $this->agent->has_small_screen()) {
			$data['type'] = 1; // Complete page with javascript and video ( Smart Phone - Windows Phone - Andoird - iOS )
			$data['model'] = $this->agent->mobile().' - '.$this->agent->browser();
			
		} elseif($this->agent->is_tablet() && $this->agent->platform() == 'Android') {
			$data['type'] = 1; // Complete page with javascript and video ( Tablet Android )
			$data['model'] = 'Tablet - Android';
			
		} elseif($this->agent->is_tablet() && $this->agent->platform() == 'iOS') {
			$data['type'] = 1; // Complete page with javascript and video  ( Tablet iOS )
			$data['model'] = 'Ipad - iOS';
			
		} elseif($this->agent->is_tablet() && $this->agent->platform() == 'Windows') {
			$data['type'] = 1; // Complete page with javascript and video  ( Tablet Windows )
			$data['model'] = 'Windows - Tablet';
			
		} elseif($this->agent->is_tablet()) {
			$data['type'] = 1; // Complete page with javascript and video  ( Tablet with others platforms )
			$data['model'] = 'Tablet - '.$this->agent->platform();
		
		} elseif(!$this->agent->is_tablet() && !$this->agent->is_mobile() && $this->agent->has_large_screen()) {
			$data['type'] = 1; // Complete page with javascript and video 
			$data['model'] = $this->agent->platform().' - '.$this->agent->browser(); // Browser in desktop  or notebook Large Screen above 640px
			
		} elseif(!$this->agent->is_tablet() && !$this->agent->is_mobile() && $this->agent->has_small_screen()) {
			$data['type'] = 1; // Complete page with javascript and video 
			$data['model'] = $this->agent->platform().' - '.$this->agent->browser(); // Browser in desktop  or notebook Small Screen below 640px
			
		} else {
			$data['type'] = 1; // Complete page with javascript and video 
			$data['model'] = 'Undefined Model'; // no model defined - show complete page

		}
		
		if($data['type'] == 0)
			$this->load->view('detect-old', $data);
		else
			$this->load->view('detect', $data);
		
	}
}
