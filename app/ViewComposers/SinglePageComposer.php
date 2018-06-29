<?php
namespace App\ViewComposers;

use Illuminate\View\View;
use App\Repositories\PagesRepository;
use developeruz\Analytics\Period;
use developeruz\Analytics\Analytics;
use Carbon\Carbon;

class SinglePageComposer{

    protected $page;
    protected $analytic;


    public function __construct(PagesRepository $page, Analytics $analytic)
    {
        $this->page = $page;
        $this->analytic = $analytic;
    }

    public function compose(View $view)
    {
        $startDate = Carbon::createFromDate('2018',5, 28);
        $endDate = Carbon::now();
        $date = Period::create($startDate, $endDate);
        $ga = $this->analytic->fetchTotalVisitorsAndPageViews($date);
        $total_pageview = 0;
        foreach($ga as $item){
            $total_pageview += $item['pageViews'];
        }

        $onlineUser = $this->analytic->getAnalyticsService()->data_realtime->get('ga:'.env('ANALYTICS_VIEW_ID'), 'rt:activeVisitors')->totalsForAllResults['rt:activeVisitors'];

        $page = $this->page->findByField('status',1, ['id', 'name', 'slug'])->get();
        $about = $this->page->findByField('slug', 'gioi-thieu', ['id', 'name', 'slug'])->first();
        $view->with(compact('page', 'about', 'total_pageview','onlineUser'));
        // TODO: Bind data to view
    }
}