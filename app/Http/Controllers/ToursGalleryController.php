<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\ToursGalleryRequest;
use App\Models\Tours;
use App\Models\ToursGallery;

class ToursGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tours $tours)
    {
        if (request()->ajax()) {
            $query = ToursGallery::where('tours_id', $tours->id);

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <form class="inline-block" action="' . route('dashboard.gallery.destroy', $item->id) . '" method="POST">
                        <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                            Delete
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
                })
                ->editColumn('url', function ($item) {
                    return '<img style="max-width: 150px;" src="'. $item->url .'"/>';
                })
                ->editColumn('is_featured', function ($item) {
                    return $item->is_featured ? 'Yes' : 'No';
                })
                ->rawColumns(['action', 'url'])
                ->make();
        }

        return view('pages.dashboard.gallery.index', compact('tours'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Tours $tour)
    {
        return view('pages.dashboard.gallery.create', compact('tour'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ToursGalleryRequest $request, Tours $tour)
    {
        $files = $request->file('files');

        if($request->hasFile('files'))
        {
            foreach ($files as $file) {
                $path = $file->store('public/gallery');

                ToursGallery::create([
                    'tours_id' => $tour->id,
                    'url' => $path
                ]);
            }
        }

        return redirect()->route('dashboard.tours.gallery.index', $tour->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ToursGallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(ToursGallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ToursGallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(ToursGallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ToursGallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(ToursGalleryRequest $request, ToursGallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ToursGallery  $toursGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToursGallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('dashboard.tours.gallery.index', $gallery->tours_id);
    }
}
