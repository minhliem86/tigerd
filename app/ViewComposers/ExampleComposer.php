<?php
namespace App\ViewComposers;

use Illuminate\View\View;
use App\Repositories\CategoryRepository;

class ExampleComposer{

    protected $example;

    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function compose(View $view)
    {
        $cate = $this->category->all(['id', 'name', 'slug']);
        $view->with('cate',$cate);
        // TODO: Bind data to view
    }
}