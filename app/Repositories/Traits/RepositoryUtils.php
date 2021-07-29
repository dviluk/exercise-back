<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;

trait RepositoryUtils
{
    /**
     * Valida si el $id es una instancia de un modelo.
     * 
     * @param mixed $id 
     * @return bool 
     */
    protected function idIsModel($id)
    {
        return $id instanceof Model;
    }
}
