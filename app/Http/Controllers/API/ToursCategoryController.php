<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ToursCategory;
use Illuminate\Http\Request;

class ToursCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_tours = $request->input('show_tours');

        if($id) {
            $category = ToursCategory::with(['tours'])->find($id);

            if($category) {
                return ResponseFormatter::success(
                    $category,
                    'Data kategoti berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data kategoti tidak ada',
                    404
                );
            }
        }

        $category = ToursCategory::query();

        if ($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_tours)
        {
            $category->with('tours');
        }

        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data list kategori berhasil diambil'
        );
    }
}
