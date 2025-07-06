<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19/02/2019
 * Time: 12:58
 */
class Asign_rent_item extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="consignee";
        $this->load->model('Mdl_asign_rent_item');
        $this->load->model('Mdl_consignee');
        $this->load->model('Mdl_setting');
        

    }
    public function index()
    {
        $data['title']="Asign Rent Item";
        $this->load->view('asign_rent_item/asign_rent_item_details',$data);
    }
    public function add()
    {
        if(isset($_POST['from_warehouse_id']))
        {
            $lastid=$this->Mdl_asign_rent_item->savestocktransfer($_POST);
            echo encryptor("encrypt",$lastid);
        }
        
    }
    public function edit()
    {
        if(isset($_POST['stock_transfer_id']))
        {
            $this->Mdl_asign_rent_item->updatestocktransfer($_POST);
            return "true";

        }
        else
            echo "out";
    }
    function deleterecord(){
        $consignee_id = encryptor("decrypt", $this->input->post('delete'));
        $record=$this->Mdl_asign_rent_item->deletebyid($consignee_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Stock Transfer";
        $data['condition']='popup';
        $data["consignee"]=$temp=$this->Mdl_consignee->getconsignee("","","","","","");
        $this->load->model('Mdl_warehouse');
        $data["warehouse"]=$this->Mdl_warehouse->getwarehouse("","","","","","");
        $this->load->model('Mdl_item_master');
        $data['item_master']=$this->Mdl_item_master->getitem("","","","","","");
        $this->load->view('asign_rent_item/add_asign_rent_item',$data);
    }
    public function editpopup()
    {
        $Stocktransfer_id=encryptor("decrypt",$this->input->get('id'));
        $data['title'] = "Stock Transfer";
        $data['condition']='popup';
        $data["consignee"]=$temp=$this->Mdl_consignee->getconsignee("","","","","","");
        $data['form_data'] = $this->Mdl_asign_rent_item->getstocktransferbyid($Stocktransfer_id);
        $this->load->model('Mdl_stock');
        $this->load->model('Mdl_item');
        $data['from_item']=$this->Mdl_item->getRentItemByConsignee($data['form_data']->from_consignee_id);
        $data['to_item']=$this->Mdl_item->getRentItemByConsignee($data['form_data']->to_consignee_id);
        $crstock=$this->Mdl_stock->getStockByItem($data['form_data']->to_item_id);
        $data['stock']=$crstock+$data['form_data']->qty;
        $this->load->view('rent_stock_transfer/edit_rent_stock_transfer',$data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_asign_rent_item->getasignitem($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=date("d-m-y",strtotime($row['asign_date']));
            $arr[]=$row['from_warehouse'];
            $arr[]=$row['from_item_name'];
            $arr[]=$row['to_warehouse'];
            $arr[]=$row['consignee_name'];
            $arr[]=$row['to_item_name'];
            $arr[]=$row['qty'];
            $arr[]="<div class='col-sm-12'><a href='#' refid='".encryptor("encrypt",$row['asign_rent_item_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function getConsigneeByPlace()
    {
        $place_id=$this->input->post('place');
        echo json_encode($this->Mdl_consignee->getConsigneeByPlace($place_id));
    }
    public function getRentStockByItem()
    {
        $item_id=$this->input->post('item_id');
        $warehouse_id=$this->input->post('from_warehouse_id');
        $this->load->model('Mdl_stock');
        echo $this->Mdl_stock->getRentIdleStockByItem($warehouse_id,$item_id);
    }

}
?>