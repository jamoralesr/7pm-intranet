<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function space() {
        return $this->belongsTo(Space::class);
    }
}
