<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use Yajra\DataTables\Facades\DataTables;

class CAtegoryController extends Controller
{
    // public function index(Request $request){
    //     $categories = CategoryModel::all();
    //     if($request->ajax()){
    //         return DataTable::of($categories)->make(true);
    //     }
    // }
    public function index(Request $request){
        $categories = CategoryModel::select('id','name','type'); // Use a query instead of all()
        if ($request->ajax()) {
            return DataTables::of($categories)
            ->addColumn('action',function($row){
               return '<a href="javascript:void(0)" class="btn btn-info btn-sm editButton" data-id="'.$row->id.'">Edit</a>
               <a href="javascript:void(0)" class="btn btn-danger btn-sm delButton" data-id="'.$row->id.'">Delete</a>';
            })->rawColumns(['action'])
            ->make(true);
        }
    }

    public function create(){
        return view('categories.create');
    }

    public function store(Request $request){
        if($request->category_id != null ){
            $category = CategoryModel::find($request->category_id);
            if(! $category){
                abort(404);
            }
            $category->update([
                'name'=>$request->name,
                'type'=>$request->type
            ]);
            return response()->json([
                'success' => 'Category Successfully Updated'
            ],201);
        }
        else{
            $request->validate([
                'name'=>'required | min:2|max:30',
                'type'=>'required'
            ]);
            CategoryModel::create([
                'name'=>$request->name,
                'type'=>$request->type
            ]);
            return response()->json([
                'success' => 'Category Saved Successfully'
            ],201);
        }
        
     } 
     public function edit($id){
        $category = CategoryModel::find($id);
        if(!$category){
            abort(404);
        }
        return $category;
     }

     public function destroy($id){
        $category = CategoryModel::find($id);
        if(!$category){
            abort(404);
        }
       $category->delete();
       return response()->json([
        'success' => 'Category Deleted Successfully'
       ] ,201);
     }
}
