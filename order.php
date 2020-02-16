<?php include 'inc/header.php'; ?>

<?php
 $login=Session::get('cuslogin');
 if ($login==false) {
   header("Location:login.php");
 }
 ?>

 <?php
 if (isset($_GET['confirmid'])) {
  $id=$_GET['confirmid'];
  $date=$_GET['date'];
  $price=$_GET['price'];
  $confirm=$ct->productConfirm($id,$date,$price);
}
  ?>

<style >
.notfound{}
  .notfound h2{font-size: 50px;line-height: 130px;text-align: center;}
  .notfound h2 span{display: block;color: red;font-size: 50px;}
  .tblone tr td{
    text-align:;
  }
</style>

 <div class="main">
    <div class="content">
      <div class="seltion group">
          <div class="notfound">
            <h2>Order Details</h2>
            <table class="tblone">
              <tr>
                <th >No</th>
                <th >Product Name</th>
                <th >Image</th>
                <th >Quantity</th>
                <th >Price</th>
                <th >Date</th>
                <th >Status</th>
                <th >Action</th>
              </tr>

              <?php
              $cmrid=Session::get("cmrid");
               $getOrder=$ct->getOrderProduct($cmrid);
                 if ($getOrder) {
                   $i=0;

                    while ($result=$getOrder->fetch_assoc()) {
                      $i++;
               ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $result['productName']; ?></td>
                <td><img src="admin/<?php echo $result['image'] ?>" alt=""/></td>
                <td><?php echo $result['quantity']; ?></td>

              <td><?php echo $result['price']; ?></td>
              <td><?php echo $fm->formatDate($result['date']); ?></td>
              <td>
                <?php
                  if ($result['status']=='0') {
                     echo 'Pending';
                  }elseif($result['status']=='1'){
                    echo "Shifted";
                }else{
                    echo "OK";
                  }
                ?>
              </td>
                <?php
                if ($result['status']=='1') { ?>
                   <td><a href="?confirmid=<?php echo $cmrid; ?>& price=<?php echo $result['price']; ?>& date=<?php echo $result['date']; ?>">Confirm</a></td>

                <?php }elseif($result['status']=='2'){ ?>
                  <td>OK</td>
                <?php }elseif($result['status']=='0'){ ?>
                    <td>N/A</td>
                <?php }?>
              </tr>


            <?php }} ?>

<hr style="padding-top:0px;padding-bottom:2px solid green;">
            </table>
          </div>
      </div>

       <div class="clear"></div>
    </div>
 </div>
 <?php include 'inc/footer.php'; ?>
