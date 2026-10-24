<?php

namespace App\Providers;

use App\Models\SidebarMenu;
use App\Models\SubSidebarMenu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.admin', function ($view) {
            try {
                // Ensure dropdown-options submenu exists under system settings for Admin
                if (Schema::hasTable('sidebar_menus') && Schema::hasTable('sub_sidebar_menus')) {
                    $systemMenu = SidebarMenu::where('permission_slug', 'sidebar.manage')->first();
                    if ($systemMenu && $systemMenu->allSubMenus()->count() === 0) {
                        $systemMenu->update([
                            'route' => null,
                            'title' => 'System & Dropdowns',
                            'title_ar' => 'إعدادات القوائم والنظام',
                            'icon' => 'sliders',
                        ]);

                        SubSidebarMenu::firstOrCreate(
                            ['route' => 'admin.menus.index'],
                            [
                                'sidebar_menu_id' => $systemMenu->id,
                                'title' => 'Sidebar Navigation',
                                'title_ar' => 'قوائم التنقل الجانبية',
                                'permission_slug' => 'sidebar.manage',
                                'order' => 1,
                                'is_active' => true,
                            ]
                        );

                        SubSidebarMenu::firstOrCreate(
                            ['route' => 'admin.dropdown-options.index'],
                            [
                                'sidebar_menu_id' => $systemMenu->id,
                                'title' => 'Property Dropdown Options',
                                'title_ar' => 'خيارات القوائم المنسدلة للعروض',
                                'permission_slug' => 'sidebar.manage',
                                'order' => 2,
                                'is_active' => true,
                            ]
                        );
                    }
                }
            } catch (\Throwable $e) {
                // Ignore during pre-database boot
            }

            $menus = collect();
            try {
                if (Schema::hasTable('sidebar_menus')) {
                    $menus = SidebarMenu::with(['subMenus' => function ($q) {
                        $q->where('is_active', true)->orderBy('order');
                    }])
                    ->where('is_active', true)
                    ->orderBy('order')
                    ->get();
                }
            } catch (\Throwable $e) {
                // Graceful fallback
            }

            $view->with('sidebarMenus', $menus);
        });
    }
}
