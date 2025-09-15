<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetIndex(){

     $response = $this->get('/');
     
     $this->assertResponseStatus(200);

     $this->assertViewHas([
      'page_title',
      'meta_description',
      'featured_reviews',
      'featured_categories',
      'images',
      'reviews']);

   }

   public function testGetSearch(){

    $params = array('search_terms'=>'test');
    
    $response = $this->get('/search', $params);
    
    $this->assertResponseStatus(200);

    $this->assertViewHas([
      'page_title',
      'meta_description',
      'products',
      'reviews',
      'brands',
      'images',
      'categories',
      'review_reporting_reasons',
      'search_terms']);

  }

  public function testSeeTextOnPage(){

   $this->visit('/')
   ->see('Products')
   ->see('Reviews')
   ->see('Categories')
   ->see('Brands')
   ->see('Write review')
   ->see('Featured categories')
   ->see('Featured reviews')
   ->see('Write review')
   ->see('Latest reviews')
   ->see('Write review')
   ->see('About Us')
   ->see('Terms of use')
   ->see('Privacy policy')
   ->see('FAQ')
   ->see('Contact Us');
   
 }

 public function testClickOnLinks(){

   $this->visit('/')
   ->click('Products')
   ->seePageIs('/products');

   $this->visit('/')
   ->click('Reviews')
   ->seePageIs('/reviews');

   $this->visit('/')
   ->click('Categories')
   ->seePageIs('/categories');

   $this->visit('/')
   ->click('Brands')
   ->seePageIs('/brands');

   $this->visit('/')
   ->click('Write review')
   ->seePageIs('/products/find');

   $this->visit('/')
   ->click('more featured reviews')
   ->seePageIs('/reviews?featured=1');

   $this->visit('/')
   ->click('more recent reviews')
   ->seePageIs('/reviews');

   $this->visit('/')
   ->click('About Us')
   ->seePageIs('/page/about-us');

   $this->visit('/')
   ->click('Terms of use')
   ->seePageIs('/page/terms-of-use');

   $this->visit('/')
   ->click('Privacy policy')
   ->seePageIs('/page/privacy-policy');

   $this->visit('/')
   ->click('FAQ')
   ->seePageIs('/page/faq');

   $this->visit('/')
   ->click('Contact Us')
   ->seePageIs('/contact');
   
 }

}