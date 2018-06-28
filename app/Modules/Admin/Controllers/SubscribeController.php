<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SubcribeRepository;
use Excel;

class SubscribeController extends Controller
{
    protected $subscribe;

    public function __construct(SubcribeRepository $subscribe)
    {
        $this->subscribe = $subscribe;
    }

    public function getIndex()
    {
        $newsletters = $this->subscribe->query()->orderBy('id','DESC')->paginate(20, ['*']);
        return view('Admin::pages.subscribe.index', compact('newsletters'));
    }

    public function postDownload(Request $request)
    {
        $filename = 'TigerD_'.time();
        $data = $this->subscribe->all(['id', 'email', 'created_at']);
        Excel::create($filename, function($excel) use ($data){
            $excel->sheet('Danh Sách Newsletter', function($sheet) use ($data){
                $sheet->fromModel($data,null,'A1',false, false);

                $sheet->prependRow(1, array(
                    'ID', 'EMAIL', 'CREATE DATE'
                ));
                $sheet->setHeight(1, 25);
                $sheet->row(1, function ($row){
                    $row->setBackground('#6fcef7');
                    $row->setFontWeight('bold');
                    $row->setFontColor('#FFFFFF');
                    $row->setAlignment('center');
                    $row->setValignment('center');
                });

                $sheet->freezeFirstRow();

            });
        })->download('xls');

        return back()->with('success', 'Download Successful');
    }


}
