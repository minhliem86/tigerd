<?php

namespace App\Modules\Client\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Repositories\NewsRepository;

class HomeController extends Controller
{
    protected $product;
    protected $news;
    protected $analytic;

    public function __construct(ProductRepository $product, NewsRepository $news)
    {
        $this->product = $product;
        $this->news = $news;

    }

    public function index()
    {
        $product = $this->product->getProductHomePage(['id', 'img_url', 'name','slug', 'price', 'discount','category_id', 'default','stock'], ['attributes']);
        $news = $this->news->query(['name','slug', 'description', 'img_url'])->inRandomOrder()->get();

        return view('Client::pages.home.index', compact('product', 'news', 'total_pageview'));
    }
}
