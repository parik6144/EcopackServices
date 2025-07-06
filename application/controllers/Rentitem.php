<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Rentitem extends CI_Controller
{
    function __construct()
    {

        parent::__construct();
        $data['title']="Item";
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        //$this->load->model('mdl_item');
        $this->load->model('mdl_rent_item');
        $this->load->model('mdl_consignee');
        //$this->load->model('mdl_tax');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Item";
        $this->load->view('rent_item/rent_item_details',$data);
    }
    public function add()
    {
        if(isset($_POST['rent_item_name']))
        {
            $lastid=$this->mdl_rent_item->saverentitem($_POST);
            echo $lastid;
        }
        else
        {
            $data['title']="Add Item";
            $start="";
            $length="";
            $searchstr="";  
            $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");         
            $this->load->view('rent_item/add_rent_item',$data);
        }
    }
   
    public function edit()
    {

        if(isset($_POST['rent_item_name']))
        {
            return $this->mdl_rent_item->updaterentitem($_POST);

        }
        else {
            $data['title'] = "Edit Item";
            $rent_item_id = encryptor("decrypt", $this->input->get('id'));
            $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
            $data['form_data'] = $this->mdl_rent_item->getrentitembyid($rent_item_id);

            $this->load->view('rent_item/edit_rent_item', $data);
        }
    }

    public function addpopup()
    {
        $data['title']="Add Item";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
        //$data['tax']=$this->mdl_tax->gettax("","","","","");
        $this->load->view('rent_item/add_rent_item',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit Item";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $rent_item_id = encryptor("decrypt", $this->input->get('id'));
        $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
        //$data['tax']=$this->mdl_tax->gettax("","","","","");
        $data['form_data'] = $this->mdl_rent_item->getrentitembyid($rent_item_id);
        $this->load->view('rent_item/edit_rent_item', $data);
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_rent_item->getrentitem($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['rent_item_name'];            
            $arr[]=$row['consignee_name'];            
            $arr[]=$row['price']; 
            if($row['rent_type']=="0")                     
                $arr[]="Per Consignment";
            else
                $arr[]="Per month";  
            $arr[]=$row['opening_stock'];                    
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['rent_item_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['rent_item_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function deleterecord(){
         $rent_item_id = encryptor("decrypt", $this->input->post('delete'));
         
         $record=$this->mdl_rent_item->deletebyid($rent_item_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function getrentitemByConsigneeId()
    {
        echo json_encode($this->mdl_rent_item->getrent_itemByConsignee($this->input->post('consignee_id')));
    }
}
?>