<?php

class SalesItem extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $data['title']="Item";
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $this->load->model('mdl_salesitem');
    }
    
    public function index()
    {
        $data['title']="Sales Item";
        $this->load->view('salesitem/item_details',$data);
    }
    
    public function add()
    {
        if(isset($_POST['item_name']))
        {
            $lastid=$this->mdl_item->saveitem($_POST);
            echo $lastid;
        }
        else
        {
            $data['title']="Add Item";
            $start="";
            $length="";
            $searchstr="";  
            $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");         
            $this->load->view('salesitem/add_item',$data);
        }
    }
   
    public function edit()
    {

        if(isset($_POST['item_name']))
        {
            return $this->mdl_item->updateitem($_POST);
        }
        else {
            $data['title'] = "Edit Item";
            $item_id = encryptor("decrypt", $this->input->get('id'));
            $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
            $data['form_data'] = $this->mdl_item->getitembyid($item_id);

            $this->load->view('salesitem/edit_item', $data);
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
        $this->load->view('salesitem/add_item',$data);
    }

    public function editpopup()
    {
        $data['title'] = "Edit Item";
        $data['condition']='popup';
        
        $item_id = encryptor("decrypt", $this->input->get('id'));
        $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
        //$data['tax']=$this->mdl_tax->gettax("","","","","");
        if($_GET['type']=='transport')
        {
            $data['form_data'] = $this->mdl_item->getitembyid($item_id);
            $this->load->view('salesitem/edit_item', $data);
        }
            
        else{
            $data['form_data'] = $this->mdl_item->getrentitembyid($item_id);
            $this->load->model('mdl_item_master');
            $data['item']=$this->mdl_item_master->getitem("","","","","");
            $this->load->model('Mdl_warehouse');
            $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
            $this->load->view('salesitem/edit_rent_stock_item', $data);
        }
    }

    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_item->getitem($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['item_name'];            
            $arr[]=$row['consignee_name'];            
            $arr[]=$row['opening_stock'];                      
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['item_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['item_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    
      function deleterecord(){
        $item_id = encryptor("decrypt", $this->input->post('delete')); 
        $record=$this->mdl_salesitem->deletebyid($item_id);
        if($record==1) echo "true";
        else echo "false";
    }

    

    
    

}
?>
