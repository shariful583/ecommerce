<?php include 'inc/header.php'; ?>
<?php
 $login=Session::get('cuslogin');
 if ($login==false) {
   header("Location:login.php");
 }
 ?>

 <?php
 $cmrid=Session::get('cmrid');

 if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])) {
   $updatecmr=$cmr->customerUpdate($_POST,$cmrid);
 }
  ?>

<style>
  .tblone{
    width: 550px;
    margin: 0 auto;
    border:2px solid #ddd;
  }
  .tblone tr td{
    text-align: justify;
  }
  .tblone input[type="text"]{
    width: 400px;padding: 5px; font-size: 15px;
  }
</style>


 <div class="main">
    <div class="content">
    	<div class="section group">
        <?php
          $id=Session::get("cmrid");
          $getdata=$cmr->getCustomerData($id);
        if ($getdata) {
           while($result=$getdata->fetch_assoc()) {


         ?>
         <form class="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">


      <table class="tblone">
        <?php
         if (isset($updatecmr)) {?>
            <td colspan="2"><h2><?php echo $updatecmr; ?></h2></td>
      <?php  } ?>
        <tr>
          <td colspan="2"><h2>Customer Profile Update</h2></td>
        </tr>
        <tr>
          <td width="20%">Name</td>
       <td><input type="text" name="name" value="<?php echo $result['name']; ?>"></td>

        </tr>
        <tr>
          <td>Email</td>
            <td><input type="text" name="email" value="<?php echo $result['email']; ?>"></td>
        </tr>
        <tr>
          <td>Address</td>
          <td><input type="text" name="address" value="<?php echo $result['address']; ?>"></td>
        </tr>
        <tr>
          <td>Phone Number</td>
            <td><input type="text" name="phone" value="<?php echo $result['phone']; ?>"></td>

        </tr>
        <tr>
          <td>City</td>
          <td><input type="text" name="city" value="<?php echo $result['city']; ?>"></td>

        </tr>
        <tr>
          <td>Country</td>
          <td><input type="text" name="country" value="<?php echo $result['country']; ?>"></td>
        </tr>
        <tr>
          <td>Zip code</td>

          <td><input type="text" name="zip" value="<?php echo $result['zip']; ?>"></td>
        </tr>
        <tr>
          <td></td>
          <td> <input type="submit" name="submit" value="update"> </td>
        </tr>
      </table>
        </form>

    <?php } } ?>
 		</div>
 	</div>
	</div>
   <?php include 'inc/footer.php'; ?>
