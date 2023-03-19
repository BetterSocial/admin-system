<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Topics extends Model
{

    protected $table    = 'topics';
    protected $primaryKey = 'topic_id';
    protected $fillable = [
        'name', 'icon_path', 'categories', 'created_at', 'flg_show', 'is_custom_topic'
    ];
    const CREATED_AT    = 'created_at';
    public $timestamps = false;

    public static function onlyFillAble()
    {
        return [
            'topic_id',
            'name', 'icon_path', 'categories', 'created_at', 'flg_show', 'is_custom_topic'
        ];
    }

    public function setIsCustomTopic($value)
    {
        if ($value) {
            $this->attributes['is_custom_topic'] = false;
        } else {
            $this->attributes['is_custom_topic'] = $value;
        }
    }

    public function setFlgShow($value)
    {
        if ($value) {
            $this->attributes['flg_show'] = 'N';
        } else {
            $this->attributes['flg_show'] = $value;
        }
    }

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

    public static function addTopic(Request $request)
    {
        try {
            DB::beginTransaction();
            Topics::create($request->only([]));


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
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
