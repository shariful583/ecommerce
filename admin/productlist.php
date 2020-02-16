<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include_once '../helpers/Format.php'; ?>
<?php include '../class/Product.php'; ?>

<?php
$pro=new Product();
$fm=new Format();

if(isset($_GET['delpro'])){
  $id=$_GET['delpro'];
  $delPro=$pro->delProById($id);
}

 ?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Post List</h2>
        <div class="block">

          <?php
          if(isset($delPro)){
            echo $delPro;
          }
           ?>
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>SL</th>
					<th>productName</th>
					<th>Category</th>
					<th>Brand</th>
          <th>Description</th>
          <th>Price</th>
          <th>Image</th>
          <th>TYpe</th>
					<th>ACtion</th>
				</tr>
			</thead>
			<tbody>

        <?php
         $getPd=$pro->getAllProduct();
         if($getPd){
           $i=0;
           while($result=$getPd->fetch_assoc()){
             $i++

         ?>
				<tr class="odd gradeX">
					<td><?php echo $i; ?></td>
          <td><?php echo $result['productName']; ?></td>
          <td><?php echo $result['catName']; ?></td>
          <td><?php echo $result['brandName']; ?></td>
          <td><?php echo $fm->textShorten($result['body'],50); ?></td>
          <td>$<?php echo $result['price']; ?></td>
          <td> <img src="<?php echo $result['image']; ?>" alt="" height="50px" width="60px"> </td>
          <td>
            <?php
            if($result['type']==0){
              echo "Featured";
            }else{
              echo "General";
            }
             ?>
          </td>

					<td><a href="proedit.php?proid=<?php echo $result['productId']; ?>">Edit</a> || <a onclick="return confirm('Are you sure you want to delete')" href="?delpro=<?php echo $result['productId']; ?>">Delete</a></td>
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
