
<?php
include 'dbconnect.php';
session_start();
session_unset();
session_destroy();
?>

<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
	    <i><h3 style="float: right;"><?php echo date("l jS \of F Y ") ?></h3></i>
	</div>
	<div class="col-md-4"></div>
</div>

                        <br>
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-2">
		<a href="login.php" class="btn btn-primary btn-lg" style="min-height:150px; min-width:170px"><br><h4>Sign In As Admin<br><p></p><span class="glyphicon glyphicon-user" style="font-size: 30px"></span></h4></a>
	</div>
	<div class="col-md-2" style="min-height:150px; min-width:170px"></div>
	<div class="col-md-2">
		<a href="login_staff.php" class="btn btn-primary btn-lg" style="min-height:150px; min-width:170px"><br><h4>Sign In As Staff<br><p></p><i class="fa fa-users" style="font-size: 30px"></i></h4></a>
	</div>
	<div class="col-md-3"></div>
</div>



