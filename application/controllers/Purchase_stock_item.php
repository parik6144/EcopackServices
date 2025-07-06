<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Purchase_stock_item extends CI_Controller
{
    function __construct()
    {

        parent::__construct();
        $data['title']="Item";
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        //$this->load->model('mdl_purchase_item');
        $this->load->model('mdl_purchase_item');
        $this->load->model('mdl_uom');
        //$this->load->model('mdl_tax');
        $this->load->model('Mdl_setting');

    }
    public function index()
    {
        $data['title']="Item";
        $this->load->view('purchase_item/purchase_item_details',$data);
    }
    public function add()
    {
        if(isset($_POST['item_name']))
        {
            $lastid=$this->mdl_purchase_item->saveitem($_POST);
            echo $lastid;
        }
        else
        {
            $data['title']="Add Item";
            $start="";
            $length="";
            $searchstr="";  
            $data['uom']=$this->mdl_uom->getuom("","","","","");         
            $this->load->view('purchase_item/add_purchase_item',$data);
        }
    }
   
    public function edit()
    {

        if(isset($_POST['item_name']))
        {
            return $this->mdl_purchase_item->updateitem($_POST);

        }
        else {
            $data['title'] = "Edit Item";
            $item_id = encryptor("decrypt", $this->input->get('id'));
            $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
            $data['form_data'] = $this->mdl_purchase_item->getitembyid($item_id);

            $this->load->view('item/edit_item', $data);
        }
    }

    public function addpopup()
    {
        $data['title']="Add Item";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $data['uom']=$this->mdl_uom->getuom("","","","","");         
        $this->load->view('purchase_item/add_purchase_item',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit Item";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $item_id = encryptor("decrypt", $this->input->get('id'));
        $data['uom']=$this->mdl_uom->getuom("","","","","");
        //$data['tax']=$this->mdl_tax->gettax("","","","","");
        $data['form_data'] = $this->mdl_purchase_item->getitembyid($item_id);
        $this->load->view('purchase_item/edit_purchase_item', $data);
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_purchase_item->getitem($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['item_code'];            
            $arr[]=$row['item_name'];            
            $arr[]=$row['short_name'];            
            $arr[]=$row['opening_stock'];                      
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['item_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['item_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function deleterecord(){
         $item_id = encryptor("decrypt", $this->input->post('delete'));
         
         $record=$this->mdl_purchase_item->deletebyid($item_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function getItemByConsigneeId()
    {
        if(isset($_POST['consignment_type'])&& $_POST['consignment_type']=="1")
        {
            $this->load->model('Mdl_rent_item');
            echo json_encode($this->Mdl_rent_item->getrentitemByConsignee($this->input->post('consignee_id')));
        }
        else
        {
            echo json_encode($this->mdl_purchase_item->getItemByConsignee($this->input->post('consignee_id')));
        }
    }
}
?>