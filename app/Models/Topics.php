<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Topics extends Model
{

    use SoftDeletes;
    protected $table    = 'topics';
    protected $primaryKey = 'topic_id';
    protected $fillable = [
        'name', 'icon_path', 'categories', 'created_at', 'flg_show', 'is_custom_topic', 'sort', 'sign',
    ];
    const CREATED_AT    = 'created_at';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function topicUsers()
    {
        return $this->hasMany(UserTopicModel::class, 'topic_id', 'topic_id');
    }
    public function posts()
    {
        return $this->hasMany(PostModel::class, 'topic_id', 'topic_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($topic) {
            $topic->topic_id = (string) (Topics::max('topic_id') + 1);
        });
    }

    public static function onlyFillAble()
    {
        return [
            'topic_id',
            'name', 'icon_path', 'categories', 'created_at', 'flg_show', 'is_custom_topic', 'sort'
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

    public function scopeWithTopicUsers($query)
    {
        return $query->with('topicUsers');
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
            $topicData = collect($data)->only(Topics::onlyFillAble());
            $topic->update($topicData->toArray());
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public static function getData(Request $req)
    {
        try {
            $columns = array(
                0 => 'topic_id',
                1 => 'name',
                2 => 'icon_path',
                3 => 'categories',
                4 => 'created_at',
                5 => 'sort',
                6 => 'followers',
                7 => 'total_user_topics',
                8 => 'total_posts',
                9 => 'sign',
            );
            $searchName = $req->input('name');
            $searchCategory = $req->input('category');
            $orderColumnIndex = (int) $req->input('order.0.column');
            $orderDirection = $req->input('order.0.dir', 'asc');
            $start = (int) $req->input('start', 0);
            $length = (int) $req->input('length', 10);
            $query = Topics::select(
                'topics.topic_id',
                'topics.name',
                'topics.icon_path',
                'topics.categories',
                'topics.created_at',
                'topics.sort',
                'topics.flg_show',
                'topics.sign'
            )
                ->selectSub(function ($query) {
                    $query->selectRaw('count(*)')
                        ->from('user_topics')
                        ->whereRaw('user_topics.topic_id = topics.topic_id')
                        ->groupBy('user_topics.topic_id');
                }, 'total_user_topics')
                ->selectSub(function ($query) {
                    $query->selectRaw('count(*)')
                        ->from('posts')
                        ->whereRaw('posts.topic_id = topics.topic_id')
                        ->groupBy('posts.topic_id');
                }, 'total_posts')
                ->whereNull('topics.deleted_at');

            $query->with('topicUsers');
            if ($searchName !== null) {
                $query->where('topics.name', 'ILIKE', '%' . $searchName . '%');
            }

            if ($searchCategory !== null) {
                $query->where('topics.categories', 'ILIKE', '%' . $searchCategory . '%');
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
            file_put_contents('test.txt', $th->getMessage());
            return response()->json([
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
