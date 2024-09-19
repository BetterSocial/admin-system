<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicInvitationModel extends Model
{
    use HasFactory;
    protected $table = 'topic_invitions';
    protected $primaryKey = 'topic_invitations_id';
    protected $fillable = [
        'user_id_inviter',
        'user_id_invited',
        'topic_id',
    ];
}
