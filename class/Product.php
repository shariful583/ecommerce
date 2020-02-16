<?php
$filepath=realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/Format.php');

 ?>
<?php

class Product
{

  private $db;
  private $fm;

  public function __construct()
  {
         $this->db=new Database();
         $this->fm=new Format();
  }


  public function productInsert($data,$file){
    $productName=$this->fm->validation($data['productName']);
    $catId=$this->fm->validation($data['catId']);
    $brandId=$this->fm->validation($data['brandId']);
    $body=$this->fm->validation($data['body']);
    $price=$this->fm->validation($data['price']);
    $type=$this->fm->validation($data['type']);

    $productName=mysqli_real_escape_string($this->db->link,$data['productName']);
    $catId=mysqli_real_escape_string($this->db->link,$data['catId']);
    $brandId=mysqli_real_escape_string($this->db->link,$data['brandId']);
    $body=mysqli_real_escape_string($this->db->link,$data['body']);
    $price=mysqli_real_escape_string($this->db->link,$data['price']);
    $type=mysqli_real_escape_string($this->db->link,$data['type']);


    $permited  = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_temp = $_FILES['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "uploads/".$unique_image;

    if($productName=='' || $catId=='' || $brandId=='' || $body=='' || $price=='' || $file_name== '' || $type=='' )
     {
       $msg="<span class='error'>Product Must not be Empty!!</span>";
       return $msg;

    }elseif ($file_size >1048567) {
     echo "<span class='error'>Image Size should be less then 1MB!</span>";

    } elseif (in_array($file_ext, $permited) === false) {
     echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";

    }else{
       move_uploaded_file($file_temp, $uploaded_image);
       $query="INSERT INTO tbl_product(productName,catId,brandId,body,price,image,type) VALUES('$productName','$catId','$brandId','$body','$price','$uploaded_image','$type')";

       $productinsert=$this->db->insert($query);
       if($productinsert){
         $msg="<span class='success'>Product Inserted successfully</span>";
         return $msg;
       }else{
         $msg="<span class='error'>Product not Inserted successfully</span>";
         return $msg;
       }
    }


  }

  public function getAllProduct(){

    // alias style query

      $query="SELECT p.*, c.catName, b.brandName
          FROM tbl_product as p, tbl_category as c , tbl_brand as b
          WHERE p.catId=c.catId AND p.brandId=b.brandId
          ORDER BY p.productId DESC ";

    // $query="SELECT tbl_product.*,tbl_category.catName,tbl_brand.brandName
    //  From tbl_product
    //  INNER JOIN tbl_category
    //  ON tbl_product.catId=tbl_category.catId
    //  INNER JOIN tbl_brand
    //  ON tbl_product.brandId=tbl_brand.brandId
    //  ORDER BY tbl_product.productId DESC";
    //
   $result=$this->db->select($query);
    return $result;
  }

  public function getProById($id){
    $query="SELECT * FROM tbl_product WHERE productId='$id'";
    $result=$this->db->select($query);
    return $result;
  }


  public function productUpdate($data,$file,$id){
    $productName=$this->fm->validation($data['productName']);
    $catId=$this->fm->validation($data['catId']);
    $brandId=$this->fm->validation($data['brandId']);
    $body=$this->fm->validation($data['body']);
    $price=$this->fm->validation($data['price']);
    $type=$this->fm->validation($data['type']);

    $productName=mysqli_real_escape_string($this->db->link,$data['productName']);
    $catId=mysqli_real_escape_string($this->db->link,$data['catId']);
    $brandId=mysqli_real_escape_string($this->db->link,$data['brandId']);
    $body=mysqli_real_escape_string($this->db->link,$data['body']);
    $price=mysqli_real_escape_string($this->db->link,$data['price']);
    $type=mysqli_real_escape_string($this->db->link,$data['type']);


    $permited  = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_temp = $_FILES['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "uploads/".$unique_image;

    if($productName=='' || $catId=='' || $brandId=='' || $body=='' || $price=='' || $type=='' )
     {
       $msg="<span class='error'>Product Must not be Empty!!</span>";
       return $msg;

    }elseif ($file_size >1048567) {
     echo "<span class='error'>Image Size should be less then 1MB!</span>";

   } else{
       if (!empty($file_name)) {

          if (in_array($file_ext, $permited) === false) {
           echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";

          }else{
             move_uploaded_file($file_temp, $uploaded_image);
             $query="UPDATE tbl_product
                      SET
                      productName ='$productName',
                      catId       ='$catId',
                      brandId     ='$brandId',
                      body        ='$body',
                      price       ='$price',
                      image       ='$uploaded_image',
                      type        ='$type'
                      WHERE productId='$id' ";

             $update_row=$this->db->update($query);
             if($update_row){
               $msg="<span class='success'>Product Update successfully</span>";
               return $msg;
             }else{
               $msg="<span class='error'>Product not Update successfully</span>";
               return $msg;
             }
          }
        }else{

          $query="UPDATE tbl_product
                   SET
                   productName ='$productName',
                   catId       ='$catId',
                   brandId     ='$brandId',
                   body        ='$body',
                   price       ='$price',
                   type        ='$type'
                   WHERE productId='$id' ";

          $update_row=$this->db->update($query);
          if($update_row){
            $msg="<span class='success'>Product Update successfully</span>";
            return $msg;
          }else{
            $msg="<span class='error'>Product not Update successfully</span>";
            return $msg;
          }

        }
     }
   }

   public function delProById($id){

     $query="SELECT * FROM tbl_product WHERE productId='$id'";
     $getdata=$this->db->select($query);
     if ($getdata) {
        while ($delimg=$getdata->fetch_assoc()) {
              $dellink= $delimg['image'];
              unlink($dellink);
        }
     }

     $delquery="DELETE FROM tbl_product WHERE productId='$id'";
     $delpro=$this->db->delete($delquery);
     if($delpro){
       $msg="<span class='success'>Product deleted successfully</span>";
       return $msg;
     }else{
       $msg="<span class='error'>Product not deleted</span>";
       return $msg;
     }
   }


public function getFeaturePro(){
  $query="SELECT * FROM tbl_product WHERE type='0' ORDER BY  productId DESC LIMIT 4";
  $result=$this->db->select($query);
  return $result;
}

public function getNewPro(){
  $query="SELECT * FROM tbl_product WHERE type='0' ORDER BY  productId DESC LIMIT 4";
  $result=$this->db->select($query);
  return $result;
}

public function getSingleProduct($id){
  $query="SELECT p.*, c.catName, b.brandName
      FROM tbl_product as p, tbl_category as c , tbl_brand as b
      WHERE p.catId=c.catId AND p.brandId=b.brandId AND p.productId='$id'";

  $result=$this->db->select($query);
  return $result;
}

public function getLatestApple(){
  $query="SELECT * FROM tbl_product WHERE brandId='3' ORDER BY productId DESC LIMIT 1";
  $result=$this->db->select($query);
  return $result;
}

public function getLatestSamsung(){
  $query="SELECT * FROM tbl_product WHERE brandId='4' ORDER BY productId DESC LIMIT 1";
  $result=$this->db->select($query);
  return $result;
}

public function getLatestAccer(){
  $query="SELECT * FROM tbl_product WHERE brandId='1' ORDER BY productId DESC LIMIT 1";
  $result=$this->db->select($query);
  return $result;
}

public function getLatestCannon(){
  $query="SELECT * FROM tbl_product WHERE brandId='7' ORDER BY productId DESC LIMIT 1";
  $result=$this->db->select($query);
  return $result;
}

public function productByCat($id){
  $id=mysqli_real_escape_string($this->db->link,$id);  //security perpose

  $query="SELECT * FROM tbl_product WHERE catId='$id'";
  $result=$this->db->select($query);
  return $result;
}

public function insertComData($cmrid,$compid){
  $cmrid     =mysqli_real_escape_string($this->db->link,$cmrid);
  $productId =mysqli_real_escape_string($this->db->link,$productId);
  $query="SELECT * FROM tbl_product WHERE productId='$productId' ";
  $result=$this->db->select($query)->fetch_assoc();
 if ($result) {

      $productId=$result['productId'];
      $productName=$result['productName'];
      $price=$result['price'];
      $image=$result['image'];

     $query="INSERT INTO tbl_compare(cmrid,productId,productName,price,image) VALUES('$cmrid','$productId','$productName','$price','$image')";
     $insert_row=$this->db->insert($query);

     if($insert_row){
       $msg="<span class='success'>Product Added to Compare successfully</span>";
       return $msg;
     }else{
       $msg="<span class='error'>Product not Added to Compare </span>";
       return $msg;
     }
    }
}




}


 ?>
