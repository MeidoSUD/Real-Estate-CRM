<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\SidebarMenu;
use App\Models\SubSidebarMenu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SidebarMenuController extends Controller
{
    public function index(): View
    {
        $menus = SidebarMenu::with('allSubMenus')->orderBy('order')->get();
        $permissions = Permission::orderBy('slug')->get();

        return view('admin.menus.index', compact('menus', 'permissions'));
    }

    public function toggleMenu(SidebarMenu $menu): RedirectResponse
    {
        $menu->update(['is_active' => !$menu->is_active]);

        return back()->with('success', "Menu '{$menu->title}' status toggled.");
    }

    public function toggleSubMenu(SubSidebarMenu $subMenu): RedirectResponse
    {
        $subMenu->update(['is_active' => !$subMenu->is_active]);

        return back()->with('success', "Sub-menu '{$subMenu->title}' status toggled.");
    }

    public function updateMenuOrder(Request $request): RedirectResponse
    {
        $request->validate([
            'orders' => ['required', 'array'],
            'orders.*.id' => ['required', 'exists:sidebar_menus,id'],
            'orders.*.order' => ['required', 'integer'],
        ]);

        foreach ($request->input('orders') as $item) {
            SidebarMenu::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return back()->with('success', 'Menu order updated successfully.');
    }
}
