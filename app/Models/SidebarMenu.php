<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SidebarMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'icon',
        'route',
        'permission_slug',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function subMenus(): HasMany
    {
        return $this->hasMany(SubSidebarMenu::class)->where('is_active', true)->orderBy('order');
    }

    public function allSubMenus(): HasMany
    {
        return $this->hasMany(SubSidebarMenu::class)->orderBy('order');
    }

    public function isAccessibleBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        // If user is admin, allow access
        if ($user->hasRole('admin')) {
            return true;
        }

        // If no permission restriction, allow
        if (empty($this->permission_slug)) {
            // Check if any of its submenus are accessible
            if ($this->subMenus->isNotEmpty()) {
                return $this->subMenus->contains(fn($sub) => $sub->isAccessibleBy($user));
            }
            return true;
        }

        return $user->hasPermission($this->permission_slug);
    }
}
