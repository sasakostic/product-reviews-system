<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use URL;
use Carbon\Carbon;
use DB;

class SitemapController extends Controller
{
  public function generate()
  {
    $sitemap = App::make("sitemap");
    $sitemap->setCache('sitemap', 86400);

    if(!$sitemap->isCached()) {
      $sitemap->add(URL::to('/'), Carbon::now(), '1.0', 'daily');

      $products = DB::table('products')->where('active', '=', 1)->where('discontinued', '=', 0)->orderBy('created_at', 'desc')->get();
      foreach ($products as $product) {
        $sitemap->add(url('product/'.$product->id.'/'.$product->slug), $product->updated_at, '1.0', 'weekly');
      }
    }
    //$sitemap->store('xml', 'sitemap');
    return $sitemap->render('xml');
  }
}
