<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Topics extends Model
{

    protected $table    = 'topics';
    protected $primaryKey = 'topic_id';
    protected $fillable = [
        'name', 'cover_path', 'icon_path', 'categories', 'created_at', 'flg_show', 'is_custom_topic', 'sort', 'sign',
    ];
    const CREATED_AT    = 'created_at';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function userTopics()
    {
        return $this->hasMany(UserTopicModel::class, 'topic_id', 'topic_id');
    }
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(PostModel::class, 'post_topics', 'topic_id', 'post_id');
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
            'name',
            'cover_path',
            'icon_path',
            'categories',
            'created_at',
            'flg_show',
            'is_custom_topic',
            'sort'
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

    public function scopeWithUserTopics($query)
    {
        return $query->with('userTopics');
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

    public static function updateTopic($topic, Request $request)
    {
        try {
            DB::beginTransaction();
            if (
                $request->input('categories') == null &&
                $request->has('category') &&
                $request->input('category') != null
            ) {
                $request->merge(['categories' => $request->input('category')]);
            }

            $data = array_filter($request->all());
            $topic->update($data);
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
                3 => 'cover_path',
                4 => 'categories',
                5 => 'created_at',
                6 => 'sort',
                7 => 'followers',
                8 => 'total_user_topics',
                9 => 'total_posts',
                10 => 'sign',
            );
            $searchName = $req->input('name');
            $searchCategory = $req->input('category');

            $query = Topics::select(
                'topics.topic_id',
                'topics.name',
                'topics.cover_path',
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
                        ->from('post_topics')
                        ->whereRaw('post_topics.topic_id = topics.topic_id')
                        ->groupBy('post_topics.topic_id');
                }, 'total_posts')
                ->whereNull('topics.deleted_at');

            $query->with('userTopics', 'posts');
            if ($searchName !== null) {
                $query->where('topics.name', 'ILIKE', '%' . $searchName . '%');
            }

            if ($searchCategory !== null) {
                $query->where('topics.categories', 'ILIKE', '%' . $searchCategory . '%');
            }

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

    public static function removeDuplicateTopicName($option)
    {
        try {
            DB::beginTransaction();

            $topicsWithSameName = self::select('name')
                ->groupBy('name')
                ->havingRaw('COUNT(*) > 1')
                ->get();
            if (count($topicsWithSameName) < 1) {
                return false;
            }
            foreach ($topicsWithSameName as $topicWithSameName) {
                $query = Topics::where('name', $topicWithSameName->name);

                if ($option == 'latest') {
                    $query->orderBy('created_at');
                } else {
                    $query->orderByDesc('created_at');
                }

                $duplicateTopics = $query->skip(1)->get();

                // Hapus duplicate topics
                $duplicateTopics->each->delete();
            }

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public static function getDetail($id)
    {

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
                    ->from('post_topics')
                    ->whereRaw('post_topics.topic_id = topics.topic_id')
                    ->groupBy('post_topics.topic_id');
            }, 'total_posts')
            ->whereNull('topics.deleted_at');

        $query->with('userTopics', 'posts');
        $query->where('topic_id', $id);
        return $query->first();
    }
}
