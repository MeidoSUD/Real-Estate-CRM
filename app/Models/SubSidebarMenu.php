<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubSidebarMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'sidebar_menu_id',
        'title',
        'title_ar',
        'route',
        'permission_slug',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(SidebarMenu::class, 'sidebar_menu_id');
    }

    public function isAccessibleBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        if ($user->hasRole('admin')) {
            return true;
        }

        if (empty($this->permission_slug)) {
            return true;
        }

        return $user->hasPermission($this->permission_slug);
    }
}
