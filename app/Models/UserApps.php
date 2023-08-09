<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'is_banned'
    ];

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
        return $this->hasMany(UserTopicModel::class, 'user_id', 'user_id');
    }

    public function userScore()
    {
        return $this->hasOne(UserScoreModel::class, 'user_id'); // Check the foreign and local keys
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

            $query->with('followers', 'followeds');
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

            $userScoreMap = []; // Array associative untuk menyimpan user_score berdasarkan user_id

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
