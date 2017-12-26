<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\FeedbackRepository;
use Yajra\Datatables\Datatables;

class FeedbackController extends Controller
{
    protected $feedback;

    public function __construct(FeedbackRepository $feedback)
    {
        $this->feedback = $feedback;
    }

    public function index()
    {
        $feedback_quality = $this->feedback->all(['id'])->count();
        $feedback_not_check = $this->feedback->query(['id'])->where('status',0)->count();
        return view('Admin::pages.feedback.index', compact('feedback_quality', 'feedback_not_check'));
    }

    public function getData(Request $request)
    {
        $data = $this->feedback->query(['id', 'fullname', 'email', 'status']);
        $datatable = Datatables::of($data)
            ->editColumn('status', function($data){
                $status = $data->status ? 'checked' : '';
                $data_id =$data->id;
                return '
                 <label class="toggle">
                    <input type="checkbox" name="status" value="1" '.$status.'   data-id ="'.$data_id.'">
                    <span class="handle"></span>
                  </label>
              ';
            })
            ->addColumn('action', function($data){
                return '<a href="'.route('admin.feedback.show', $data->id).'" class="btn btn-info btn-xs inline-block-span"> View </a>
                <form method="POST" action=" '.route('admin.feedback.destroy', $data->id).' " accept-charset="UTF-8" class="inline-block-span">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-xs remove-btn" type="button" attrid=" '.route('admin.feedback.destroy', $data->id).' " onclick="confirm_remove(this);" > Remove </button>
               </form>' ;
            })
            ->filter(function($query) use ($request){
                if (request()->has('name')) {
                    $query->where('fullname', 'like', "%{$request->input('name')}%");
                }
            })
            ->make(true);
        return $datatable;
    }

    public function show($id)
    {
        $inst = $this->feedback->find($id);
        $inst->status = 1;
        $inst->save();
        return view('Admin::pages.feedback.edit', compact('inst'));
    }

    public function destroy($id)
    {
        $this->feedback->delete($id);
        return redirect()->route('admin.feedback.index')->with('success','Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $data = $request->arr;
            $response = $this->feedback->deleteAll($data);
            return response()->json(['msg' => 'ok']);
        }
    }

    /*CHANGE STATUS*/
    public function updateStatus(Request $request)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $value = $request->input('value');
            $id = $request->input('id');
            $cate = $this->feedback->find($id);
            $cate->status = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }
}
