<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_project extends CI_Model{

    public function saveproject($post)
    {
        //`id`, `place_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['project_name']))
        $project_name='';
        else
        $project_name=$_POST['project_name'];

        if(empty($_POST['company_name']))
            $company_name='';
        else
            $company_name=$_POST['company_name'];

    if(empty($_POST['company_address']))
        $company_address='';
        else
        $company_address=$_POST['company_address'];

    if(empty($_POST['contact_person_name']))
        $contact_person_name='';
        else
        $contact_person_name=$_POST['contact_person_name'];


        if(empty($_POST['rotation_per_month']))
        $rotation_per_month='';
        else
        $rotation_per_month=$_POST['rotation_per_month'];

        if(empty($_POST['source_id']))
        $source_id='';
        else
        $source_id=$_POST['source_id'];

        if(empty($_POST['destination_id']))
        $destination_id='';
        else
        $destination_id=$_POST['destination_id'];

        if(empty($_POST['asset_name[]']))
        $asset_name[]='';
        else
        $asset_name[]=$_POST['asset_name[]'];

        if(empty($_POST['life_in_months[]']))
        $life_in_months[]='';
        else
        $life_in_months[]=$_POST['life_in_months[]'];

        if(empty($_POST['purchase_cost[]']))
        $purchase_cost[]='';
        else
        $purchase_cost[]=$_POST['purchase_cost[]'];

        if(empty($_POST['total_qty[]']))
        $total_qty[]='';
        else
        $total_qty[]=$_POST['total_qty[]'];



        if(empty($_POST['interest_rate']))
        $interest_rate='';
        else
        $interest_rate=$_POST['interest_rate'];

        if(empty($_POST['profit_rate']))
        $profit_rate='';
        else
        $profit_rate=$_POST['profit_rate'];

        if(empty($_POST['principal']))
        $principal='';
        else
        $principal=$_POST['principal'];

        if(empty($_POST['time']))
        $time='';
        else
        $time=$_POST['time'];

        if(empty($_POST['operation_name[]']))
        $operation_name[]='';
        else
        $operation_name[]=$_POST['operation_name[]'];

        if(empty($_POST['operation_amount[]']))
        $operation_amount[]='';
        else
        $operation_amount[]=$_POST['operation_amount[]'];

        if(empty($_POST['operation_name[]']))
        $operation_name[]='';
        else
        $operation_name[]=$_POST['operation_name[]'];

        if(empty($_POST['operation_amount[]']))
        $operation_amount[]='';
        else
        $operation_amount[]=$_POST['operation_amount[]'];

        if(empty($_POST['operation_name[]']))
        $operation_name[]='';
        else
        $operation_name[]=$_POST['operation_name[]'];

        if(empty($_POST['operation_amount[]']))
        $operation_amount[]='';
        else
        $operation_amount[]=$_POST['operation_amount[]'];

        if(empty($_POST['interest_rate']))
        $assets_interest_rate='';
        else
        $assets_interest_rate=$_POST['interest_rate'];

    if(empty($_POST['operation_rate']))
        $operation_interest_rate='';
        else
        $operation_interest_rate=$_POST['operation_rate'];

    if(empty($_POST['profit_rate']))
        $profit_rate='';
    else
        $profit_rate=$_POST['profit_rate'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $quotation_date=date('Y-m-d');
        $remarks=$_POST['remarks'];

        $data=array('project_name'=>$project_name,'contact_person_name'=>$contact_person_name,'company_name'=>$company_name,'company_address'=>$company_address,'rotation_per_month'=>$rotation_per_month , 'source_id'=>$source_id , 'destination_id'=>$destination_id , 'quotation_date'=>$quotation_date , 'remarks'=>$remarks , 'total_costing'=>$principal , 'profit_rate'=>$profit_rate ,'assets_interest_rate'=>$assets_interest_rate ,'operation_interest_rate'=>$operation_interest_rate , 'created_by'=>$user_id , 'created_datetime'=>$datetime);
        $this->db->insert('tbl_project',$data);
        $lastid=$this->db->insert_id();
        $data=array();
        for($i=0;$i<sizeof($_POST['asset_name']);$i++)
        {
            if(!empty($_POST['asset_name'][$i]) && !empty($_POST['life_in_months'][$i]))
            {
                $temp=array('project_id'=>$lastid,'assets_name'=>$_POST['asset_name'][$i],'life_in_month'=>$_POST['life_in_months'][$i], 'purchase_cost'=>$_POST['purchase_cost'][$i], 'total_qty'=>$_POST['total_qty'][$i]);
                array_push($data,$temp);
            }
        }
        if(sizeof($data)>0)
                $this->db->insert_batch('project_assets_detalis', $data);

        $data=array();
        for($i=0;$i<sizeof($_POST['operation_name']);$i++)
        {
            if(!empty($_POST['operation_name'][$i]) && !empty($_POST['operation_amount'][$i]))
            {
                $temp=array('project_id'=>$lastid,'operation_name'=>$_POST['operation_name'][$i],'operation_cost'=>$_POST['operation_amount'][$i]);
                array_push($data,$temp);
            }
        }
        if(sizeof($data)>0)
                $this->db->insert_batch('project_operation_details', $data);

    }
    public function getproject($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("project_id","quotation_date","project_name","p.place_name","pa.place_name","total_costing","remarks");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('place_id,`place_name`')
                ->from('place')
                ->where('is_deleted', '0')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('project_id,project_name,`quotation_date`, p.place_name as source, pa.place_name as destination,total_costing,remarks,project_status');
            $this->db->where('tbl_project.is_deleted', '0');
            $this->db->where('tbl_project.project_status <', '2');

            if(!empty($searchstr))
            {
                $this->db->or_like('project_name', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_project')->join('place p', 'p.place_id = tbl_project.source_id', 'left')
                ->join('place pa', 'pa.place_id = tbl_project.destination_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_project');
            $this->db->join('place p', 'p.place_id = tbl_project.source_id', 'left');
            $this->db->join('place pa', 'pa.place_id = tbl_project.destination_id', 'left');
            $this->db->order_by('project_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getrunningproject($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("project_id","quotation_date","project_name","p.place_name","pa.place_name","total_costing","remarks");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('place_id,`place_name`')
                ->from('place')
                ->where('is_deleted', '0')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('project_id,project_name,`quotation_date`, p.place_name as source, pa.place_name as destination,total_costing,remarks,project_status');
            $this->db->where('tbl_project.is_deleted', '0');
            $this->db->where('tbl_project.project_status >=', '2');

            if(!empty($searchstr))
            {
                $this->db->or_like('project_name', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_project')->join('place p', 'p.place_id = tbl_project.source_id', 'left')
                ->join('place pa', 'pa.place_id = tbl_project.destination_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_project');
            $this->db->join('place p', 'p.place_id = tbl_project.source_id', 'left');
            $this->db->join('place pa', 'pa.place_id = tbl_project.destination_id', 'left');
            $this->db->order_by('project_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getprojectbyid($projectid)
    {
        $query=$this->db->select('`project_id`, `project_name`, `rotation_per_month`, `source_id`, `destination_id`, `quotation_date`, `updation_date`, `remarks`, `total_costing`, `profit_rate`,assets_interest_rate,operation_interest_rate,company_name,contact_person_name,company_address')
            ->from('tbl_project')
            ->where(array("project_id"=>$projectid))
            ->get();
        $record['project']=$query->result_array();

        $query=$this->db->select('`operation_name`, `operation_cost`')
            ->from('project_operation_details')
            ->where(array("project_id"=>$projectid))
            ->get();
        $record['project_operation']=$query->result_array();

        $query=$this->db->select('`assets_name`, `life_in_month`, `purchase_cost`, `total_qty`, `interest_rate`')
            ->from('project_assets_detalis')
            ->where(array("project_id"=>$projectid))
            ->get();
        $record['project_asset']=$query->result_array();

        return $record;
    }
    public function updateproject($post)
    {
        if(empty($_POST['project_name']))
        $project_name='';
        else
        $project_name=$_POST['project_name'];

        if(empty($_POST['company_name']))
            $company_name='';
        else
            $company_name=$_POST['company_name'];

    if(empty($_POST['company_address']))
        $company_address='';
        else
        $company_address=$_POST['company_address'];

    if(empty($_POST['contact_person_name']))
        $contact_person_name='';
        else
        $contact_person_name=$_POST['contact_person_name'];
        

        if(empty($_POST['rotation_per_month']))
        $rotation_per_month='';
        else
        $rotation_per_month=$_POST['rotation_per_month'];

        if(empty($_POST['source_id']))
        $source_id='';
        else
        $source_id=$_POST['source_id'];

        if(empty($_POST['destination_id']))
        $destination_id='';
        else
        $destination_id=$_POST['destination_id'];

        if(empty($_POST['asset_name[]']))
        $asset_name[]='';
        else
        $asset_name[]=$_POST['asset_name[]'];

        if(empty($_POST['life_in_months[]']))
        $life_in_months[]='';
        else
        $life_in_months[]=$_POST['life_in_months[]'];

        if(empty($_POST['purchase_cost[]']))
        $purchase_cost[]='';
        else
        $purchase_cost[]=$_POST['purchase_cost[]'];

        if(empty($_POST['total_qty[]']))
        $total_qty[]='';
        else
        $total_qty[]=$_POST['total_qty[]'];



        if(empty($_POST['interest_rate']))
        $interest_rate='';
        else
        $interest_rate=$_POST['interest_rate'];

        if(empty($_POST['profit_rate']))
        $profit_rate='';
        else
        $profit_rate=$_POST['profit_rate'];

        if(empty($_POST['principal']))
        $principal='';
        else
        $principal=$_POST['principal'];

        if(empty($_POST['time']))
        $time='';
        else
        $time=$_POST['time'];

        if(empty($_POST['operation_name[]']))
        $operation_name[]='';
        else
        $operation_name[]=$_POST['operation_name[]'];

        if(empty($_POST['operation_amount[]']))
        $operation_amount[]='';
        else
        $operation_amount[]=$_POST['operation_amount[]'];

        if(empty($_POST['operation_name[]']))
        $operation_name[]='';
        else
        $operation_name[]=$_POST['operation_name[]'];

        if(empty($_POST['operation_amount[]']))
        $operation_amount[]='';
        else
        $operation_amount[]=$_POST['operation_amount[]'];

        if(empty($_POST['operation_name[]']))
        $operation_name[]='';
        else
        $operation_name[]=$_POST['operation_name[]'];

        if(empty($_POST['operation_amount[]']))
        $operation_amount[]='';
        else
        $operation_amount[]=$_POST['operation_amount[]'];

        if(empty($_POST['interest_rate']))
        $assets_interest_rate='';
        else
        $assets_interest_rate=$_POST['interest_rate'];

    if(empty($_POST['operation_rate']))
        $operation_interest_rate='';
        else
        $operation_interest_rate=$_POST['operation_rate'];

    if(empty($_POST['profit_rate']))
        $profit_rate='';
    else
        $profit_rate=$_POST['profit_rate'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $quotation_date=date('Y-m-d');
        $remarks=$_POST['remarks'];

        $data=array('project_name'=>$project_name ,'company_name'=>$company_name ,'company_address'=>$company_address ,'contact_person_name'=>$contact_person_name ,'rotation_per_month'=>$rotation_per_month , 'source_id'=>$source_id , 'destination_id'=>$destination_id , 'quotation_date'=>$quotation_date , 'remarks'=>$remarks , 'total_costing'=>$principal , 'profit_rate'=>$profit_rate ,'assets_interest_rate'=>$assets_interest_rate ,'operation_interest_rate'=>$operation_interest_rate , 'updated_by'=>$user_id , 'updated_datetime'=>$datetime);
        //$lastid=encryptor("decrypt",$post['project_id']);
        
        
        $project_id = encryptor("decrypt", $this->input->get('id'));
        $lastid=$project_id;
        
        $this->db->where('project_id',$lastid);
        $this->db->update('tbl_project',$data);
        $this->db->where('project_id',$lastid);
        $this->db->delete('project_assets_detalis');

        $this->db->where('project_id',$lastid);
        $this->db->delete('project_operation_details');
        $data=array();
        for($i=0;$i<sizeof($_POST['asset_name']);$i++)
        {
            if(!empty($_POST['asset_name'][$i]) && !empty($_POST['life_in_months'][$i]))
            {
                $temp=array('project_id'=>$lastid,'assets_name'=>$_POST['asset_name'][$i],'life_in_month'=>$_POST['life_in_months'][$i], 'purchase_cost'=>$_POST['purchase_cost'][$i], 'total_qty'=>$_POST['total_qty'][$i]);
                array_push($data,$temp);
            }
        }
        if(sizeof($data)>0)
                $this->db->insert_batch('project_assets_detalis', $data);

        $data=array();
        for($i=0;$i<sizeof($_POST['operation_name']);$i++)
        {
            if(!empty($_POST['operation_name'][$i]) && !empty($_POST['operation_amount'][$i]))
            {
                $temp=array('project_id'=>$lastid,'operation_name'=>$_POST['operation_name'][$i],'operation_cost'=>$_POST['operation_amount'][$i]);
                array_push($data,$temp);
            }
        }
        if(sizeof($data)>0)
                $this->db->insert_batch('project_operation_details', $data);
       
       
    }
    public function deletebyid($placeid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('project_id', $placeid);
        $this->db->update('tbl_project',$data);
        return $this->db->affected_rows();
    }
    public function updateprojectstatus($project_id){
        $projectstatus=$_POST['projectstatus'];
        $data=array("project_status"=>$projectstatus);
        $this->db->where('project_id', $project_id);
        $this->db->update('tbl_project',$data);
        return $this->db->affected_rows();
    }

}
?>