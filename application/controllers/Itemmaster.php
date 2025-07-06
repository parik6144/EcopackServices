<?php

class Itemmaster extends CI_Controller
{
    function __construct()
    {

        parent::__construct();
        $data['title']="Item";
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        //$this->load->model('mdl_item');
        $this->load->model('Mdl_item_master');
        $this->load->model('Mdl_setting');
        
    }
    public function index()
    {
        $data['title']="Item";
        $this->load->view('item_master/item_master_details',$data);
    }
    public function add()
    {
        if(isset($_POST['item_name']))
        {
            $lastid=$this->Mdl_item_master->saveitem($_POST);
            echo $lastid;
        }
    }
   
    public function edit()
    {

        if(isset($_POST['item_name']))
        {
            return $this->Mdl_item_master->updateitem($_POST);

        }
        
    }

    public function addpopup()
    {
        $data['title']="Add Item";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $this->load->model('Mdl_warehouse');
        $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
        $this->load->view('item_master/add_item_master',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit Item";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $master_item_id = encryptor("decrypt", $this->input->get('id'));
        $this->load->model('Mdl_warehouse');
        $data['warehouse']=$this->Mdl_item_master->getwarehouse($master_item_id);
        //$data['tax']=$this->mdl_tax->gettax("","","","","");
        $data['form_data'] = $this->Mdl_item_master->getitembyid($master_item_id);
        $this->load->view('item_master/edit_item_master', $data);
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_item_master->getitem($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['item_name'];          
            $arr[]=$row['item_code']; 
            $arr[]=$row['price']; 
           
                                
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['master_item_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['master_item_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function deleterecord(){
         $master_item_id = encryptor("decrypt", $this->input->post('delete'));
         
         $record=$this->Mdl_item_master->deletebyid($master_item_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function getrentitemByConsigneeId()
    {
        echo json_encode($this->Mdl_item_master->getitem_masterByConsignee($this->input->post('consignee_id')));
    }
}
?>