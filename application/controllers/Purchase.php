<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Purchase extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $data['title']="Account";
        $this->load->model('mdl_account');
        $this->load->model('mdl_tax');
        $this->load->model('mdl_purchase');
        $this->load->model('Mdl_setting');

    }
    public function index()
    {
        $data['title']="Purchase";
        $this->load->view('purchase/purchase_details',$data);
    }
    public function add()
    {
        
        if(isset($_POST['account_name']))
        {
            $this->mdl_account->saveaccount($_POST);
        }
        else
        {
            $data['title']="Create Purchase";
            $data['tax']=$this->mdl_tax->gettaxfordisplay();
            $this->load->view('purchase/add_purchase',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['account_name']))
        {
            $this->mdl_account->updateaccount($_POST);
            
        }
        else {
            $data['title'] = "Edit Accounts";
            $account_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->mdl_account->getaccountbyid($account_id);
            $data['country'] = $this->mdl_account->getcountry();
            $this->load->view('account/edit_account', $data);
        }
    }
    public function getstate()
    {
        $countryid=$this->input->post('countryid');
        $data=$this->mdl_account->getstate($countryid);
        echo json_encode($data);
    }
    public function getcity()
    {
        $stateid=$this->input->post('stateid');
        $data=$this->mdl_account->getcity($stateid);
        echo json_encode($data);
    }
    public function addpopup()
    {
        $data['title']="Add Purchase";
        $data['country']=$this->mdl_account->getcountry();
        $data['condition']='popup';
        $this->load->view('purchase/add_purchase',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit Accounts";
        $data['condition']='popup';
        $account_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->mdl_account->getaccountbyid($account_id);
        $data['country'] = $this->mdl_account->getcountry();
        $this->load->view('account/edit_account', $data);
    }
    public function getrecord()
    {
         //invoice_date,`account_name`, `purchase_id`, `other_charge`, `total_amount`, `bill_discount`,grand_total,purchase_id'


        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_purchase->getpurchase($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['purchase_no'];
            $arr[]=date("d-m-Y", strtotime($row['purchase_date']));
            $arr[]=$row['account_name'];
            //$arr[]=$row['other_charge'];
            $arr[]= $row['total_amount'];
            $arr[]=$row['bill_discount'];
            $arr[]=$row['grand_total'];
            $arr[]="<div class='col-sm-6'><a href='".base_url()."purchase/edit?id=".encryptor("encrypt",$row['purchase_id'])."' refid='".encryptor("encrypt",$row['purchase_id'])."' class='btn_editrecord' target='_blank'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='".base_url()."purchase/printpurchase?id=".encryptor("encrypt",$row['purchase_id'])."' refid='".encryptor("encrypt",$row['purchase_id'])."' class='btn_deleterecord' target='_blank'><i class='fa fa-print'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    public function savepurchase()
    {
        //var_dump($_POST);
        $this->mdl_purchase->savepurchase($_POST);
        exit;
    }
    public function printpurchase()
    {
        $purchase=encryptor("decrypt",$this->input->get('id'));
        $data['title']="Print Purchase Invoice";
        $data['item']=$this->mdl_purchase->getprintpurchase($purchase);
        $data['item_details']=$this->mdl_purchase->getitem($purchase);
        $this->load->view('purchase/printpurchase',$data);
        //print_r($data);
    }

}
?>