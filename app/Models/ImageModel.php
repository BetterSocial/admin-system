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
            $query = self::select(
                'id',
                'name',
                'url',
            );
            $total = $query->count();


            $query = limitOrderQuery($req, $query, $columns);

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
