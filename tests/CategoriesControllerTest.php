<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoriesControllerTest extends TestCase
{
    public function testIndex(){

		$response = $this->get('/categories');

		$this->assertResponseStatus(200);

		$this->assertViewHas([
			'page_title', 
			'menu_highlight',
			'meta_description', 
			'alphabet', 
			'letters', 
			'categories', 
			'latest_added', 
			'starting_nonalpha_cnt'
			]);

	}
}
