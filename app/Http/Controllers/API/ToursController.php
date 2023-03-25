<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Tours;
use Illuminate\Http\Request;

class ToursController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $categories = $request->input('categories');

        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        if($id) {
            $tours = Tours::with(['category', 'galleries'])->find($id);

            if($tours) {
                return ResponseFormatter::success(
                    $tours,
                    'Data tours berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data tours tidak ada',
                    404
                );
            }
        }

        $tours = Tours::with(['category', 'galleries']);

        if ($name) {
            $tours->where('name', 'like', '%' . $name . '%');
        }

        if ($description) {
            $tours->where('description', 'like', '%' . $description . '%');
        }

        if ($tags) {
            $tours->where('tags', 'like', '%' . $tags . '%');
        }

        if ($price_from) {
            $tours->where('price', '>=', $price_from);
        }

        if ($price_to) {
            $tours->where('price', '<=', $price_to);
        }

        if ($categories) {
            $tours->where('categories', $categories);
        }

        return ResponseFormatter::success(
            $tours->paginate($limit),
            'Data tours berhasil diambil'
        );
    }
}
