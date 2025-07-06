<?php
class Warehouse_wise_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Warehouse Wise Report";
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Warehouse Wise Report";
        $this->load->model('Mdl_warehouse');
        $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
        $this->load->view('warehouse_wise_report/warehouse_wise_report_form',$data);
    }
    
    public function getreport(){
        
        $this->load->model('Mdl_stock');
        $data['form_data']=$this->Mdl_stock->getWarehouseWiseReport();
        $data['title'] = "Stock Report";
        $this->load->view('warehouse_wise_report/display_warehouse_wise_stock_report',$data);
    }
}
?>