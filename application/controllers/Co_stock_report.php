<?php
class Co_stock_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Co. Wise Stock Report";
        $this->load->model('Mdl_consignee');
        $this->load->model('Mdl_stock');
        $this->load->model('Mdl_setting');

    }
    public function index()
    {
        $data['title']="Stock Report";
        $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
        $this->load->view('co_stock_report/co_stock_report_form',$data);
    }
    
    public function getreport(){
        
        $data['form_data']=$this->Mdl_stock->getCoWiseStock();
        $this->load->model('Mdl_warehouse');
        $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
        $data['title'] = "Stock Report";
        $this->load->view('co_stock_report/display_co_stock_report',$data);
    }
}
?>