<?php
class Item_wise_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Item Wise Report";
        $this->load->model('Mdl_setting');
        
    }
    public function index()
    {
        $data['title']="Item Wise Report";
        $this->load->model('Mdl_item_master');
        $data['item']=$this->Mdl_item_master->getitem("","","","","");
        $this->load->view('item_wise_report/item_wise_report_form',$data);
    }
    
    public function getreport(){
        
        $this->load->model('Mdl_stock');
        $data['form_data']=$this->Mdl_stock->getItemWiseReport();
        $this->load->model('Mdl_warehouse');
        $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
        $data['title'] = "Stock Report";
        $this->load->view('item_wise_report/display_item_wise_stock_report',$data);
    }
}
?>