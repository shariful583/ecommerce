<?php
$filepath=realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/Format.php');

 ?>

<?php
class Cart
{

  private $db;
  private $fm;

  public function __construct()
  {
         $this->db=new Database();
         $this->fm=new Format();
  }

public function addToCart($quantity,$id){
$quantity=$this->fm->validation($quantity);
$quantity=mysqli_real_escape_string($this->db->link,$quantity);
$productId=mysqli_real_escape_string($this->db->link,$id);
$sId=session_id();

$squery="SELECT * FROM tbl_product WHERE productId='$productId'";
$result=$this->db->select($squery)->fetch_assoc();

$productName=$result['productName'];
$price=$result['price'];
$image=$result['image'];

$chquery="SELECT * FROM tbl_cart WHERE productId='$productId' AND sId='$sId'";
$getPro=$this->db->select($chquery);
if ($getPro) {
  $msg="product already added";
  return $msg;
}else{
$query="INSERT INTO tbl_cart(sId,productId,productName,price,quantity,image) VALUES('$sId','$productId','$productName','$price','$quantity','$image')";

$insert_row=$this->db->insert($query);
if($insert_row){
   header("Location:cart.php");
}else{
  header("Location:cart.php");
}
}
}

 public function getCartProduct(){
   $sId=session_id();
   $query="SELECT * FROM tbl_cart WHERE sId='$sId'";
   $result=$this->db->select($query);
   return $result;

 }
 public function updateCartQn($quantity,$cartId){
   $cartId=$this->fm->validation($cartId);
   $quantity=$this->fm->validation($quantity);

   $cartId=mysqli_real_escape_string($this->db->link,$cartId);
   $quantity=mysqli_real_escape_string($this->db->link,$quantity);

   $query="UPDATE tbl_cart
          SET
          quantity='$quantity'
          WHERE cartId='$cartId'";
          $update_cart=$this->db->update($query);
          if($update_cart){
              echo "<script>window.location='cart.php';</script>";
          }else{
            $msg="<span class='error'>Quantity not Updated</span>";
            return $msg;
          }
 }

 public function delCartProById($delid){
   $query="DELETE FROM tbl_cart WHERE cartId='$delid'";
   $delcart=$this->db->delete($query);
   if($delcart){
     echo "<script>window.location='cart.php';</script>";
   }else{
     $msg="<span class='error'>CartProduct  not deleted</span>";
     return $msg;
   }
 }

 public function checkCartTable(){
   $sId=session_id();
   $query="SELECT * FROM tbl_cart WHERE sId='$sId'";
   $result=$this->db->select($query);
   return $result;

 }

 public function delCustomerCart(){
   $sId=session_id();
   $query="DELETE FROM tbl_cart WHERE sId='$sId'";
   $result=$this->db->delete($query);

 }

 public function checkCart(){
   $sId=session_id();
   $query="SELECT * FROM tbl_cart WHERE sId='$sId'";
   $result=$this->db->select($query);
   return $result;

 }

 public function checkOrder($cmrid){

   $query="SELECT * FROM tbl_order WHERE cmrid='$cmrid'";
   $result=$this->db->select($query);
   return $result;

 }

 public function OrderProduct($cmrid){
   $sId=session_id();
   $query="SELECT * FROM tbl_cart WHERE sId='$sId' ";
   $getPro=$this->db->select($query);
  if ($getPro) {
     while($result=$getPro->fetch_assoc()) {
       $productId=$result['productId'];
       $productName=$result['productName'];
       $quantity=$result['quantity'];
       $price=$result['price'];
       $image=$result['image'];

      $query="INSERT INTO tbl_order(cmrid,productId,productName,quantity,price,image) VALUES('$cmrid','$productId','$productName','$quantity','$price','$image')";
      $insert_row=$this->db->insert($query);
     }
  }
 }

 public function getOrderProduct($cmrid){
   $query="SELECT * FROM tbl_order WHERE cmrid='$cmrid' ORDER BY date DESC";
   $result=$this->db->select($query);
   return $result;
 }

 public function getAllOrderPro(){
   $query="SELECT * FROM tbl_order ORDER BY date";
   $result=$this->db->select($query);
   return $result;
 }

 public function productShifted($id,$date,$price){
   $id=mysqli_real_escape_string($this->db->link,$id);
   $date=mysqli_real_escape_string($this->db->link,$date);
   $price=mysqli_real_escape_string($this->db->link,$price);
   $query="UPDATE tbl_order
          SET
          status='1'
          WHERE cmrid='$id' AND date='$date' AND price='$price'";
          $update_row=$this->db->update($query);
          if($update_row){
            $msg="<span class='success'> updated successfully</span>";
            return $msg;
          }else{
            $msg="<span class='error'> not Updated</span>";
            return $msg;
          }
 }

 public function delOrderProduct($id,$date,$price){
   $id=mysqli_real_escape_string($this->db->link,$id);
   $date=mysqli_real_escape_string($this->db->link,$date);
   $price=mysqli_real_escape_string($this->db->link,$price);

   $query="DELETE FROM tbl_order WHERE cmrid='$id' AND date='$date' AND price='$price'";
   $delcat=$this->db->delete($query);
   if($delcat){
     $msg="<span class='success'>Data deleted successfully</span>";
     return $msg;
   }else{
     $msg="<span class='error'> Data Not deleted</span>";
     return $msg;
   }
 }

 public function productConfirm($id,$date,$price){
   $id=mysqli_real_escape_string($this->db->link,$id);
   $date=mysqli_real_escape_string($this->db->link,$date);
   $price=mysqli_real_escape_string($this->db->link,$price);

   $query="UPDATE tbl_order
          SET
          status='2'
          WHERE cmrid='$id' AND date='$date' AND price='$price'";
          $update_row=$this->db->update($query);
          if($update_row){
            $msg="<span class='success'> updated successfully</span>";
            return $msg;
          }else{
            $msg="<span class='error'> not Updated</span>";
            return $msg;
          }
 }




}


 ?>
