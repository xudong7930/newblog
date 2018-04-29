<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function somepayload()
    {
        $payload = json_decode($this->payload, true);
        $command = $payload['data']['command'];
        $s = unserialize($command);
        return $s->link;
    }

}
