<?php
class Other_item_stock extends CI_Controller
{
	public function __construct()
	{
		parent ::__construct();
		if($this->session->userData('user_id')=='')
			redirect(base_url(),'refresh');
		else
		{
			$this->load->model('Mdl_consignee');
			$this->load->model('Mdl_other_item');
		}
		$this->load->model('Mdl_setting');
	}
	
	public function index()
	{
		$data = array();
		$data['title']='Other Item Stock';
		$data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
		$this->load->view('other_item_stock/other_item_stock_form',$data);
	}

	public function add()
	{
		$this->Mdl_other_item->savestock();
	}
}
?>