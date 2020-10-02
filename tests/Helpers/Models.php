<?php

namespace Iperson1337\Chat\Tests\Helpers\Models;

use Illuminate\Database\Eloquent\Model;
use Iperson1337\Chat\Traits\Messageable;

class User extends Model
{
    use Messageable;
    protected $table = 'mc_users';
}

class Client extends Model
{
    use Messageable;
    protected $table = 'mc_clients';
    protected $primaryKey = 'client_id';

    public function getParticipantDetails()
    {
        return [
            'name' => $this->name,
            'foo'  => 'bar',
        ];
    }
}

class Bot extends Model
{
    use Messageable;
    protected $table = 'mc_bots';
    protected $primaryKey = 'bot_id';
}
