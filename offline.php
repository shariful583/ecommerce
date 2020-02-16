<?php include 'inc/header.php'; ?>
<?php
 $login=Session::get('cuslogin');
 if ($login==false) {
   header("Location:login.php");
 }
 ?>

 <?php

if (isset($_GET['orderid']) && $_GET['orderid']=='order') {
  $cmrid=Session::get('cmrid');
  $insertOrder=$ct->OrderProduct($cmrid);
  header('Location:order.php');
  $deldata=$ct->delCustomerCart();

}

  ?>
<style>
.division{width:50%;float: left;}
.division1{width: 40%;float: left;}
.tblone{
  width: 500px;
  margin: 0 auto;
  border:2px solid #ddd;
}
.tblone tr td{
  text-align: justify;
}
.tbltwo{width: 60%;float: right;text-align: left;border: 2px solid #ddd;margin-right: 40px;margin-top: 12px;}
.tbltwo tr td{text-align: justify;padding: 5px 10px;}
.ordernow{padding-bottom: 30px;}
.ordernow a{width: 200px;margin: 20px auto 0;text-align: center;padding: 5px;font-size: 30px;display: block;background: red;color: white;border-radius: 3px;}
</style>


 <div class="main">
    <div class="content">
    	<div class="section group">
      <div class="division">
        <table class="tblone">
          <tr>
            <th >No</th>
            <th >Product</th>
            <th >Price</th>
            <th >Quantity</th>
            <th >Total</th>
          </tr>

          <?php
           $getpro=$ct->getCartProduct();
             if ($getpro) {
               $i=0;
               $sum=0;
               $qty=0;
                while ($result=$getpro->fetch_assoc()) {
                  $i++;
           ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $result['productName']; ?></td>

            <td>$<?php echo $result['price']; ?></td>
            <td>
                  <form action="" method="post">

                <input type="hidden" name="cartId" value="<?php echo $result['cartId']; ?>"/>
                    <input type="number" name="quantity" value="<?php echo $result['quantity']; ?>"/>
                    <input type="submit" name="submit" value="Update"/>
                  </form>
            </td>
          <td>$<?php
          $total=$result['price'] * $result['quantity'];
           echo $total ;
          ?></td>

          </tr>
          <?php
             $qty=$qty + $result['quantity'];
             $sum=$sum + $total;
             Session::set("sum","$sum");
           ?>

        <?php }} ?>

<hr style="padding-top:0px;padding-bottom:2px solid green;">
        </table>

            <?php
              $getData=$ct->checkCartTable();
              if ($getData) {

             ?>
        						<table class="tbltwo">
        							<tr>
        								<td>Sub Total : </td>
        								<td>$ <?php echo $sum; ?></td>
        							</tr>
        							<tr>
        								<td>VAT : </td>
        								<td>10%</td>
        							</tr>
        							<tr>
        								<td>Grand Total :</td>
        								<td>
                          <?php
                              $vat=$sum * 0.1;
                              $gtotal=$sum + $vat;
                              echo $gtotal;
                           ?>
                        </td>
        							</tr>
                      <tr>
                        <td>Quantity: </td>

        								<td> <?php echo $qty; ?></td>
        							</tr>
        					   </table>

                  <?php }else {
                     // echo "cart Empty! plese shop now";
                     header("Location:success.php");
                   }?>



      </div>

      <div class="division1">
        <?php
          $id=Session::get("cmrid");
          $getdata=$cmr->getCustomerData($id);
        if ($getdata) {
           while($result=$getdata->fetch_assoc()) {


         ?>
      <table class="tblone" >
        <tr>
          <td colspan="3"><h2>Customer Profile Details</h2></td>
        </tr>
        <tr>
          <td width="20%">Name</td>
          <td width="5%">:</td>
          <td><?php echo $result['name']; ?></td>
        </tr>
        <tr>
          <td>Email</td>
          <td>:</td>
          <td><?php echo $result['email']; ?></td>
        </tr>
        <tr>
          <td>Address</td>
          <td>:</td>
          <td><?php echo $result['address']; ?></td>
        </tr>
        <tr>
          <td>Phone Number</td>
          <td>:</td>
          <td><?php echo $result['phone']; ?></td>
        </tr>
        <tr>
          <td>City</td>
          <td>:</td>
          <td><?php echo $result['city']; ?></td>
        </tr>
        <tr>
          <td>Country</td>
          <td>:</td>
          <td><?php echo $result['country']; ?></td>
        </tr>
        <tr>
          <td>Zip code</td>
          <td>:</td>
          <td><?php echo $result['zip']; ?></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td> <a href="editprofile.php">Update Shiping Address</a> </td>
        </tr>

      </table>

    <?php } } ?>
      </div>
 		</div>
 	</div>
  <div class="ordernow">
    <a href="?orderid=order">Order</a>
  </div>
	</div>
   <?php include 'inc/footer.php'; ?>
