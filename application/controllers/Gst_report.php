<?php
class Gst_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        /*if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');*/
        $data['title']="GST Report";
        $this->load->model('Mdl_setting');
        
    }
    public function index()
    {
        $data['title'] = "GST Report Form";
        $this->load->view('gst_report/gst_report_form',$data);
    }
    
    public function getreport(){
        $this->load->model('Mdl_invoice');
        $data['form_data']=$this->Mdl_invoice->getgst();
        $data['title'] = "invoice Report";
        $this->load->view('gst_report/gst_report',$data);
    }
}
?>