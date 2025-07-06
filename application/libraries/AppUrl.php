<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class AppUrl
{

    public static function url($url) {
        return  base_url() .$url;
    }

    public static function profileImg($img_name) {
        if($img_name == "")
            return  base_url(). 'assets/img/Profile.png';
        else
            return  base_url() .'uploads/images/'.$img_name;
    }

    public static function imageUrl($url) {
        return  base_url() . 'uploads/images/' .$url;
    }


    public static function cssUrl($url) {
        return  base_url() . 'assets/css/' .$url;
    }

    public static function jsUrl($url) {
        return  base_url() . 'assets/js/' . $url . '?_random=' . date("YmdHis");
    }

    public static function fullPath($path) {
        return str_replace('\\', '/', dirname(__FILE__)) . '/../../' . $path;
    }
    public function userdatatosession($data)
    {
        $userData=array();
        $userData['first_name'] = $data[0]['first_name'];
        $userData['last_name'] = $data[0]['last_name'];
        $userData['email'] = $data[0]['email'];
        $userData['phone'] = $data[0]['mobile_number'];
        $userData['picture_url'] = $data[0]['img_name'];
        $userData['profession'] = $data[0]['name'];
        $userData['profession_id'] = $data[0]['profession_id'];
        $userData['segments'] = $data[0]['segments'];
        $userData['segment_name'] = $data[0]['segment_name'];
        $_SESSION['userData']=$userData;
    }
}