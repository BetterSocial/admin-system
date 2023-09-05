<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class UserApps extends Model
{

    use HasFactory;
    protected $table    = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';

    protected $fillable = [
        'human_id',
        'country_code',
        'is_banned',
        'username',
        'real_name',
        'last_active_at',
        'status',
        'profile_pic_path',
        'profile_pic_asset_id',
        'profile_pic_public_id',
        'bio',
        'is_anonymous',
        'encrypted',
        'allow_anon_dm',
        'only_received_dm_from_user_following',
        'is_backdoor_user',
    ];

    public function follower()
    {
        return $this->hasMany(UserFollowUserModel::class, 'user_id_follower', 'user_id');
    }

    public function Following()
    {
        return $this->hasMany(UserFollowUserModel::class, 'user_id_followed', 'user_id');
    }

    public function followers()
    {
        return $this->hasMany(UserFollowUserModel::class, 'user_id_follower', 'user_id');
    }

    public function followeds()
    {
        return $this->hasMany(UserFollowUserModel::class, 'user_id_followed', 'user_id');
    }

    public function userTopics()
    {
        return $this->hasMany(UserTopicModel::class,  'user_id', 'user_id');
    }

    public function userScore()
    {
        return $this->hasOne(UserScoreModel::class, 'user_id'); // Check the foreign and local keys
    }

    public function blocked()
    {
        return $this->hasMany(UserBlockedUser::class, 'user_id_blocked', 'user_id');
    }


    public static function getData(Request $req)
    {
        try {
            $columns = array(
                0 => 'username',
                1 => 'user_id',
                2 => 'username',
                3 => 'country_code',
                4 => 'created_at',
                5 => '',
                6 => "followers",
                7 => 'following',
                8 => '',
                9 => '',
                10 => '',
                11 => '',
            );
            $searchName = $req->input('username');
            $searchCountryCode = $req->input('countryCode');
            $orderColumnIndex = (int) $req->input('order.0.column');
            $orderDirection = $req->input('order.0.dir', 'asc');
            $start = (int) $req->input('start', 0);
            $length = (int) $req->input('length', 10);
            $query = UserApps::select(
                'username',
                'user_id',
                'username',
                'country_code',
                'created_at'
            );

            $query->with([
                'followers',
                'followeds',
                'blocked',
                'userTopics' => function ($query) {
                    $query->join('topics', 'user_topics.topic_id', '=', 'topics.topic_id')
                        ->select('topics.name as topic_name', 'user_topics.*');
                }
            ]);

            if ($searchName !== null) {
                $query->where('username', 'ILIKE', '%' . $searchName . '%');
            }

            if ($searchCountryCode !== null) {
                $query->where('country_code', 'ILIKE', '%' . $searchCountryCode . '%');
            }

            $total = $query->count();

            $query->orderBy($columns[$orderColumnIndex], $orderDirection)
                ->offset($start)
                ->limit($length);

            $users = $query->get();
            $userIds = $users->pluck('user_id')->toArray();
            $userScores = UserScoreModel::whereIn('_id', $userIds)->get();

            $userScoreMap = [];

            foreach ($userScores as $userScore) {
                $userScoreMap[$userScore->_id] = $userScore;
            }

            foreach ($users as $user) {
                if (isset($userScoreMap[$user->user_id])) {
                    $userScore = $userScoreMap[$user->user_id];
                    $user->user_score = $userScore;
                }
            }
            return response()->json([
                'draw' => (int) $req->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $users,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
