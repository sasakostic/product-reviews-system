<?php namespace App\Http\Controllers;

use App\Http\Controllers\ProductsController as Products;

use Redirect;
use Input;
use Faker;
use Hash;

use Eloquent;
use DB;
use Schema;
use Artisan;

use App\Category;
use App\Brand;
use App\Product;
use App\Review;
use App\ReportedReview;

class DevelopmentController extends Controller
{

  private $num_of_users = 10;
  private $num_of_categories = 10;
  private $num_of_brands = 10;
  private $num_of_products = 20;
  private $num_of_reviews = 50;

  private $category_name_len = 20;
  private $brand_name_len = 10;
  private $product_name_len = 50;
  private $product_description_len_min = 300;
  private $product_description_len_max = 500;
  private $review_text_len_min = 400;
  private $review_text_len_max = 1400;

  public function __construct()
  {
    set_time_limit(0);
  }

  public function getIndex() 
  {   
    return view('dev/index');
  }

  public function getResetInstallation() 
  {

    file_put_contents(base_path().'/.env', file_get_contents(base_path().'/.env.example'));

    if(file_exists(storage_path('app/installing'))) unlink(storage_path('app/installing'));
    if(file_exists(storage_path('app/installed'))) unlink(storage_path('app/installed'));

    return Redirect::to('/')->with('success', 'Instalation reset successfully');    

  }

  public function getResponsiveDesign()
  {

    $screens = [
    ['Small mob', 255, 320],
    ['Iphone 6', 375, 667],
    ['Iphone 5', 320, 568],
    ];

    $output = '';

    foreach($screens as $screen) {
      $output.= '

      <iframe sandbox="allow-same-origin allow-forms allow-scripts" seamless="" width="'.$screen[1].'" height="'.$screen[2].'" src="http://reviews"></iframe>';
    }
    return $output;
  }

  public function getReportAllReviews()
  {

    $faker = Faker\Factory::create();

    if (ob_get_level() == 0) {
      ob_start();
    }

    $reviews = Review::all();
    foreach ($reviews as $review) {
      $review->reported = 1;    
      $review->save();
      $reported = new ReportedReview();
      $reported->review_id = $review->id;
      $reported->reason = $faker->text(rand($this->review_text_len_min, $this->review_text_len_max));
      $reported->save();
      echo 'Reporting review '.$review->id, '<br>';
      ob_flush();
      flush();
    }
  }

  public function postProcess() 
  {
    try {
      $total_operations = Input::get('empty_db_tables') + Input::get('remove_db_tables') + Input::get('db_migration') + Input::get('db_seed') + Input::get('random_users_data') + Input::get('random_categories_data') + Input::get('random_brands_data') + Input::get('random_products_data') + Input::get('random_reviews_data');

      $counter = 1;
      ini_set('max_execution_time', 300);

      if (ob_get_level() == 0) {
        ob_start();
      }

      if (Input::get('empty_db_tables')) {

        echo $counter . '/' . $total_operations;

        $this->getEmptyDbTables();

        $counter++;
      }

      if (Input::get('remove_db_tables') == 1) {
        echo $counter . '/' . $total_operations;

        $this->getRemoveDbTables();

        $counter++;
      }

      if (Input::get('db_migration') == 1) {
        echo $counter . '/' . $total_operations;
        $this->getDbMigration();
        $counter++;
      }

      if (Input::get('db_seed') == 1) {
        echo $counter . '/' . $total_operations . ' Seeding database tables...';
        ob_flush();
        flush();

        Artisan::call('db:seed', ['--class' => "DatabaseSeeder", '--force' => true]);
        $this->progress();

        $counter++;
        echo ' Done.<br>';
        ob_flush();
        flush();
      }

      $faker = Faker\Factory::create();

      if (Input::get('random_users_data') == 1) {
        echo $counter . '/' . $total_operations . ' Adding random users data...';
        ob_flush();
        flush();

        $this->progress();

        }

        $counter++;
        echo ' Done.<br>';
        ob_flush();
        flush();
      }

      if (Input::get('random_brands_data') == 1) {
        echo $counter . '/' . $total_operations . ' Adding random brands data...';
        ob_flush();
        flush();

        for ($i = 2; $i <= $this->num_of_brands; $i++) {
          $brand = New Brand();
          $brand->name = str_replace('.', '', $faker->text($this->brand_name_len));
          $brand->slug = str_slug($brand->name, '-');
          $brand->save();

          $this->progress();
        }

        $counter++;
        echo ' Done.<br>';
        ob_flush();
        flush();
      }

      if (Input::get('random_categories_data') == 1) {
        echo $counter . '/' . $total_operations . ' Adding random categories data...';
        ob_flush();
        flush();

        for ($i = 2; $i <= $this->num_of_categories; $i++) {
          $category = New Category();
          $category->name = str_replace('.', '', $faker->text($this->category_name_len));
          $category->slug = str_slug($category->name, '-');
          $category->save();

          $this->progress();
        }

        $counter++;
        echo ' Done.<br>';
        ob_flush();
        flush();
      }

      if (Input::get('random_products_data') == 1) {
        echo $counter . '/' . $total_operations . ' Adding random products data...';
        ob_flush();
        flush();

        for ($i = 1; $i <= $this->num_of_products; $i++) {
          $product = New Product();
          $product->name = str_replace('.', '', $faker->text($this->product_name_len));
          $product->slug = str_slug($product->name, '-');
          $product->description = $faker->text(rand($this->product_description_len_min, $this->product_description_len_max));
          $product->category_id = $faker->numberBetween(2, $this->num_of_categories);
          $product->brand_id = $faker->numberBetween(2, $this->num_of_brands);
          $product->affiliate_code = '';
          $product->active = 1;
          $product->save();

          $this->progress();
        }

        $counter++;
        echo ' Done.<br>';
        ob_flush();
        flush();
      }

      if (Input::get('random_reviews_data') == 1) {
        echo $counter . '/' . $total_operations . ' Adding random reviews data...';
        ob_flush();
        flush();

        for ($i = 1; $i <= $this->num_of_reviews; $i++) {
          $review = New Review();
          $review->product_id = $faker->numberBetween(1, $this->num_of_products);
          $review->title = $faker->text(rand(10, 100));
          $review->pros = $faker->text(rand(10, 100));
          $review->cons = $faker->text(rand(10, 100));
          $review->text = $faker->text(rand($this->review_text_len_min, $this->review_text_len_max));
          $review->rating = $faker->numberBetween(1, 5);
          $review->helpful_yes = $faker->numberBetween(1, 10);
          $review->helpful_no = $faker->numberBetween(1, 10);
          $review->helpful_sum = $review->helpful_yes - $review->helpful_no;
          $review->active = 1;

          $review->created_at = $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now');

          $review->save();                
          Products::recalculateStats($review->product_id);
          $this->progress();
        }

        $counter++;
        echo ' Done.<br>';
        ob_flush();
        flush();
      }

    } catch(\Exception $e) {
      return '<span class="red"><b>' . $e->getMessage() . '</b></span>';
    }

    return '<span class="green"><b>Done</b></span>';

    ob_end_flush();
  }

  public function getEmptyDbTables()
  {

    try{
      echo ' Emptying database tables...';
      ob_flush();
      flush();
      Eloquent::unguard();
      $this->progress();
      DB::table('settings')->truncate();
      $this->progress();
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      $this->progress();
      DB::table('reviews')->truncate();
      $this->progress();
      DB::table('products')->truncate();
      $this->progress();
      DB::table('categories')->truncate();
      $this->progress();
      DB::table('brands')->truncate();
      $this->progress();

      echo ' Done<br />';
      ob_flush();
      flush();     
    } catch (Exception $e) {
      return '<b>Error epmtying tables</b>';
    }
  }


  public function getRemoveDbTables()
  {
    try{
      echo ' Removing database tables...';
      ob_flush();
      flush();

      Eloquent::unguard();
      $this->progress();

   //Setting::truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      $this->progress();

      Schema::drop('settings');
      $this->progress();
      Schema::drop('widgets');
      $this->progress();
      Schema::drop('brands');
      $this->progress();
      Schema::drop('categories');
      $this->progress();
      Schema::drop('favorited_products');
      $this->progress();
      Schema::drop('favorited_reviews');
      $this->progress();
      Schema::drop('favorited_users');
      $this->progress();
      Schema::drop('helpful_reviews');
      $this->progress();
      Schema::drop('images');
      $this->progress();
      Schema::drop('pages');
      $this->progress();
      Schema::drop('reviews');
      $this->progress();
      Schema::drop('products');
      $this->progress();
      Schema::drop('reported_products');
      $this->progress();
      Schema::drop('reported_reviews');
      $this->progress();
      Schema::drop('product_lists');
      $this->progress();
      Schema::drop('product_reporting_reasons');
      $this->progress();
      Schema::drop('review_reporting_reasons');
      $this->progress();
      Schema::drop('password_resets');
      $this->progress();
      Schema::drop('migrations');
      $this->progress();

      echo ' Done.<br>';
      ob_flush();
      flush();
    } catch(\Exception $e) {
      return '<b>Error removing database tables</b>';
    }
  }


  public function getDbMigration()
  {
    try{
      echo ' Migrating database tables...';
      ob_flush();
      flush();

      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      $this->progress();

      define('STDIN', fopen("php://stdin", "r"));
      Artisan::call('migrate', ['--force' => true]);
      $this->progress();

      echo ' Done.<br>';
      ob_flush();
      flush();
    } catch (Exception $e) {
      return '<b>Error installing database structure</b>';
    }
  }

  public function progress() 
  {
    echo '.';
    ob_flush();
    flush();
  }

}
