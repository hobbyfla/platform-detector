<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detect extends CI_Controller {

	/**
	* Development - Flavio Nunes
	*/
	public function index()
	{
		$this->load->library('user_agent');

		if ($this->agent->is_browser())
		{
		        $agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
		        $agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
		        $agent = $this->agent->mobile();
		}
		else
		{
		        $agent = 'Unidentified User Agent';
		}
		$data = array(
				'agent' => $agent,
				'info'  => $this->agent->platform(),
		);
		if($this->agent->is_mobile() && $this->agent->platform() == 'Symbian'){
			$this->load->view('detect-old', $data);
		} else {
			$this->load->view('detect', $data);
		}
	}
}
