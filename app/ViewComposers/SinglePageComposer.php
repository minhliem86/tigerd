<?php
namespace App\ViewComposers;

use Illuminate\View\View;
use App\Repositories\PagesRepository;

class SinglePageComposer{

    protected $page;

    public function __construct(PagesRepository $page)
    {
        $this->page = $page;
    }

    public function compose(View $view)
    {
        $page = $this->page->findByField('status',1, ['id', 'name', 'slug'])->get();
        $about = $this->page->findByField('slug', 'gioi-thieu', ['id', 'name', 'slug'])->first();
        $view->with(compact('page', 'about'));
        // TODO: Bind data to view
    }
}