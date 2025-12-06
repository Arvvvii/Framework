<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait IsDeletedFlag
{
    /**
     * Boot the trait and add global scopes to exclude soft-deleted rows.
     * Supports both the legacy `is_deleted` flag and the newer `deleted_at` column.
     */
    public static function bootIsDeletedFlag()
    {
        try {
            $instance = new static;
            $table = $instance->getTable();
        } catch (\Throwable $e) {
            return;
        }

        // If table uses old is_deleted flag, keep existing behavior
        if (Schema::hasColumn($table, 'is_deleted')) {
            static::addGlobalScope('is_deleted', function (Builder $builder) {
                $builder->where(function ($q) {
                    $q->where('is_deleted', 0)->orWhereNull('is_deleted');
                });
            });
        }

        // If table has deleted_at, add a scope to hide soft-deleted rows
        if (Schema::hasColumn($table, 'deleted_at')) {
            static::addGlobalScope('deleted_at', function (Builder $builder) use ($table) {
                // use table-qualified column when possible
                $builder->whereNull($table . '.deleted_at');
            });
        }
    }

    /**
     * Mark this model as deleted.
     * - If `deleted_at` column exists, set `deleted_at` and `deleted_by`.
     * - Else if `is_deleted` exists, fallback to flag behavior.
     * - Else perform hard delete.
     */
    public function markDeleted()
    {
        $table = $this->getTable();

        if (Schema::hasColumn($table, 'deleted_at')) {
            $this->deleted_at = now();
            try {
                $this->deleted_by = auth()->id() ?? null;
            } catch (\Throwable $e) {
                $this->deleted_by = null;
            }
            return $this->save();
        }

        if (Schema::hasColumn($table, 'is_deleted')) {
            $this->is_deleted = 1;
            return $this->save();
        }

        return parent::delete();
    }

    /**
     * Override delete() so existing code that calls ->delete() will perform
     * a soft-delete when `deleted_at` (or `is_deleted`) exists.
     */
    public function delete()
    {
        $table = $this->getTable();

        if (Schema::hasColumn($table, 'deleted_at')) {
            $this->deleted_at = now();
            try {
                $this->deleted_by = auth()->id() ?? null;
            } catch (\Throwable $e) {
                $this->deleted_by = null;
            }
            return $this->save();
        }

        if (Schema::hasColumn($table, 'is_deleted')) {
            $this->is_deleted = 1;
            return $this->save();
        }

        return parent::delete();
    }

    /**
     * Restore this model (clear deleted flags) if supported.
     */
    public function restoreFlag()
    {
        $table = $this->getTable();

        if (Schema::hasColumn($table, 'deleted_at')) {
            $this->deleted_at = null;
            $this->deleted_by = null;
            return $this->save();
        }

        if (Schema::hasColumn($table, 'is_deleted')) {
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
