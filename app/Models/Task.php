<?php

namespace App\Models;

use App\Models\Traits\DepartmentManagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory, DepartmentManagement;

    protected $guarded = [];

    protected $casts = [
        'deadline' => 'datetime'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
