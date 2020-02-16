<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
$filepath=realpath(dirname(__FILE__));
include_once ($filepath.'/../class/Cart.php');
$ct=new Cart();
$fm=new Format();
?>
<?php
 if (isset($_GET['shiftid'])) {
  $id=$_GET['shiftid'];
  $date=$_GET['date'];
  $price=$_GET['price'];
  $shift=$ct->productShifted($id,$date,$price);
}

if (isset($_GET['delOrderid'])) {
 $id=$_GET['delOrderid'];
 $date=$_GET['date'];
 $price=$_GET['price'];
 $delOrder=$ct->delOrderProduct($id,$date,$price);
}
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Inbox</h2>
                <?php if (isset($shift)) {
                  echo $shift;
                } ?>

                <?php if (isset($delOrder)) {
                  echo $delOrder;
                } ?>
                <div class="block">
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Id</th>
              <th>Date</th>
              <th>Product</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>custId</th>
							<th>Address</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
            <?php

             $getOrder=$ct->getAllOrderPro();
             if ($getOrder) {
                while ($result=$getOrder->fetch_assoc()) {


             ?>
						<tr class="odd gradeX">
							<td><?php echo $result['id'] ?></td>
              <td><?php echo $fm->formatDate($result['cmrid']); ?></td>
              <td><?php echo $result['productName']; ?></td>
              <td><?php echo $result['quantity']; ?></td>
              <td><?php echo $result['price'] ?></td>
              <td><?php echo $result['cmrid'] ?></td>
							<td> <a href="customer.php?custId=<?php echo $result['cmrid']; ?>">View details</a>
               </td>
               <?php if ($result['status']=='0') {?>
                  <td><a href="?shiftid=<?php echo $result['cmrid']; ?>& price=<?php echo $result['price'] ?>& date=<?php echo $result['date']; ?>">Shifted</a></td>
              <?php }elseif($result['status']=='1'){ ?>
                <td>Pending</td>
              <?php }else{ ?>
                    <td><a href="?delOrderid=<?php echo $result['cmrid']; ?>& price=<?php echo $result['price'] ?>& date=<?php echo $result['date']; ?>">Remove</a></td>
              <?php }?>
						</tr>
        <?php }} ?>
					</tbody>
				</table>
               </div>
            </div>
        </div>
<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
