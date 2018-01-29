<?php

namespace App\Modules\Client\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\PagesRepository;

class SingleController extends Controller
{
    protected $page;

    public function __construct(PagesRepository $page)
    {
        $this->page = $page;
    }

    public function index(Request $request, $slug)
    {
        $page = $this->page->findByField('slug', $slug, ['id', 'name', 'slug', 'description'])->first();
        $meta = $page->meta_configs()->first();
        if(count($page)){
            return view('Client::pages.single.index', compact('page', 'meta'));
        }
            return redirect()->back();
    }
}
