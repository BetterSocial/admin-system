<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        'blocked_by_admin',
        'verified_status',
        'combinned_user_score',
        'karma_score',
        'is_karma_unlocked',
        'followers_count_old',
        'followers_count',
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
        return $this->hasOne(UserScoreModel::class, '_id'); // Check the foreign and local keys
    }

    public function blocked()
    {
        return $this->hasMany(UserBlockedUser::class, 'user_id_blocked', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(UserPostComment::class, 'author_user_id', 'user_id');
    }

    public static function userQuery(Request $req)
    {
        $searchName = $req->input('username');
        $searchUserId = $req->input('user_id');
        $searchCountryCode = $req->input('countryCode');
        $searchTopic = $req->input('topic');
        $query = UserApps::select(
            'username',
            'user_id',
            'username',
            'country_code',
            'created_at',
            'is_banned',
            'blocked_by_admin',
        );

        $query->with([
            'followers',
            'followeds',
            'blocked',
            'userTopics.topic',
        ]);


        if ($searchUserId !== null) {
            $query->where('user_id', 'ILIKE', $searchUserId);
        }


        if ($searchName !== null) {
            $query->where('username', 'ILIKE', '%' . $searchName . '%');
        }

        if ($searchCountryCode !== null) {
            $query->where('country_code', 'ILIKE', '%' . $searchCountryCode . '%');
        }

        if ($searchTopic) {
            $query->whereHas('userTopics.topic', function ($query) use ($searchTopic) {
                $query->where('name', 'like', "%$searchTopic%");
            });
        }
        return $query;
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
                11 => 'karma_score',
                12 => '',
                13 => '',
            );

            // Query user dengan karma_score langsung dari UserApps
            $query = UserApps::userQuery($req)
                ->select('user_id', 'username', 'country_code', 'created_at', DB::raw('FLOOR(karma_score) as karma_score'), 'is_anonymous'); // Pilih kolom yang diperlukan termasuk karma_score

            $total = $query->count();

            $query = limitOrderQuery($req, $query, $columns);
            $users = $query->get();

            return response()->json([
                'draw' => (int) $req->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $users,
            ]);
        } catch (Exception $th) {
            return response()->json([
                'draw'            => 0,
                'recordsTotal'    => 0,
                "recordsFiltered" => 0,
                'data'            => [],
            ]);
        }
    }



    public static function getUserDetail($userId)
    {
        try {

            $user = UserApps::where('user_id', $userId)->first();
            $userScores = UserScoreModel::find($userId);
            $user->user_score = $userScores;
            return $user;
        } catch (Exception $th) {
            throw $th;
        }
    }
}
