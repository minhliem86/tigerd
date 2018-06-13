<?php

namespace App\Modules\Client\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\NewsRepository;
use App\Repositories\NewsTypeRepository;

class NewsController extends Controller
{
    protected $news;
    protected $newstype;

    public function __construct(NewsRepository $news, NewsTypeRepository $newstype)
    {
        $this->news = $news;
        $this->newstype = $newstype;
    }

    public function getIndex()
    {
        $news = $this->news->paginate(8, ['id', 'name', 'slug', 'description', 'content', 'img_url']);
        return view('Client::pages.news.index', compact('news'));
    }

    public function getNewsByType($slug)
    {
        $newstype = $this->newstype->query(['*'],['news','meta_configs'])->where('slug', $slug)->first();
        return view('Client::pages.news.index', compact('newstype'));
    }

    public function getDetail($slug)
    {

        $news = $this->news->findByField('slug', $slug, ['id', 'name', 'slug', 'description', 'content', 'img_url', 'created_at'])->first();
        $meta = $news->meta_configs()->first();
        if(count($news)){
            $relate_news = $this->news->findWhereNotIn('id',[$news->id], ['id', 'name', 'slug', 'description', 'img_url']);
            return view('Client::pages.news.detail', compact('news', 'relate_news', 'meta'));
        }
        return response()->view('Admin::errors.404','',404);
    }
}
