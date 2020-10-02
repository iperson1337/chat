<?php

namespace Iperson1337\Chat\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Iperson1337\Chat\BaseModel;
use Iperson1337\Chat\ConfigurationManager;

class Participation extends BaseModel
{
//    use SoftDeletes;

    protected $table = ConfigurationManager::PARTICIPATION_TABLE;
    protected $fillable = [
        'conversation_id',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Conversation.
     *
     * @return BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function messageable()
    {
        return $this->morphTo()->with('participation');
    }
}
