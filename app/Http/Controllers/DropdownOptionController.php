<?php

namespace App\Http\Controllers;

use App\Models\PropertyDropdownOption;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DropdownOptionController extends Controller
{
    /**
     * Display all dropdown options grouped by type.
     */
    public function index(Request $request)
    {
        $typesCatalog = PropertyDropdownOption::getTypesCatalog();
        $selectedType = $request->query('type', array_key_first($typesCatalog));

        if (!array_key_exists($selectedType, $typesCatalog)) {
            $selectedType = array_key_first($typesCatalog);
        }

        $options = PropertyDropdownOption::where('type', $selectedType)
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        $countsByType = [];
        foreach ($typesCatalog as $key => $meta) {
            $countsByType[$key] = PropertyDropdownOption::where('type', $key)->count();
        }

        return view('admin.dropdown_options.index', compact('typesCatalog', 'selectedType', 'options', 'countsByType'));
    }

    /**
     * Store a new dropdown option.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        if (empty($validated['value'])) {
            $validated['value'] = Str::slug($validated['name_en'], '_');
        }

        $validated['order'] = $validated['order'] ?? (PropertyDropdownOption::where('type', $validated['type'])->max('order') + 1);
        $validated['is_active'] = true;

        PropertyDropdownOption::create($validated);

        return redirect()->route('admin.dropdown-options.index', ['type' => $validated['type']])
            ->with('success', app()->getLocale() === 'ar' ? 'تمت إضافة الخيار بنجاح.' : 'Dropdown option added successfully.');
    }

    /**
     * Update an existing dropdown option.
     */
    public function update(Request $request, PropertyDropdownOption $dropdownOption)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $dropdownOption->update($validated);

        return redirect()->route('admin.dropdown-options.index', ['type' => $dropdownOption->type])
            ->with('success', app()->getLocale() === 'ar' ? 'تم تعديل الخيار بنجاح.' : 'Option updated successfully.');
    }

    /**
     * Toggle active state.
     */
    public function toggle(PropertyDropdownOption $dropdownOption)
    {
        $dropdownOption->update([
            'is_active' => !$dropdownOption->is_active,
        ]);

        $msg = $dropdownOption->is_active
            ? (app()->getLocale() === 'ar' ? 'تم تفعيل الخيار.' : 'Option activated.')
            : (app()->getLocale() === 'ar' ? 'تم تعطيل الخيار.' : 'Option deactivated.');

        return redirect()->route('admin.dropdown-options.index', ['type' => $dropdownOption->type])
            ->with('success', $msg);
    }

    /**
     * Delete an option.
     */
    public function destroy(PropertyDropdownOption $dropdownOption)
    {
        $type = $dropdownOption->type;
        $dropdownOption->delete();

        return redirect()->route('admin.dropdown-options.index', ['type' => $type])
            ->with('success', app()->getLocale() === 'ar' ? 'تم حذف الخيار.' : 'Option deleted successfully.');
    }
}
