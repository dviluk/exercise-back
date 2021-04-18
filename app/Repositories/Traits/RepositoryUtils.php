<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;

trait RepositoryUtils
{
    protected function idIsModel($id): bool
    {
        return $id instanceof Model;
    }
}
