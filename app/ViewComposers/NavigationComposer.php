<?php
namespace App\ViewComposers;

use Illuminate\View\View;
use App\Repositories\CategoryRepository;
use App\Repositories\PagesRepository;
use App\Repositories\NewsTypeRepository;
use App\Repositories\AgencyRepository;

class NavigationComposer{

    protected $category;
    protected $newstype;
    protected $page;
    protected $agency;

    public function __construct(CategoryRepository $category, PagesRepository $page, NewsTypeRepository $newstype, AgencyRepository $agency)
    {
        $this->category = $category;
        $this->page = $page;
        $this->newstype = $newstype;
        $this->agency = $agency;
    }

    public function compose(View $view)
    {
        $newstype = $this->newstype->query(['title','id','slug'])->where('status',1)->orderBy('order','DESC')->get();
        $cate = $this->category->all(['id', 'name', 'slug']);
        $menu = $this->agency->query(['*'],['categories'])->where('status', 1)->get();
        $about = $this->page->findByField('slug', 'gioi-thieu', ['id', 'name', 'slug'])->first();
        $view->with(compact('cate','about', 'newstype','menu'));
        // TODO: Bind data to view
    }
}