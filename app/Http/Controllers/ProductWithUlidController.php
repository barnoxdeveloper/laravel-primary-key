<?php

namespace App\Http\Controllers;

use App\Models\ProductWithUlid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductWithUlidController extends Controller
{
    public function index(Request $request)
    {
        $items = ProductWithUlid::orderBy('name', 'ASC')->get();
        if($request->ajax()) {
            return datatables()->of($items)
                                ->addColumn('name', function ($data) {
                                    return $data->name;
                                })
                                ->addColumn('price', function($data) {
                                    return $data->price;
                                })
                                ->addColumn('color', function($data) {
                                    return $data->color;
                                })
                                ->addColumn('action', function($data) {
                                    $button = '<a href="javascript:void(0)"
                                                data-toggle="tooltip"
                                                title="Edit"
                                                data-id="'.$data->id.'"
                                                class="btn btn-warning btn-sm edit me-3">
                                                Edit
                                                </a>';
                                    $button .= '<a href="javascript:void(0)"
                                                data-toggle="tooltip"
                                                title="Delete"
                                                data-id="'.$data->id.'"
                                                class="btn btn-danger btn-sm delete">
                                                Delete
                                                </a>';
                                    return $button;
                                })
                                ->rawColumns(['name', 'price', 'color', 'action'])
                                ->addIndexColumn()
                                ->make(true);
        }
        return view('pages.product_with_ulid.index');
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|max:10',
            'color' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 0,
                'notif' => "Error!",
                'messages' => $validator->errors(),
            ]);
        }
        ProductWithUlid::updateOrCreate(['id' => $id],
        [
            'name' => $request->name,
            'price' => $request->price,
            'color' => $request->color,
        ]);
        return response()->json([
            'code' => 200,
            'message' => "Data Created Successfully!"
        ]);
    }

    public function edit($id)
    {
        $item = ProductWithUlid::findOrFail($id);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = ProductWithUlid::findOrFail($id);
        $item->delete();
        return response()->json([
            'code' => 200,
            'message' => "Data Deleted Successfully!"
        ]);
    }
}
