<?php include 'inc/header.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $cartId=$_POST['cartId'];
  $quantity=$_POST['quantity'];
  $updateCart=$ct->updateCartQn($quantity,$cartId);

  if($quantity <=0){
    $delCartPro=$ct->delCartProById($cartId);

  }
}

if(isset($_GET['delCartPro'])){
  $delid=$_GET['delCartPro'];
  $delCartPro=$ct->delCartProById($delid);

}
 ?>

 <?php
  if(!isset($_GET['id'])){
    echo "<meta http-equiv='refresh' content='0;URL=?id=live' />";
  }

  ?>

 <div class="main">
    <div class="content">
    	<div class="cartoption">
			<div class="cartpage">
			    	<h2>Your Cart</h2>
            <?php
              if(isset($updateCart)){
                echo $updateCart;
              }

              if(isset($delCartPro)){
                echo $delCartPro;
              }
             ?>
						<table class="tblone">
							<tr>
                <th width="5%">SL</th>
								<th width="30%">Product Name</th>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								<th width="15%">Quantity</th>
								<th width="15%">Total Price</th>
								<th width="10%">Action</th>
							</tr>

              <?php
               $getpro=$ct->getCartProduct();
                 if ($getpro) {
                   $i=0;
                   $sum=0;
                    while ($result=$getpro->fetch_assoc()) {
                      $i++;
               ?>
							<tr>
                <td><?php echo $i; ?></td>
								<td><?php echo $result['productName']; ?></td>
								<td><img src="admin/<?php echo $result['image'] ?>" alt=""/></td>
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
								<td><a onclick="return confirm('Are you sure you want to delete')" href="?delCartPro=<?php echo $result['cartId']; ?>">X</a></td>
							</tr>
              <?php
                 $sum=$sum + $total;
                 SEssion::set("sum","$sum");
               ?>

            <?php }} ?>

<hr style="padding-top:0px;padding-bottom:2px solid green;">
						</table>

    <?php
      $getData=$ct->checkCartTable();
      if ($getData) {

     ?>
						<table style="float:right;text-align:left;" width="40%">
							<tr>
								<th>Sub Total : </th>
								<td>$ <?php echo $sum; ?></td>
							</tr>
							<tr>
								<th>VAT : </th>
								<td>10%</td>
							</tr>
							<tr>
								<th>Grand Total :</th>
								<td>
                  <?php
                      $vat=$sum * 0.1;
                      $gtotal=$sum + $vat;
                      echo $gtotal;
                   ?>
                </td>
							</tr>
					   </table>

                   <?php }else {
                      // echo "cart Empty! plese shop now";
                      header("Location:index.php");
                    }?>

					</div>
					<div class="shopping">
						<div class="shopleft">
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
						<div class="shopright">
							<a href="payment.php"> <img src="images/check.png" alt="" /></a>
						</div>
					</div>
    	</div>
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php'; ?>
