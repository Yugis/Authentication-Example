<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'deadline' => 'datetime'
    ];

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
