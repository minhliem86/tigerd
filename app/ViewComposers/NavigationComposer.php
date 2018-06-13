<?php
namespace App\ViewComposers;

use Illuminate\View\View;
use App\Repositories\CategoryRepository;
use App\Repositories\PagesRepository;
use App\Repositories\NewsTypeRepository;

class NavigationComposer{

    protected $category;
    protected $newstype;
    protected $page;

    public function __construct(CategoryRepository $category, PagesRepository $page, NewsTypeRepository $newstype)
    {
        $this->category = $category;
        $this->page = $page;
        $this->newstype = $newstype;
    }

    public function compose(View $view)
    {
        $newstype = $this->newstype->query(['title','id','slug'])->where('status',1)->orderBy('order','DESC')->get();
        $cate = $this->category->all(['id', 'name', 'slug']);
        $about = $this->page->findByField('slug', 'gioi-thieu', ['id', 'name', 'slug'])->first();
        $view->with(compact('cate','about', 'newstype'));
        // TODO: Bind data to view
    }
}