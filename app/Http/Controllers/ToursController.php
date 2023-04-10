<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToursRequest;
use App\Models\Tours;
use App\Models\ToursCategory;
use Yajra\DataTables\Facades\DataTables;

class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Tours::with('category');

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="inline-block border border-blue-700 bg-blue-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-blue-800 focus:outline-none focus:shadow-outline" 
                            href="' . route('dashboard.tours.gallery.index', $item->id) . '">
                            Gallery
                        </a>
                        <a class="inline-block border border-gray-700 bg-gray-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline" 
                            href="' . route('dashboard.tours.edit', $item->id) . '">
                            Edit
                        </a>
                        <form class="inline-block" action="' . route('dashboard.tours.destroy', $item->id) . '" method="POST">
                        <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                            Delete
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
                })
                ->editColumn('price', function ($item) {
                    return number_format($item->price);
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.tours.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ToursCategory::all();
        return view('pages.dashboard.tours.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ToursRequest $request)
    {
        $data = $request->all();

        Tours::create($data);

        return redirect()->route('dashboard.tours.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tours  $tour
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Tours $tour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tours  $tour
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Tours $tour)
    {
        $categories = ToursCategory::all();
        return view('pages.dashboard.tours.edit',[
            'item' => $tour,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tours  $tour
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ToursRequest $request, Tours $tour)
    {
        $data = $request->all();

        $tour->update($data);

        return redirect()->route('dashboard.tours.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tours  $tour
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tours $tour)
    {
        $tour->delete();

        return redirect()->route('dashboard.tours.index');
    }
}
