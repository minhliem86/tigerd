<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use developeruz\Analytics\Period;
use developeruz\Analytics\Analytics;
use Carbon\Carbon;
use App\Repositories\ProductRepository;
use App\Repositories\AgencyRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\NewsRepository;
use App\Repositories\FeedbackRepository;
use App\Repositories\CustomerIdeaRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\PromotionRepository;

class DashboardController extends Controller
{
    protected $array_month = ['January', 'February', 'March', 'April', 'May', 'Jun', 'July', 'August', 'September', 'October', 'November', 'December'];
    protected $year;
    protected $analytic;
    protected $product;
    protected $agency;
    protected $category;
    protected $news;
    protected $feedback;
    protected $customer;
    protected $customerIdea;
    protected $promotion;

    public function __construct(Analytics $analytic, ProductRepository $product, AgencyRepository $agency, CategoryRepository $category, NewsRepository $news, FeedbackRepository $feedback, CustomerRepository $customer, CustomerIdeaRepository $customerIdea, PromotionRepository $promotion)
    {
        $this->year = date('Y');
        $this->analytic = $analytic;
        $this->product = $product;
        $this->agency = $agency;
        $this->category = $category;
        $this->news = $news;
        $this->feedback = $feedback;
        $this->customer = $customer;
        $this->customerIdea = $customerIdea;
        $this->promotion = $promotion;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            if($request->has('week')){
                 $ga = $this->analytic->fetchTotalVisitorsAndPageViews(Period::days(7));
            }else{
                $from = $request->input('from');
                $to = $request->input('to');

                $start_d = Carbon::createFromFormat('d-m-Y', $from);
                $to_d = Carbon::createFromFormat('d-m-Y', $to);
                $date = Period::create($start_d, $to_d);
                $ga = $this->analytic->fetchTotalVisitorsAndPageViews($date);
            }
            return view('Admin::ajax.ajaxChart', compact('ga'))->render();
        }else{
            $ga = $this->analytic->fetchTotalVisitorsAndPageViews(Period::days(7));
        }
        $number_product =$this->product->all(['id'])->count();
        $number_agency =$this->agency->all(['id'])->count();
        $number_category =$this->category->all(['id'])->count();
        $number_news =$this->news->all(['id'])->count();
        $number_feedback =$this->feedback->all(['id'])->count();
        $number_customer =$this->customer->all(['id'])->count();
        $number_customerIdea =$this->customerIdea->all(['id'])->count();

        $new_sp = $this->product->new_product( ['id','name','img_url','price', 'created_at']);
        $view_sp = $this->product->viewProduct( ['name','count_number']);

        $data_bar_chart = $this->getDataOrderInMonth();
        $data_bar_order = $this->getTotalOrderInMonth();
        $promotion_active = $this->getPromotionPieChart(1);
        $promotion_deactive = $this->getPromotionPieChart(0);
        return view('Admin::pages.dashboard.index', compact('ga', 'number_product', 'number_agency', 'number_category', 'number_news', 'number_feedback', 'number_customer', 'number_customerIdea' ,'new_sp','view_sp','data_bar_chart', 'data_bar_order','promotion_active', 'promotion_deactive'));
    }

    protected function getDataOrderInMonth()
    {

        foreach($this->array_month as $item_month){
            $quantity_order[$item_month] = \DB::table('orders')->whereRaw('MONTH(created_at) = ?',[\Carbon\Carbon::parse($item_month)->month])->whereRaw('YEAR(created_at) = ?',[$this->year])->count();

        }
        return $quantity_order;
    }

    protected function getTotalOrderInMonth()
    {
        foreach($this->array_month as $item_month){
            $total_order[] = array_sum(\DB::table('orders')->whereRaw('MONTH(created_at) = ?',[\Carbon\Carbon::parse($item_month)->month])->whereRaw('YEAR(created_at) = ?',[$this->year])->pluck('total'));
        }
        return $total_order;
    }

    protected function getPromotionPieChart($status = '1')
    {
        $promotion = $this->promotion->findByField('status', $status, ['id'])->count();
        return $promotion;
    }



}
