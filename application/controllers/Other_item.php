<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class other_item extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $data['title']="Item";
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        //$this->load->model('mdl_other_item');
        $this->load->model('mdl_other_item');
        $this->load->model('mdl_consignee');
        //$this->load->model('mdl_tax');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Item";
        $this->load->view('other_item/item_details',$data);
    }
    public function add()
    {
        if(isset($_POST['other_item_name']))
        {
            $lastid=$this->mdl_other_item->saveitem($_POST);
            echo $lastid;
        }
        else
        {
            $data['title']="Add Item"; 
            $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");         
            $this->load->view('other_item/add_other_item',$data);
        }
    }
   
    public function edit()
    {

        if(isset($_POST['other_item_name']))
        {
            return $this->mdl_other_item->updateitem($_POST);
        }
        else {
            $data['title'] = "Edit Item";
            $other_item_id = encryptor("decrypt", $this->input->get('id'));
            $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
            $data['form_data'] = $this->mdl_other_item->getitembyid($other_item_id);

            $this->load->view('other_item/edit_item', $data);
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
        $this->load->view('other_item/add_item',$data);
    }
    
    public function editpopup()
    {
        $data['title'] = "Edit Item";
        $data['condition']='popup';
        
        $other_item_id = encryptor("decrypt", $this->input->get('id'));
        $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
        //$data['tax']=$this->mdl_tax->gettax("","","","","");
        if($_GET['type']=='transport')
        {
            $data['form_data'] = $this->mdl_other_item->getitembyid($other_item_id);
            $this->load->view('other_item/edit_item', $data);
        }
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_other_item->getitem($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['other_item_name'];            
            $arr[]=$row['consignee_name'];            
            $arr[]=$row['opening_stock'];                      
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['other_item_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['other_item_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    
    function deleterecord(){
         $other_item_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->mdl_other_item->deletebyid($other_item_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function getItemByConsigneeId()
    {  
        echo json_encode($this->mdl_other_item->getItemByConsignee($this->input->post('consignee_id'),$this->input->post('stock_date')));
    }
    
}
?>
