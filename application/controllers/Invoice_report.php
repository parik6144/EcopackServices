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

    public function getInvoiceByConsignee()
    {
        if(isset($_POST['consignee_billing_id']))
        {
            $consignee_billing_id=$_POST['consignee_billing_id'];
            $date_from=date("Y-m-d", strtotime($_POST['date_from']));
            $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        }
        else
        {
            $consignee_billing_id="all";
            $date_from=date('01-m-d');
            $date_to=date('Y-m-d');
        }

        $this->db->select('tbl_invoice.invoice_id, `invoice_no`, `invoice_date`, `consignee_name`,consignee_billing_name, `total_tax`, `invoice_total`, `round_off`, `invoice_type_id`,category_name,tbl_consignee_billing.gstin,sum(gst_amount) as gst_amount,gst_rate');

        $this->db->from('tbl_invoice');
        $this->db ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_invoice.consignee_id', 'left');
        $this->db ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_invoice.billing_address_id', 'left');
        $this->db ->join('invoice_details', 'invoice_details.invoice_id = tbl_invoice.invoice_id', 'left');
        $this->db->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_invoice.invoice_type_id', 'left');
        $this->db->where('invoice_date >=',$date_from);
        $this->db->where('invoice_date <=',$date_to);
        if($consignee_billing_id!="all")
            $this->db->where('tbl_invoice.billing_address_id',$consignee_billing_id);
        $this->db->order_by('tbl_invoice.invoice_id','asc');
        $this->db->group_by('invoice_id');
        $query=$this->db->get();
        $response=$query->result_array();
        //echo $this->db->last_query();
        //exit;
        return $response;
    }
    
    // public function getreport(){
    //     $this->load->model('Mdl_invoice');
    //     $data['form_data']=$this->Mdl_invoice->getInvoiceByConsignee();
    //     $data['title'] = "invoice Report";
    //     $invoice_type_id = $data['form_data'][0]['invoice_type_id'];
    //     $data['tax_details'] = $this->Mdl_invoice->getTaxDetails($invoice_type_id);
    //     //echo "<pre>"; print_r($data['tax_details']); exit();
    //     $this->load->view('invoice_report/display_invoice_report',$data);
    // }
    
     public function getreport(){
        $this->load->model('Mdl_invoice');
        $data['form_data'] = $this->Mdl_invoice->getInvoiceByConsignee();
        $data['title'] = "Invoice Report";

        // Loop through each invoice and calculate CGST, SGST, IGST rates and amounts
        foreach ($data['form_data'] as &$invoice) {
            $state_code = $invoice['state_code'];
            $gst_rate = $invoice['gst_rate'];
            $gst_amount = $invoice['gst_amount']; // Fetching GST amount from the invoice

            // Initialize CGST, SGST, IGST rates and amounts
            $cgst_rate = 0;
            $sgst_rate = 0;
            $igst_rate = 0;
            $cgst_amount = 0;
            $sgst_amount = 0;
            $igst_amount = 0;

            if ($state_code == 20) { // If state code is 20
                // Calculate CGST and SGST rates
                $cgst_rate = $sgst_rate = $gst_rate / 2;

                // Calculate CGST and SGST amounts
                $cgst_amount = $sgst_amount = ($gst_amount) / 2;
            } else {
                // Calculate IGST rate and amount
                $igst_rate = $gst_rate;
                $igst_amount = ($gst_amount);
            }

            // Update the invoice array with the calculated values
            $invoice['cgst_rate'] = $cgst_rate;
            $invoice['sgst_rate'] = $sgst_rate;
            $invoice['igst_rate'] = $igst_rate;
            $invoice['cgst_amount'] = $cgst_amount;
            $invoice['sgst_amount'] = $sgst_amount;
            $invoice['igst_amount'] = $igst_amount;
        }

        // Printing form_data for debugging
        // echo "<pre>"; print_r($data); exit();

        // Load the view with the updated data
        $this->load->view('invoice_report/display_invoice_report', $data);
    }
}
?>