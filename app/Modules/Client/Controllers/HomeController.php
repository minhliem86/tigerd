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

    public function __construct(ProductRepository $product, NewsRepository $news)
    {
        $this->product = $product;
        $this->news = $news;
    }

    public function index()
    {
        $product = $this->product->all(['id', 'img_url', 'name','slug', 'price', 'discount'], ['attributes']);
        $news = $this->news->all(['name','slug', 'description', 'img_url']);

        return view('Client::pages.home.index', compact('product', 'news'));
    }
}
