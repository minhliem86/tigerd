<?php
namespace App\ViewComposers;

use Illuminate\View\View;
use App\Repositories\CategoryRepository;
use App\Repositories\PagesRepository;

class NavigationComposer{

    protected $category;

    protected $page;

    public function __construct(CategoryRepository $category, PagesRepository $page)
    {
        $this->category = $category;
        $this->page = $page;
    }

    public function compose(View $view)
    {
        $cate = $this->category->all(['id', 'name', 'slug']);
        $about = $this->page->findByField('slug', 'gioi-thieu', ['id', 'name', 'slug'])->first();
        $view->with(compact('cate','about'));
        // TODO: Bind data to view
    }
}