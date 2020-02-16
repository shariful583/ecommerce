<?php
$filepath=realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/Format.php');

 ?>

<?php
class Customer
{

  private $db;
  private $fm;

  public function __construct()
  {
         $this->db=new Database();
         $this->fm=new Format();
  }

public function customerRegter($data){
  $name=$this->fm->validation($data['name']);
  $address=$this->fm->validation($data['address']);
  $city=$this->fm->validation($data['city']);
  $country=$this->fm->validation($data['country']);
  $zip=$this->fm->validation($data['zip']);
  $phone=$this->fm->validation($data['phone']);
  $email=$this->fm->validation($data['email']);
  $pass=$this->fm->validation($data['pass']);


  $name=mysqli_real_escape_string($this->db->link,$data['name']);
  $address=mysqli_real_escape_string($this->db->link,$data['address']);
  $city=mysqli_real_escape_string($this->db->link,$data['city']);
  $country=mysqli_real_escape_string($this->db->link,$data['country']);
  $zip=mysqli_real_escape_string($this->db->link,$data['zip']);
  $phone=mysqli_real_escape_string($this->db->link,$data['phone']);
  $email=mysqli_real_escape_string($this->db->link,$data['email']);
  $pass=mysqli_real_escape_string($this->db->link,md5($data['pass']));

  if($name=='' || $address=='' || $city=='' || $country=='' || $zip=='' || $phone== '' || $email=='' || $pass=='' ){
    $msg="<span class='error'>Customer Field Must not be Empty!!</span>";
    return $msg;
  }

  $mailquery="SELECT * FROM tbl_customer WHERE email='$email' LIMIT 1";
  $mailchk=$this->db->select($mailquery);
  if ($mailchk !=false) {
    $msg="<span class='error'>Mail allready exit!!</span>";
    return $msg;
  }else{

    $query="INSERT INTO tbl_customer(name,address,city,country,zip,phone,email,pass) VALUES('$name','$address','$city','$country','$zip','$phone','$email','$pass')";

    $customerinsert=$this->db->insert($query);
    if($customerinsert){
      $msg="<span class='success'>Customer Inserted successfully</span>";
      return $msg;
    }else{
      $msg="<span class='error'>Customer not Inserted successfully</span>";
      return $msg;
    }
  }

}

public function customerLogin($data){
  $email=$this->fm->validation($data['email']);
  $pass=$this->fm->validation($data['pass']);

  $email=mysqli_real_escape_string($this->db->link,$data['email']);
  $pass=mysqli_real_escape_string($this->db->link,md5($data['pass']));

  if( $email=='' || $pass=='' ){
    $msg="<span class='error'>Login Field Must not be Empty!!</span>";
    return $msg;
  }
  $query="SELECT * FROM tbl_customer WHERE email='$email' AND pass='$pass'";
  $result=$this->db->select($query);
  if ($result !=false) {
    $value=$result->fetch_assoc();
    Session::set('cuslogin',true);
    Session::set('cmrid',$value['id']);
    Session::set('cmrName',$value['name']);
    header("Location:index.php");

  }else{
    $msg="<span class='error'>Email and Password Field not match!!</span>";
    return $msg;
  }
}

public function getCustomerData($id){
  $query="SELECT * FROM tbl_customer WHERE id='$id'";
  $result=$this->db->select($query);
  return $result;
}

public function customerUpdate($data,$cmrid){
  $name=$this->fm->validation($data['name']);
  $address=$this->fm->validation($data['address']);
  $city=$this->fm->validation($data['city']);
  $country=$this->fm->validation($data['country']);
  $zip=$this->fm->validation($data['zip']);
  $phone=$this->fm->validation($data['phone']);
  $email=$this->fm->validation($data['email']);



  $name=mysqli_real_escape_string($this->db->link,$data['name']);
  $address=mysqli_real_escape_string($this->db->link,$data['address']);
  $city=mysqli_real_escape_string($this->db->link,$data['city']);
  $country=mysqli_real_escape_string($this->db->link,$data['country']);
  $zip=mysqli_real_escape_string($this->db->link,$data['zip']);
  $phone=mysqli_real_escape_string($this->db->link,$data['phone']);
  $email=mysqli_real_escape_string($this->db->link,$data['email']);


  if($name=='' || $address=='' || $city=='' || $country=='' || $zip=='' || $phone== '' || $email=='' ){
    $msg="<span class='error'>Customer Field Must not be Empty!!</span>";
    return $msg;
  }else{

    $query="UPDATE tbl_customer
           SET
           name    ='$name',
           address ='$address',
           city    ='$city',
           country ='$country',
           zip     ='$zip',
           phone   ='$phone',
           email   ='$email'

           WHERE id='$cmrid'";
           $update_row=$this->db->update($query);
           if($update_row){
             $msg="<span class='success'>Customer updated successfully</span>";
             return $msg;
           }else{
             $msg="<span class='error'>Customer not Updated</span>";
             return $msg;
           }
  }
}


}


 ?>
