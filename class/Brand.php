<?php
include_once '../lib/database.php';
include_once '../helpers/Format.php';
 ?>

<?php
class Brand
{
  private $db;
  private $fm;

  public function __construct()
  {
         $this->db=new Database();
         $this->fm=new Format();
  }

  public function brandInsert($brandName){
    $brandName=$this->fm->validation($brandName);
    $brandName=mysqli_real_escape_string($this->db->link,$brandName);
    if (empty($brandName)) {
      $msg="<span class='error'>Brand Must not be Empty!!</span>";
      return $msg;
    }else{
      $query="INSERT INTO tbl_brand(brandName) VALUES('$brandName')";
      $brandinsert=$this->db->insert($query);
      if($brandinsert){
        $msg="<span class='success'>brand Inserted successfully</span>";
        return $msg;
      }else{
        $msg="<span class='error'>brand not Inserted successfully</span>";
        return $msg;
      }
    }
  }

  public function getAllBrand(){
    $query="SELECT * FROM tbl_brand ORDER BY brandId DESC";
    $result=$this->db->select($query);
    return $result;
  }

  public function getBrandById($id){
    $query="SELECT * FROM tbl_brand WHERE brandId='$id'";
    $result=$this->db->select($query);
    return $result;
  }

  public function brandUpdate($brandName,$id){
    $brandName=$this->fm->validation($brandName);
    $brandName=mysqli_real_escape_string($this->db->link,$brandName);
    $id=mysqli_real_escape_string($this->db->link,$id);
    if (empty($brandName)) {
      $msg="<span class='error'>Brand Must not be Empty!!</span>";
      return $msg;
    }else{
      $query="UPDATE tbl_brand
             SET
             brandName='$brandName'
             WHERE brandId='$id'";
             $update_row=$this->db->update($query);
             if($update_row){
               $msg="<span class='success'>Brand updated successfully</span>";
               return $msg;
             }else{
               $msg="<span class='error'>Brand not Updated</span>";
               return $msg;
             }
    }
  }


       public function delBrandById($id){
         $query="DELETE FROM tbl_brand WHERE brandId='$id'";
         $delbrand=$this->db->delete($query);
         if($delbrand){
           $msg="<span class='success'>Brand deleted successfully</span>";
           return $msg;
         }else{
           $msg="<span class='error'>Brand  not deleted</span>";
           return $msg;
         }
       }


}


 ?>
