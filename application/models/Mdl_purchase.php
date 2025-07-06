
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_purchase extends CI_Model{
    public function savepurchase($data)
    {
        //print_r($data['data']['productData']);
        //print_r($data['data']['purchasedate']);
        //INSERT INTO `purchase`(`purchase_id`, `customer_id`, `purchase_date`, `other_charge`, `total_amount`, `bill_discount`, `grand_total`, `narration`, `user_id`) VALUES ();
        $purchaserecord=$data['data']['purchasedate']['0'];
        if(empty($purchaserecord['account_id']))
            $account_id="";
        else
            $account_id=$purchaserecord['account_id'];

        if(empty($purchaserecord['purchase_date']))
            $purchase_date="";
        else
            $purchase_date=date("Y-m-d", strtotime($purchaserecord['purchase_date']));

        if(empty($purchaserecord['other_amount']))
            $other_amount="";
        else
            $other_amount=$purchaserecord['other_amount'];

        if(empty($purchaserecord['final_total_amount']))
            $final_total_amount="";
        else
            $final_total_amount=$purchaserecord['final_total_amount'];

        if(empty($purchaserecord['bill_discount']))
            $bill_discount="";
        else
            $bill_discount=$purchaserecord['bill_discount'];

        if(empty($purchaserecord['grand_total']))
            $grand_total="";
        else
            $grand_total=$purchaserecord['grand_total'];

        if(empty($purchaserecord['narretion']))
            $narretion="";
        else
            $narretion=$purchaserecord['narretion'];

        if(empty($purchaserecord['purchase_no']))
            $purchase_no="";
        else
            $purchase_no=$purchaserecord['purchase_no'];

        if(empty($purchaserecord['round_off']))
            $round_off="";
        else
            $round_off=$purchaserecord['round_off'];

        //`customer_id`, `purchase_date`, `other_charge`, `total_amount`, `bill_discount`, `grand_total`, `narration`, `user_id`
         

        $insertdata=array("customer_id"=>$account_id,
            "purchase_date"=>$purchase_date,
            "other_charge"=>$other_amount,
            "total_amount"=>$final_total_amount,
            "bill_discount"=>$bill_discount,
            "grand_total"=>$grand_total,
            "narration"=>$narretion,
            "purchase_no"=>$purchase_no,
            "round_off"=>$round_off
            );
        //print_r($insertdata);
        $this->db->insert('purchase',$insertdata);
         $lastid=$this->db->insert_id();

         foreach ($data['data']['productData'] as $row) {
            
            if(empty($row['item_id']))
                $item_id="";
            else
                $item_id=$row['item_id'];

            if(empty($row['qty']))
                $qty="";
            else
                $qty=$row['qty'];

            if(empty($row['purchase_price']))
                $purchase_price="";
            else
                $purchase_price=$row['purchase_price'];

            if(empty($row['tax']))
                $tax="";
            else
                $tax=$row['tax'];

            if(empty($row['discount']))
                $discount="";
            else
                $discount=$row['discount'];

            if(empty($row['total_price']))
                $total_price="";
            else
                $total_price=$row['total_price'];


            $insertdata=array("purchase_id"=>$lastid,
            "item_id"=>$item_id,
            "qty"=>$qty,
            "price"=>$purchase_price,
            "purchase_tax_id"=>$tax,
            "discount"=>$discount,
            "total_price"=>$total_price,
            "customer_id"=>$account_id
            );
            $this->db->insert('purchase_details',$insertdata);
            //$lastid=$this->db->insert_id();

         }
         echo "save";
    }
    public function getpurchase($start="",$length="",$searchstr="",$column,$type)
    {
       
        $col = (int)$column;
        
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`purchase_id`, `id`,`account_name`, `purchase_date`, `other_charge`, `total_amount`,bill_discount,grand_total,narration')
                ->from('purchase')
                ->get();
            return $query->result_array();
        }
        else
        {
            $arr=array("purchase_id","purchase_no","purchase_date", "account_name", "purchase_id", "other_charge", "total_amount","bill_discount","grand_total");
            $this->db->select('purchase_date,purchase_no,`account_name`, `purchase_id`, `other_charge`, `total_amount`, `bill_discount`,grand_total,purchase_id');
            if(!empty($searchstr))
            {
                $this->db->or_like('purchase_date', $searchstr);
                $this->db->or_like('purchase_no', $searchstr);
                $this->db->or_like('account_name', $searchstr);
                $this->db->or_like('purchase_id', $searchstr);
                $this->db->or_like('other_charge', $searchstr);
                $this->db->or_like('total_amount', $searchstr);
                $this->db->or_like('bill_discount', $searchstr);
                $this->db->or_like('grand_total', $searchstr);
            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('purchase')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('purchase');
            $this->db->join('tbl_account act', 'act.id = purchase.customer_id', 'left');
            
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();

            return $response;
        }
    }
    public function getprintpurchase($id)
    {
        $query=$this->db->select('`purchase_id`,purchase_no, `id`,`account_name`, `purchase_date`, `other_charge`, `total_amount`,bill_discount,grand_total,narration, `email`, `mobile`, `phone`,country_name,city_name,state_name,address_line1,address_line2,zip_code,city_name,round_off')
        ->where('purchase_id',$id)
                ->from('purchase')
                 ->join('tbl_account act', 'act.id = purchase.customer_id', 'left')
                 ->join('address', 'act.id = address.ref_id', 'left')
                 ->join('countries', 'address.country_id =countries.country_id', 'left')
                 ->join('cities', 'address.city_id = cities.city_id', 'left')
                 ->join('states', 'address.state_id = states.state_id', 'left')
                ->get();
            return $query->result_array();
    }
    public function getitem($id)
    {
        $query=$this->db->select('`purchase_details_id`, `purchase_id`,purchase_details.item_id, purchase_details.qty, purchase_details.price, `purchase_tax_id`, `discount`, `total_price`, `customer_id`,item_name,hsn_code,short_name')
        ->where('purchase_id',$id)
                ->from('purchase_details')
                 ->join('item', 'item.item_id = purchase_details.item_id', 'left')
                 ->join('uom', 'item.uom_id = uom.uom_id', 'left')
                ->get();
            return $query->result_array();
    }

}
?>