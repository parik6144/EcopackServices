<?php
class Invoice_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        /*if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');*/
        $data['title']="invoice Report";
        $this->load->model('Mdl_setting');   
    }
    public function index()
    {
        $this->load->model('Mdl_consignee_billing');
        $data['title']="Invoice Report";
        $data['consignee']=$this->Mdl_consignee_billing->getconsignee_billing("","","","","");
        $this->load->view('invoice_report/invoice_report_form',$data);
    }
    
    public function getreport(){
        $this->load->model('Mdl_invoice');
        $data['form_data']=$this->Mdl_invoice->getInvoiceByConsignee();
        $data['title'] = "invoice Report";
        $this->load->view('invoice_report/display_invoice_report',$data);
    }
}
?>