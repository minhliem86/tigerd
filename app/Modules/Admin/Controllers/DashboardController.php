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

class DashboardController extends Controller
{
    protected $analytic;
    protected $product;
    protected $agency;
    protected $category;

    public function __construct(Analytics $analytic, ProductRepository $product, AgencyRepository $agency, CategoryRepository $category)
    {
        $this->analytic = $analytic;
        $this->product = $product;
        $this->agency = $agency;
        $this->category = $category;
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

        $new_sp = $this->product->new_product( ['id','name','img_url','price', 'created_at']);
        $view_sp = $this->product->viewProduct( ['name','count_number']);

        $data_bar_chart = $this->getDataOrderInMonth();
        return view('Admin::pages.dashboard.index', compact('ga', 'number_product', 'number_agency', 'number_category','new_sp','view_sp','data_bar_chart'));
    }

    protected function getDataOrderInMonth()
    {
        $year = date('Y');
        $array_month = ['January', 'February', 'March', 'April', 'May', 'Jun', 'July', 'August', 'September', 'October', 'November', 'December'];
        foreach($array_month as $item_month){
            $quantity_order[$item_month] = \DB::table('products')->whereRaw('MONTH(created_at) = ?',[\Carbon\Carbon::parse($item_month)->month])->whereRaw('YEAR(created_at) = ?',[$year])->count();
        }


        return $quantity_order;
    }

    protected function getNameMonth($month = 'January')
    {

    }


}
