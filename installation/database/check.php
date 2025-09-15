<?php 

$db_host = $_POST['db_host'];
$db_user = $_POST['db_user'];
$db_password = $_POST['db_password'];
$db_name = $_POST['db_name'];

$connection_error = false;

$db_table_names = [
'ads', 
'brands', 
'categories', 
'favorited_products', 
'favorited_reviews',
'favorited_users',
'featured_reviews',
'helpful_reviews',
'images',
'migrations',
'pages',
'password_resets',
'products',
'reported_reviews',
'reviews',
'settings',
];

$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (mysqli_connect_errno())
{ 
	$connection_error = true;
	?>

	<div class="form-group">
		Cannot connect to database. Please check database connection details bellow and try again <?php echo $not_ok; ?>
	</div>

	<?php } else  {

		$tables = mysqli_query($connection, "show tables from `".$db_name."`"); 
		$db_not_empty = false; ?>

		<div class="form-group">
			Connected to database <?php echo $ok; ?>
		</div>

		<?php  if($tables->num_rows > 0) { $db_not_empty = true; ?>
			<div class="form-group">
				<p>Database is not empty. To continue installation, please provide empty database <?php echo $not_ok; ?></p>
			</div>
			<?php } 
			
			$in_file = file_get_contents(PRIVATE_DIR.'.env.example');
			
			if($in_file === FALSE) echo ('Error writting to storage/app/installing file');			

			$content = str_replace('	', '', $in_file);
			$content = str_replace('DB_HOST=', 'DB_HOST='.$db_host, $content);
			$content = str_replace('DB_DATABASE=', 'DB_DATABASE='.$db_name, $content);
			$content = str_replace('DB_USERNAME=', 'DB_USERNAME='.$db_user, $content);
			$content = str_replace('DB_PASSWORD=', 'DB_PASSWORD='.$db_password, $content);

			$config_file = PRIVATE_DIR.'.env';

			$out_file_written = file_put_contents($config_file, $content);

			if ($out_file_written === FALSE) echo ('Error writting to .env file');
			if(!$connection_error && !$db_not_empty) {
				$out_file_written = file_put_contents(PRIVATE_DIR.'storage/app/installing', '');	
				if ($out_file_written === FALSE) echo ('Error writting to storage/app/installing file');
				?>

				<div>				
					<a href="install/start" class="btn btn-success">Start Installation</a>
				</div>

				<?php }
			}  