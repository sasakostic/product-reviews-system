<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
	$(function(){
		$('#show_hide').click(function(){
			if($('#password').prop('type') == 'text') {
				$('#password').prop('type', 'password');
				$('#show_hide').text('show');
			} else {
				$('#password').prop('type', 'text');
				$('#show_hide').text('hide');
			}
		});
		
	});//document ready
</script>
<form method="POST" action="install.php">
	<div>
		<h3 class="page-header">Database connection details</h3>

		<div class="row">
			<div class="form-group col-lg-3 col-md-3">
				<label>Database Name</label>
				<input type="text" name="db_name" id="db_name" class="form-control"  value="<?php if(isset($_POST['db_name'])) echo $_POST['db_name']; else echo 'reviews'; ?>" required autofocus>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-lg-3 col-md-3">
				<label>Username</label>
				<input type="text" name="db_user" class="form-control" value="<?php if(isset($_POST['db_user'])) echo $_POST['db_user']; else echo 'root'; ?>" required>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-lg-3 col-md-3">
				<label>Password</label> <a href="javascript:" id="show_hide">show</a>
				<input type="password" id="password" name="db_password" class="form-control" value="<?php if(isset($_POST['db_password'])) echo $_POST['db_password']; else echo ''; ?>"  autocomplete="off">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-lg-3 col-md-3">
				<label>Database Host</label>
				<input type="text" name="db_host" class="form-control" value="<?php if(isset($_POST['db_host'])) echo $_POST['db_host']; else echo 'localhost'; ?>" required>
			</div>
		</div>
	</div>

	<div>
		<input type="hidden" name="requirements_met" value="<?php echo $requirements_met; ?>"/>
		<button type="submit" name="submit" value="check_database" class="btn btn-success">Submit</button>
	</div>
</form>