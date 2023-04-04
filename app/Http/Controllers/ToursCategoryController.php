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
                    return '
                        <a class="inline-block border border-gray-700 bg-gray-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline"
                            href="' . route('dashboard.category.edit', $item->id) . '">
                            Edit
                        </a>
                        <form class="inline-block" action="' . route('dashboard.category.destroy', $item->id) . '" method="POST">
                        <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                            Hapus
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
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
        return view('pages.dashboard.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ToursCategoryRequest $request)
    {
        $data = $request->all();

        ToursCategory::create($data);

        return redirect()->route('dashboard.category.index')->with('success', 'Category berhasil ditambahkan');
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
        return view ('pages.dashboard.category.edit', [
            'item' => $category
        ]);
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
        $data = $request->all();

        $category->update($data);

        return redirect()->route('dashboard.category.index')->with('success', 'Category berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ToursCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToursCategory $category)
    {
        $category->delete();

        return redirect()->route('dashboard.category.index')->with('success', 'Category berhasil di hapus');
    }
}
