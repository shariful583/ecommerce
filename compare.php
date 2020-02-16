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
			    	<h2>Compare Product</h2>

						<table class="tblone">
							<tr>
                <th >SL</th>
								<th >Product Name</th>
								<th >Price</th>
								<th >Image</th>
								<th >Action</th>
							</tr>

              <?php
               $getpro=$ct->getCartProduct();
                 if ($getpro) {
                   $i=0;

                    while ($result=$getpro->fetch_assoc()) {
                      $i++;
               ?>
							<tr>
                <td><?php echo $i; ?></td>
								<td><?php echo $result['productName']; ?></td>
								<td><img src="admin/<?php echo $result['image'] ?>" alt=""/></td>
								<td>$<?php echo $result['price']; ?></td>
                <td> <a href="details.php?proid=<?php echo $result['productId']; ?>">View</a> </td>
              </tr>
            <?php }} ?>


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
