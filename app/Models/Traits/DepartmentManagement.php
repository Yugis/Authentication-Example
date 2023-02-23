<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait DepartmentManagement
{
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function assignToDepartment($department_id): bool
    {
        return $this->update(['department_id' => $department_id]);
    }

    public function revokeTaskAccess(): bool
    {
        return $this->update(['department_id' => null]);
    }
}
