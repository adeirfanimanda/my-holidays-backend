<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToursCategoryRequest;
use App\Models\ToursCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ToursCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $query = ToursCategory::query();
            
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '<a class="inline-block border border-gray-700 bg-gray-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline" href="' . route('dashboard.category.edit', $item->id) . '">Edit</a>';
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ToursCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ToursCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(ToursCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ToursCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(ToursCategory $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ToursCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(ToursCategoryRequest $request, ToursCategory $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ToursCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToursCategory $category)
    {
        //
    }
}
