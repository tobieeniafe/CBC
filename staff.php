<?php
include 'dbconnect.php';
?>

<?php
session_start();
if (!$_SESSION['cbc_staff']) {
	header('location: login_staff.php');
}
$session_user = $_SESSION['cbc_staff'];
$session_password  = $_SESSION['password'];
$sql = "SELECT * FROM `users` WHERE username='$session_user' AND password='$session_password' ";
$query = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array($query , MYSQLI_ASSOC) ) {	$session_id = $row['user_id'];}
//echo $session_id;
?>


<div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">

            	<li><a href="#" id="announcements" class="active">Announcements <span class="glyphicon glyphicon-bullhorn"></span></a></li>

                <li><a href="#" id="my_details">My Details <span class="glyphicon glyphicon-user"></span></a></li>

                <li><a href="#" id="leave_absences">Leave & Absences <span class="glyphicon glyphicon-log-out"></span></a></li>

                <li><a href="#" id="settings">Settings <span class="glyphicon glyphicon-cog"></span></a></li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">

                        
                <div class="row">
	                <div class="col-md-1">
	                   	<a href="#menu-toggle" class="btn btn-default" id="menu-toggle" style="background-color:#e6e6e6">&#9776; Menu</a>
	                </div>
	                <div class="col-md-3"></div>
	                <div class="col-md-6">
	                    <i><h4>Welcome <?php echo $session_user ?>, today is <?php echo date("l jS \of F Y ") ?></h4></i>
	                    
	                </div>
	                <div class="col-md-1">
	                    <a href="logout.php" class="btn btn-default" style="background-color:#e6e6e6"><span class="glyphicon glyphicon-off"> Logout</span></a>
	                </div>
	                <div class="col-md-1"></div>
                </div>
                        <br>

		<?php
       	if (isset($_POST["edit_user_btn"])) {
			$username = $_POST['username'];
			$current_password = $_POST['current_password'];
			$new_password = $_POST['new_password'];
			$confirm_password = $_POST['confirm_password'];

			if ($new_password == $confirm_password && $session_password == $current_password) {
				$sql = "UPDATE `users` SET `username`= '$username',`password`= '$new_password' WHERE `username` = '$session_user' AND `password` = '$current_password' ";
				mysqli_query($conn,$sql);

				?>
	        <style type="text/css">
	            #settings_page {
	                display: block;
	            }
	            #announcements_page {
					display: none;
				}
	        </style>
	        <script type="text/javascript">	            
	            $(window).load(function(){
	            	$('#announcements').removeClass('active');
	   				$('#settings').addClass('active');
	   			});
	   			window.alert('Username & Password changed Successfully');
	   			window.alert('Please re-login for password change to take effect');
	        </script>
	        
	        <?php 
	        	//header('location: logout.php');
			        }
		    else{
		    	?>
	        <style type="text/css">
	            #settings_page {
	                display: block;
	            }
	            #activity_page {
					display: none;
				}
	        </style>
	        <script type="text/javascript">	            
	            $(window).load(function(){
	            	$('#activity').removeClass('active');
	   				$('#settings').addClass('active');
	   			});
	   			window.alert('Sorry your passwords don\'t match');
	        </script>
	        
	        <?php 
		    	//$message = "Sorry your passwords don't match";
			    }
		} 

		else if (isset($_POST["apply_leave_btn"])) {
	        $user_id = $_POST['user_id'];
	        $fullname = $_POST['fullname'];
	        $start_date = $_POST['start_date'];
	        $end_date = $_POST['end_date'];
	        $reason = $_POST['reason'];
	        $status = $_POST['status'];

	        $sql = "INSERT INTO `leave_absences` (`user_id`, `fullname`, `reason`, `start_date`, `end_date`, `status`) VALUES ('$user_id','$fullname','$reason','$start_date','$end_date','$status')";
		        if (mysqli_query($conn,$sql)){
		        ?>
		        <style type="text/css">
		            #leave_absences_page {
		                display: block;
		            }
		            #announcements_page {
						display: none;
					}
		        </style>
		        <script type="text/javascript">	            
		            $(window).load(function(){
		            	$('#announcements').removeClass('active');
	   					$('#leave_absences').addClass('active');
		   			});
		   			window.alert('Application Successful');
		        </script>
		        
		        <?php 
		       
		    }
		}

			?>



                <!-- Announcements page -->

                <div id="announcements_page">
     	
		    	<i><h1>Announcements</h1></i>
		    	
		    	<div class="row">

		    		<div class="col-md-2" id="events">
		    			<img src="images/calendar.png" style="width: 100px;height: 100px;"><h5><b>Reminders for today</b></h5>
		    			<?php
							$date = date("Y-m-d").'%'; 
		    			
							$sql = "SELECT `event_title` , `start_time`  FROM `events_meetings` WHERE `date_from` LIKE '$date' AND `color` = '#26c6da' ORDER BY `start_time` ASC";
							$query = mysqli_query($conn,$sql); 
							while ($row = mysqli_fetch_array($query , MYSQLI_ASSOC) ) {											
							echo '<h5>'.$row['event_title'].'   '.substr($row['start_time'], 0 ,5).'</h5>';
							}
						?>
		    		</div>

		    		<div class="col-md-5"></div>
		    		
		    		<div class="col-md-2" id="birthdays">
		    			<img src="images/birthday-cake.png" style="width: 100px;height: 100px;"><h5><b>Birthdays this month</b></h5>
						<?php
							$date = '____-'.date('m').'%';
							$sql = "SELECT FirstName , LastName , D_O_B FROM `personal_information` WHERE `D_O_B` LIKE '$date' ORDER BY `D_O_B` ASC";
							$query = mysqli_query($conn,$sql); 
							while ($row = mysqli_fetch_array($query , MYSQLI_ASSOC) ) {
							$fullname = $row['LastName'].' '.$row['FirstName'];														
							echo '<h5>'.$fullname.'   '.date('Y').'-'.substr($row['D_O_B'], 5).'</h5>';

							}
						?>
		    		</div>

					<div class="col-md-2" id="weddings">
		    			<img src="images/wedding-cake.png" style="width: 100px;height: 100px;"><h5><b>Wedding Anniversaries this month</b></h5>
						<?php
							$date = '____-'.date('m').'%';
							$sql = "SELECT FirstName , LastName ,Marriage_Date FROM `personal_information` WHERE `Marriage_Date` LIKE '$date' ORDER BY `Marriage_Date` ASC";
							$query = mysqli_query($conn,$sql); 
							while ($row = mysqli_fetch_array($query , MYSQLI_ASSOC) ) {
							$fullname = $row['LastName'].' '.$row['FirstName'];														
							echo '<h5>'.$fullname.'   '.date('Y').'-'.substr($row['Marriage_Date'], 5).'</h5>';
							}
						?>
		    		</div>	

		    	</div>

                </div>
                <!-- End Announcements page -->




                <!-- My Details Page -->
                <div id="my_details_page">
                	My Details
                </div>
                <!-- End My Details Page -->




                <!-- Leave & Absences Page -->

                <div id="leave_absences_page">

                	<h3>Leave & Absences</h3>
						
                	<div class="row">
	                	<div class="col-md-4"><form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">

	                		<?php		    			
							$sql = "SELECT * FROM `users` WHERE `username` = '$session_user' ";
							$query = mysqli_query($conn,$sql); 
							while ($row = mysqli_fetch_array($query , MYSQLI_ASSOC) ) {											
							//echo '<h5>'.$row['firstname'].'   '.$row['user_id'].'</h5>';
							
							?>
	                		<div class="row">
	                			<div class="col-md-4"><input type="number" class="form-control" name="user_id" readonly="" value="<?php echo $row['user_id'] ?>"></div>
	                			<div class="col-md-8"><input type="text" class="form-control" name="fullname" readonly="" value="<?php echo $row['lastname'].' '.$row['firstname'] ?>"></div>
	                		</div>

	                		<div class="row">
	                			<div class="col-md-6"><label>From</label><input type="date" class="form-control" name="start_date"></div>
	                			<div class="col-md-6"><label>To</label><input type="date" class="form-control" name="end_date"></div>
	                		</div>

	                		<div class="row">
		                		<div class="col-md-6"><label>Reason</label><select class="form-control" name="reason">
		                			<option>OFFICIAL LEAVE</option>
		                			<option>SICK LEAVE</option>
		                			<option>STUDY LEAVE</option>
		                			<option>MATERNITY LEAVE</option>
		                			<option>PATERNITY LEAVE</option>
		                		</select></div>
		                		<div class="col-md-6"><label>Status</label><select class="form-control" name="status" readonly="">
		                			<option selected="">PENDING</option>
		                		</select></div>
	                		</div>
	                		<p></p>
	                		<input type="submit" class="btn btn-primary" name="apply_leave_btn" value="Apply">

	                	</form></div>

	                	<div class="col-md-6">
	                		<?php		    			
							$sql = "SELECT * FROM `leave_absences` WHERE `user_id` = '$session_id' ";
							$query = mysqli_query($conn,$sql); 
							while ($row = mysqli_fetch_array($query , MYSQLI_ASSOC) ) {											
							//echo '<h5>'.$row['firstname'].'   '.$row['user_id'].'</h5>';
							
							?>
								<table class="table table-responsive">
								<tr>
									<td><?php echo $row['user_id'] ?></td>
									<td><?php echo $row['fullname'] ?></td>
									<td><?php echo $row['reason'] ?></td>
									<td><?php echo $row['start_date'] ?></td>
									<td><?php echo $row['end_date'] ?></td>
									<td><?php echo $row['status'] ?></td>
								</tr>
								</table>

							<?php 
							} 
							?>
	                	</div>



                	</div>
                	<?php
                	}
                	?>


                </div>

                <!-- End Leave & Absences Page -->




				<!-- Settings Page --> 

		       	<div id="settings_page">

		       		<h4>Update Username & Password </h4>
		       		<?php
						$sql = "SELECT * FROM `users` WHERE `username` = '$session_user' AND `status` = 'staff'";
						$query = mysqli_query($conn,$sql); 
						while ($row = mysqli_fetch_array($query , MYSQLI_ASSOC) ) {
					?>
					<div class="row"> 
						<div class="col-md-4">
						<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
			       			<label>Username</label>
				       		<input type="text" class="form-control" name="username" placeholder="username" value="<?php echo $row['username'] ?>" required="">
				       		<label>Current Password</label>
				       		<input type="password" class="form-control" name="current_password" placeholder="current password" required="">
				       		<label>New Password</label>
				       		<input type="password" class="form-control" name="new_password" placeholder="new password" required="">
				       		<label>Confirm Password</label>
				       		<input type="password" class="form-control" name="confirm_password" placeholder="confirm password" required="">
				       		<p></p>
				       		<input type="submit" class="btn btn-info" name="edit_user_btn" value="Save">
			       		</form>
			       		<h5>*Note if your password is changed successfully, you will be required to sign in again</h5>
			       		</div>
			       		
						<?php
							}

						?>
		       		</div>

		       	</div>


		       	 <!-- End Settings Page --> 







            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->


<script type="text/javascript">
	   $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

	   $(document).ready(function(){

	   	$('#announcements').click(function(){
	   		$('#announcements_page').css('display','block');
	   		$('#my_details_page').css('display','none');
	   		$('#leave_absences_page').css('display','none');
	   		$('#settings_page').css('display','none');

	   		$('#announcements , #my_details , #leave_absences , #settings').removeClass('active');
	   		$(this).addClass('active');

	   	});

	   	$('#my_details').click(function(){
	   		$('#announcements_page').css('display','none');
	   		$('#my_details_page').css('display','block');
	   		$('#leave_absences_page').css('display','none');
	   		$('#settings_page').css('display','none');

	   		$('#announcements , #my_details , #leave_absences , #settings').removeClass('active');
	   		$(this).addClass('active');
	   	});


	   	$('#leave_absences').click(function(){
	   		$('#announcements_page').css('display','none');
	   		$('#my_details_page').css('display','none');
	   		$('#leave_absences_page').css('display','block');
	   		$('#settings_page').css('display','none');

	   		$('#announcements , #my_details , #leave_absences , #settings').removeClass('active');
	   		$(this).addClass('active');
	   	});

	   	$('#settings').click(function(){
	   		$('#announcements_page').css('display','none');
	   		$('#my_details_page').css('display','none');
	   		$('#leave_absences_page').css('display','none');
	   		$('#settings_page').css('display','block');

	   		$('#announcements , #my_details , #leave_absences , #settings').removeClass('active');
	   		$(this).addClass('active');
	   	});

	});


</script>
