<?php
$filepath=realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../lib/Session.php');
Session::checkLogin();
include_once ($filepath.'/../helpers/Format.php');
?>
<?php

class Adminlogin
{
  private $db;
  private $fm;

  public function __construct()
  {
         $this->db=new Database();
         $this->fm=new Format();
  }

  public function adminLogin($adminUser,$adminPassword){
    $adminUser=$this->fm->validation($adminUser);
    $adminPassword=$this->fm->validation($adminPassword);

    $adminUser=mysqli_real_escape_string($this->db->link,$adminUser);
    $adminPassword=mysqli_real_escape_string($this->db->link,$adminPassword);

    if (empty($adminPassword)||empty($adminUser)) {
         $loginmsg="UserName And Password not Empty!";
         return $loginmsg;
    }else{
      $query="SELECT * FROM tbl_admin WHERE adminUser='$adminUser' AND adminPassword='$adminPassword'";
      $result=$this->db->select($query);
      if ($result !=false) {
        $value=$result->fetch_assoc();
        Session::set("adminlogin",true);
        Session::set("adminId",$value['adminId']);
        Session::set("adminUser",$value['adminUser']);
        Session::set("adminName",$value['adminName']);
        header("Location:index.php");
      }else{
        $loginmsg="UserName And Password not Match!";
        return $loginmsg;
      }
    }
  }

}

 ?>
