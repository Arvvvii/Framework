<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait IsDeletedFlag
{
    /**
     * Boot the trait and add a global scope to exclude is_deleted rows,
     * but only if the underlying table actually has the `is_deleted` column.
     */
    public static function bootIsDeletedFlag()
    {
        // create an instance to get the table name
        try {
            $instance = new static;
            $table = $instance->getTable();
        } catch (\Throwable $e) {
            return;
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn($table, 'is_deleted')) {
            static::addGlobalScope('is_deleted', function (Builder $builder) {
                $builder->where(function ($q) {
                    $q->where('is_deleted', 0)->orWhereNull('is_deleted');
                });
            });
        }
    }

    /**
     * Mark this model as deleted (soft delete using is_deleted flag),
     * or fallback to hard delete when column doesn't exist.
     */
    public function markDeleted()
    {
        if (\Illuminate\Support\Facades\Schema::hasColumn($this->getTable(), 'is_deleted')) {
            $this->is_deleted = 1;
            return $this->save();
        }

        // fallback: no is_deleted column -> perform real delete
        return parent::delete();
    }

    /**
     * Restore this model (unset is_deleted flag) if supported.
     */
    public function restoreFlag()
    {
        if (\Illuminate\Support\Facades\Schema::hasColumn($this->getTable(), 'is_deleted')) {
            $this->is_deleted = 0;
            return $this->save();
        }
        return false;
    }

    /**
     * Force delete bypassing flag.
     */
    public function forceDeleteFlag()
    {
        return parent::delete();
    }
}
