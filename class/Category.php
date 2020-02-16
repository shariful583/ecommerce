<?php
$filepath=realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/Format.php');

 ?>
<?php
/**
 *
 */
class Category{

    private $db;
    private $fm;

    public function __construct()
    {
           $this->db=new Database();
           $this->fm=new Format();
    }
    public function catInsert($catName){
      $catName=$this->fm->validation($catName);
      $catName=mysqli_real_escape_string($this->db->link,$catName);
      if (empty($catName)) {
        $msg="<span class='error'>Category Must not be Empty!!</span>";
        return $msg;
      }else{
        $query="INSERT INTO tbl_category(catName) VALUES('$catName')";
        $catinsert=$this->db->insert($query);
        if($catinsert){
          $msg="<span class='success'>Category Inserted successfully</span>";
          return $msg;
        }else{
          $msg="<span class='error'>Category not Inserted successfully</span>";
          return $msg;
        }
      }
    }

      public function getAllCat(){
        $query="SELECT * FROM tbl_category ORDER BY catId DESC";
        $result=$this->db->select($query);
        return $result;
      }


     public function getCatById($id){
       $query="SELECT * FROM tbl_category WHERE catId='$id'";
       $result=$this->db->select($query);
       return $result;
     }

     public function catUpdate($catName,$id){
       $catName=$this->fm->validation($catName);
       $catName=mysqli_real_escape_string($this->db->link,$catName);
       $id=mysqli_real_escape_string($this->db->link,$id);
       if (empty($catName)) {
         $msg="<span class='error'>Category Must not be Empty!!</span>";
         return $msg;
       }else{
         $query="UPDATE tbl_category
                SET
                catName='$catName'
                WHERE catId='$id'";
                $update_row=$this->db->update($query);
                if($update_row){
                  $msg="<span class='success'>Category updated successfully</span>";
                  return $msg;
                }else{
                  $msg="<span class='error'>Category not Updated</span>";
                  return $msg;
                }
       }
     }

     public function delCatById($id){
       $query="DELETE FROM tbl_category WHERE catId='$id'";
       $delcat=$this->db->delete($query);
       if($delcat){
         $msg="<span class='success'>Category deleted successfully</span>";
         return $msg;
       }else{
         $msg="<span class='error'>Category  not deleted</span>";
         return $msg;
       }
     }




    }








 ?>
