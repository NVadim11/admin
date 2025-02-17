<?php
namespace Modules\ProjectVote\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectVote extends Model
{
    protected $fillable = [
        'project_id',
        'client_id',
        'client_ip',
        'client_agent',
        'user_id'
    ];

    protected $guarded = [];

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

}
