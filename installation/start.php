<h3>System requirements</h3>
<div class="row col-md-8 col-lg-8">
	<table class="table">
		<tr>
			<td><b>PHP version</b></td>
			<td>
				<?php include(__DIR__.'/php_version.php'); ?>
			</td>
		</tr>

		<tr>
			<td colspan="2"><b>PHP Extensions</b></td>
		</tr>

		<?php include(__DIR__.'/php_extensions.php'); ?>

		<tr>
			<td colspan="2"><b>Folders</b></td>
		</tr>

		<?php include(__DIR__.'/permissions/folders.php'); ?>

		<tr>
			<td colspan="2"><b>Files</b></td>
		</tr>

		<?php include(__DIR__.'/permissions/files.php'); ?>				

	</table>
</div>

<div class="clearfix"></div>

<?php 
if($requirements_met == 'yes') { ?>

<p>
	<h4>All system requirements met</h4>
	Press Next to continue
</p>

<p>
	<form action="install.php" method="POST">
		<input type="hidden" name="requirements_met" value="<?php echo $requirements_met; ?>"/>
		<button type="submit" name="submit" class="btn btn-success">Next</button>
	</form>
</p>

<?php
} else { ?>
<p>
	<h4>Not all system requirements are met <?php echo $not_ok ?></h4>
	Please correct the errors above and try again.
</p>	

<?php } 