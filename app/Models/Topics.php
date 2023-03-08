<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Topics extends Model
{

    protected $table    = 'topics';
    protected $primaryKey = 'topic_id';
    protected $fillable = [
        'name', 'icon_path', 'categories', 'created_at', 'flg_show', 'is_custom_topic'
    ];
    const CREATED_AT    = 'created_at';
    public $timestamps = false;


    public function scopeCategory($query)
    {
        return $query->select('categories')->groupBy('categories');
    }

    public function scopeWithQuery($query, Request $request)
    {
        if ($request->has('name')) {
            $query->where('name', 'ILIKE', '%' . $request->name . '%');
        }

        if ($request->has('categories')) {
            $query->where('categories', 'ILIKE', '%' . $request->categories . '%');
        }
        return $query;
    }

    public static function updateTopic($topic, $data)
    {
        try {
            DB::beginTransaction();
            $topicData = collect($data)->only([
                'name',
                'categories'
            ]);
            $topic->update($topicData->toArray());
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}