<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserPostComment extends Model
{
    use HasFactory;
    protected $table    = 'user_post_comment';
    protected $primaryKey = 'id';

    protected $fillable = [
        'post_id',
        'parent_comment_id',
        'comment_id',
        'author_user_id',
        'commenter_user_id',
        'is_anonymous',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(UserApps::class, 'author_user_id', 'user_id');
    }

    public static function data(Request $request)
    {
        try {
            // this function use datatable

            $columns = array(
                0 => 'post_id',
                1 => 'comment_id',
                2 => 'comment',
            );
            $userId = $request->input('user_id');
            $query = UserPostComment::query();
            $query->where('commenter_user_id', $userId);

            $total = $query->count();
            $query = limitOrderQuery($request, $query, $columns);
            $userPostComments = $query->get();

            return response()->json([
                'draw' => intval($request->input('draw', 1)),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $userPostComments,
            ]);
        } catch (\Throwable $th) {
            throw $th; // Rethrow the exception automatically
        }
    }
}
