<?php include 'inc/header.php'; ?>

<?php
 $login=Session::get('cuslogin');
 if ($login==true) {
   header("Location:index.php");
 }
 ?>
<?php
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['login'])) {
  $customerLogin=$cmr->customerLogin($_POST);
}
 ?>
 <div class="main">
    <div class="content">
    	 <div class="login_panel">
         <?php if (isset($customerLogin)) {
             echo $customerLogin;
         } ?>
        	<h3>Existing Customers</h3>
        	<p>Sign in with the form below.</p>
        	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="member">
                	<input name="email" type="text" placeholder="Enter email...">
                    <input name="pass" type="password" placeholder="Enter Password..">

                      <div class="buttons"><div><button class="grey" name="login">Sign In</button></div></div>
                 </form>


                    </div>

                    <?php
                    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['register'])) {
                      $customerReg=$cmr->customerRegter($_POST);
                    }
                     ?>
    	<div class="register_account">
        <?php if (isset($customerReg)) {
             echo $customerReg;
        } ?>
    		<h3>Register New Account</h3>
    		<form action="" method="post">
		   			 <table>
		   				<tbody>
						<tr>
						<td>
							<div>
							<input type="text" name="name" placeholder="Enter name...">
							</div>

							<div>
							   <input type="text" name="city" placeholder="Enter city..." >
							</div>

							<div>
								<input type="text" name="zip" placeholder="Enter zip..."  >
							</div>
							<div>
								<input type="text" name="email" placeholder="Enter email..."  >
							</div>
		    			 </td>
		    			<td>
						<div>
							<input type="text" name="address" placeholder="Enter address..."  >
						</div>
            <div>
              <input type="text" name="country" placeholder="Enter country..."  >
            </div>

		           <div>
		          <input type="text" name="phone" placeholder="Enter phone..."  >
		          </div>

				  <div>
					<input type="password" name="pass" placeholder="Enter password..." >
				</div>

		    	</td>
		    </tr>
		    </tbody></table>
		   <div class="search"><div><button class="grey" name="register">Create Account</button></div></div>

		    <div class="clear"></div>
		    </form>
    	</div>
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php'; ?>
