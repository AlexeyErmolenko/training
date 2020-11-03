<?php

namespace App\Models\Helpers;

use Illuminate\Support\Str;

trait CamelCaseForeignKeys
{
    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey(): string
    {
        return lcfirst(class_basename($this)).Str::studly($this->getKeyName());
    }
}
