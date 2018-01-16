<?php

namespace App\Modules\Client\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\NewsRepository;

class NewsController extends Controller
{
    protected $news;

    public function __construct(NewsRepository $news)
    {
        $this->news = $news;
    }

    public function getIndex()
    {
        $news = $this->news->paginate(8, ['id', 'name', 'slug', 'description', 'content', 'img_url']);
        return view('Client::pages.news.index', compact('news'));
    }

    public function getDetail($slug)
    {
        $news = $this->news->findByField('slug', $slug, ['id', 'name', 'slug', 'description', 'content', 'img_url', 'created_at'])->first();
        if(count($news)){
            $relate_news = $this->news->findWhereNotIn('id',[$news->id], ['id', 'name', 'slug', 'description', 'img_url']);
            return view('Client::pages.news.detail', compact('news', 'relate_news'));
        }
        return abort(404);
    }
}
