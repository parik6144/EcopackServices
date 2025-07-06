<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Stocktransfer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="consignee";
        $this->load->model('Mdl_stocktransfer');
        $this->load->model('Mdl_consignee');
        $this->load->model('Mdl_setting');
    }
    
    public function index()
    {
        $data['title']="Stock Transfer";
        $this->load->view('stock_transfer/stock_transfer_details',$data);
    }
    public function add()
    {
        if(isset($_POST['from_consignee_id']))
        {
            $lastid=$this->Mdl_stocktransfer->savestocktransfer($_POST);
            echo encryptor("encrypt",$lastid);
        }
        
    }
    public function edit()
    {
        if(isset($_POST['stock_transfer_id']))
        {
            $this->Mdl_stocktransfer->updatestocktransfer($_POST);
            return "true";

        }
    }
    function deleterecord(){
        $consignee_id = encryptor("decrypt", $this->input->post('delete'));
        $record=$this->Mdl_consignee->deletebyid($consignee_id);
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
        $this->load->view('stock_transfer/add_stock_transfer',$data);
    }
    public function editpopup()
    {
        $Stocktransfer_id=encryptor("decrypt",$this->input->get('id'));
        $data['title'] = "Stock Transfer";
        $data['condition']='popup';
        $data["consignee"]=$temp=$this->Mdl_consignee->getconsignee("","","","","","");
        $data['form_data'] = $this->Mdl_stocktransfer->getstocktransferbyid($Stocktransfer_id);
        $this->load->model('Mdl_stock');
        $this->load->model('Mdl_item');
        $data['from_item']=$this->Mdl_item->getItemByConsignee($data['form_data']->from_consignee_id);
        $data['to_item']=$this->Mdl_item->getItemByConsignee($data['form_data']->to_consignee_id);
        $crstock=$this->Mdl_stock->getStockByItem($data['form_data']->to_item_id);
        $data['stock']=$crstock+$data['form_data']->qty;
        $this->load->view('stock_transfer/edit_stock_transfer',$data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_stocktransfer->getstocktransfer($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=date("d-m-y",strtotime($row['stock_transfer_date']));
            $arr[]=$row['from_consignee_name'];
            $arr[]=$row['from_item_name'];
            $arr[]=$row['to_consignee_name'];
            $arr[]=$row['to_item_name'];
            $arr[]=$row['qty'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['stock_transfer_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['stock_transfer_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
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
    public function getStockByItem()
    {
        $item_id=$this->input->post('item_id');
        $this->load->model('Mdl_stock');
        echo $this->Mdl_stock->getStockByItem($item_id);
    }

}
?>