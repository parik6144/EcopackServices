<?php
class Stock_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Consigment";
        $this->load->model('Mdl_consignee');
        $this->load->model('Mdl_stock');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Stock Report";
        $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
        $this->load->view('stock_report/stock_report_form',$data);
    }
    
    public function getreport(){
        if($_POST['consignor_type']=="0")
            $data['form_data']=$this->Mdl_stock->getstockbyconsignee();
        else
            $data['form_data']=$this->Mdl_stock->getrentstockbyconsignee();
        $data['title'] = "Stock Report";
        if($_POST['consignee_name']=="11")
        {
            $this->load->view('stock_report/display_stock_report_paragon',$data);
        }
        else if($_POST['consignee_name']=="37")
        {
            $this->load->view('stock_report/display_stock_report_aztech_tata_toyo_radiator',$data);
        }
        else if($_POST['consignee_name']=="43")
        {
            $this->load->view('stock_report/display_cm_smith_stock_report',$data);
        }
        else{
            if($_POST['consignor_type']=="0")
                $this->load->view('stock_report/display_stock_report',$data);
            else
                $this->load->view('stock_report/display_rent_stock_report',$data);
        }
    }
}
?>