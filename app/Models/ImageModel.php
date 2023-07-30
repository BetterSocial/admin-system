<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ImageModel extends Model
{
    use HasFactory;


    protected $table = "images";

    protected $fillable = [
        'name',
        'url'
    ];


    public static function getData(Request $req)
    {
        try {
            $columns = array(
                0 => 'id',
                1 => 'name',
                2 => 'url',
            );
            $searchName = $req->input('name');
            $searchCategory = $req->input('category');
            $orderColumnIndex = (int) $req->input('order.0.column');
            $orderDirection = $req->input('order.0.dir', 'desc');
            $start = (int) $req->input('start', 0);
            $length = (int) $req->input('length', 10);
            $query = self::select(
                'id',
                'name',
                'url',
            );
            if ($searchName !== null) {
                $query->where('name', 'ILIKE', '%' . $searchName . '%');
            }

            if ($searchCategory !== null) {
                $query->where('categories', 'ILIKE', '%' . $searchCategory . '%');
            }

            $total = $query->count();

            $query->orderBy($columns[$orderColumnIndex], $orderDirection)
                ->offset($start)
                ->limit($length);

            $data = $query->get();
            return response()->json([
                'draw' => (int) $req->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
