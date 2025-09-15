<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductControllerTest extends TestCase
{
	public function testIndex(){

		$response = $this->get('/products');
		
		$this->assertResponseStatus(200);

		$this->assertViewHas(['menu_highlight',
			'button_highlight',
			'meta_description',
			'categories',
			'brands',
			'products',
			'brand_name',
			'category_name']);
	}

	public function testSeeTextOnPage(){

		$this->visit('/products')
		->see('Products')
		->see('Reviews')
		->see('Categories')
		->see('Brands')
		->see('Write review')
		->see('All products')
		->see('Category')
		->see('Brand')
		->see('Product name')
		->see('Search')
		->see('Newest')
		->see('Top rated')
		->see('Most reviewed')
		->see('About Us')
		->see('Terms of use')
		->see('Privacy policy')
		->see('FAQ')
		->see('Contact Us');

	}

	public function testClickLinks(){
		$this->visit('/products')
		->click('Newest')
		->seePageIs('/products?brand_id=&category_id=&name=');

		$this->visit('/products')
		->click('Top rated')
		->seePageIs('/products?brand_id=&category_id=&name=&order=rating');

		$this->visit('/products')
		->click('Most reviewed')
		->seePageIs('/products?brand_id=&category_id=&name=&order=reviews');
	}

	public function testSearchForm(){
		$this->visit('/products')
		->select(1, 'category_id')
		->select(1, 'brand_id')
		->type('test', 'name')
		->press('Search')
		->seePageIs('/products?brand_id=1&category_id=1&name=test');
	}

	public function testPagination(){
		$this->visit('/products?page=2')
		->seePageIs('/products?page=2');
	}
}
