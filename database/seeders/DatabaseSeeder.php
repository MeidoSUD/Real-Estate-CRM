<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\Permission;
use App\Models\PermissionCategory;
use App\Models\PropertyOffer;
use App\Models\Role;
use App\Models\SidebarMenu;
use App\Models\SubSidebarMenu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. ROLES
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Full administrative access to manage staff, roles, permissions, offers, and settings.',
            'is_system' => true,
        ]);

        $marketingRole = Role::create([
            'name' => 'Marketing Team',
            'slug' => 'marketing',
            'description' => 'Collects real estate offers, manages property listings, photos, and public showcases.',
            'is_system' => true,
        ]);

        $customerServiceRole = Role::create([
            'name' => 'Customer Service',
            'slug' => 'customer-service',
            'description' => 'Communicates with property owners, prospective buyers, inquiries, and follow-ups.',
            'is_system' => true,
        ]);

        // 2. PERMISSION CATEGORIES & PERMISSIONS
        $categoriesData = [
            [
                'name' => 'Users & Staff Management',
                'name_ar' => 'إدارة المستخدمين والموظفين',
                'slug' => 'staff_management',
                'icon' => 'users',
                'order' => 1,
                'permissions' => [
                    ['name' => 'View Users', 'name_ar' => 'عرض الموظفين والمستخدمين', 'slug' => 'users.view', 'description' => 'Can view list of staff and their profiles'],
                    ['name' => 'Create User', 'name_ar' => 'إضافة موظف جديد', 'slug' => 'users.create', 'description' => 'Can register new staff members and assign their roles'],
                    ['name' => 'Edit User', 'name_ar' => 'تعديل بيانات الموظف', 'slug' => 'users.edit', 'description' => 'Can edit staff details and toggle active status'],
                    ['name' => 'Delete User', 'name_ar' => 'حذف موظف', 'slug' => 'users.delete', 'description' => 'Can remove staff members from the system'],
                ],
            ],
            [
                'name' => 'Roles & Permissions',
                'name_ar' => 'الأدوار ومصفوفة الصلاحيات',
                'slug' => 'roles_management',
                'icon' => 'shield',
                'order' => 2,
                'permissions' => [
                    ['name' => 'View Roles', 'name_ar' => 'عرض الأدوار والصلاحيات', 'slug' => 'roles.view', 'description' => 'Can view roles and assigned permissions'],
                    ['name' => 'Create Role', 'name_ar' => 'إضافة دور جديد', 'slug' => 'roles.create', 'description' => 'Can create custom roles'],
                    ['name' => 'Edit Role', 'name_ar' => 'تعديل الدور والصلاحيات', 'slug' => 'roles.edit', 'description' => 'Can update permissions attached to roles'],
                    ['name' => 'Delete Role', 'name_ar' => 'حذف الدور', 'slug' => 'roles.delete', 'description' => 'Can remove non-system roles'],
                ],
            ],
            [
                'name' => 'Property Offers & Listings',
                'name_ar' => 'العروض والوحدات العقارية',
                'slug' => 'offers_management',
                'icon' => 'home',
                'order' => 3,
                'permissions' => [
                    ['name' => 'View Offers', 'name_ar' => 'عرض العروض العقارية', 'slug' => 'offers.view', 'description' => 'Can view listed property offers'],
                    ['name' => 'Create Offer', 'name_ar' => 'إضافة وتجميع عرض جديد', 'slug' => 'offers.create', 'description' => 'Can collect and create new property offers'],
                    ['name' => 'Edit Offer', 'name_ar' => 'تعديل بيانات العرض', 'slug' => 'offers.edit', 'description' => 'Can edit offer pricing, description, specs and media'],
                    ['name' => 'Delete Offer', 'name_ar' => 'حذف العرض العقاري', 'slug' => 'offers.delete', 'description' => 'Can remove property offers'],
                    ['name' => 'Publish Offer', 'name_ar' => 'تغيير حالة العرض ونشره', 'slug' => 'offers.publish', 'description' => 'Can change status to available, reserved, sold, or rented'],
                ],
            ],
            [
                'name' => 'Customer Service & Leads',
                'name_ar' => 'خدمة العملاء والتواصل مع الملاك والمشترين',
                'slug' => 'leads_management',
                'icon' => 'phone',
                'order' => 4,
                'permissions' => [
                    ['name' => 'View Leads', 'name_ar' => 'عرض طلبات العملاء', 'slug' => 'leads.view', 'description' => 'Can view incoming website inquiries and leads'],
                    ['name' => 'Contact Owner', 'name_ar' => 'التواصل مع ملاك العقارات', 'slug' => 'leads.contact_owner', 'description' => 'Can contact and follow up with property owners'],
                    ['name' => 'Contact Buyer', 'name_ar' => 'التواصل مع المشترين', 'slug' => 'leads.contact_buyer', 'description' => 'Can contact prospective buyers and schedule viewings'],
                    ['name' => 'Update Lead Status', 'name_ar' => 'تحديث حالة الطلب والملاحظات', 'slug' => 'leads.update_status', 'description' => 'Can update inquiry progress, notes, and outcomes'],
                    ['name' => 'Assign Lead', 'name_ar' => 'إسناد الطلب للموظف', 'slug' => 'leads.assign', 'description' => 'Can assign leads to customer service agents'],
                ],
            ],
            [
                'name' => 'Sidebar & Navigation',
                'name_ar' => 'القوائم وإعدادات النظام',
                'slug' => 'sidebar_management',
                'icon' => 'menu',
                'order' => 5,
                'permissions' => [
                    ['name' => 'Manage Navigation', 'name_ar' => 'إدارة القوائم والتنقل', 'slug' => 'sidebar.manage', 'description' => 'Can manage sidebar menus and submenus structure'],
                ],
            ],
        ];

        $allPermissionIds = [];
        $marketingPermissionIds = [];
        $customerServicePermissionIds = [];

        foreach ($categoriesData as $catData) {
            $permissions = $catData['permissions'];
            unset($catData['permissions']);

            $category = PermissionCategory::create($catData);

            foreach ($permissions as $perm) {
                $createdPerm = Permission::create([
                    'permission_category_id' => $category->id,
                    'name' => $perm['name'],
                    'name_ar' => $perm['name_ar'],
                    'slug' => $perm['slug'],
                    'description' => $perm['description'],
                ]);

                $allPermissionIds[] = $createdPerm->id;

                // Assign to Marketing Team
                if (in_array($perm['slug'], [
                    'offers.view', 'offers.create', 'offers.edit', 'offers.publish',
                    'leads.view',
                ])) {
                    $marketingPermissionIds[] = $createdPerm->id;
                }

                // Assign to Customer Service
                if (in_array($perm['slug'], [
                    'leads.view', 'leads.contact_owner', 'leads.contact_buyer', 'leads.update_status',
                    'offers.view',
                ])) {
                    $customerServicePermissionIds[] = $createdPerm->id;
                }
            }
        }

        // Attach permissions to roles
        $adminRole->permissions()->sync($allPermissionIds);
        $marketingRole->permissions()->sync($marketingPermissionIds);
        $customerServiceRole->permissions()->sync($customerServicePermissionIds);

        // 3. SEED USERS
        $admin = User::create([
            'first_name' => 'Ashraf',
            'last_name' => 'Al-Ghamdi',
            'email' => 'admin@realestate.sa',
            'password' => Hash::make('password'),
            'job_title' => 'CRM Administrator & Executive Director',
            'phone' => '+966 50 123 4567',
            'gender' => 'male',
            'address' => 'Al-Shati District, Prince Faisal Bin Fahd Road, Jeddah, KSA',
            'role_id' => $adminRole->id,
            'is_active' => true,
        ]);

        $marketingUser = User::create([
            'first_name' => 'Sarah',
            'last_name' => 'Al-Zahrani',
            'email' => 'marketing@realestate.sa',
            'password' => Hash::make('password'),
            'job_title' => 'Senior Real Estate Marketing Specialist',
            'phone' => '+966 54 876 5432',
            'gender' => 'female',
            'address' => 'Al-Rawdah District, Prince Saud Al-Faisal St, Jeddah, KSA',
            'role_id' => $marketingRole->id,
            'is_active' => true,
        ]);

        $serviceUser = User::create([
            'first_name' => 'Fahad',
            'last_name' => 'Al-Harbi',
            'email' => 'service@realestate.sa',
            'password' => Hash::make('password'),
            'job_title' => 'Client Relations & Customer Care Officer',
            'phone' => '+966 55 987 6543',
            'gender' => 'male',
            'address' => 'Al-Hamra District, Al-Amana St, Jeddah, KSA',
            'role_id' => $customerServiceRole->id,
            'is_active' => true,
        ]);

        // 4. SIDEBAR MENUS & SUB-MENUS
        $menuDashboard = SidebarMenu::create([
            'title' => 'Dashboard',
            'title_ar' => 'لوحة التحكم',
            'icon' => 'dashboard',
            'route' => 'admin.dashboard',
            'permission_slug' => null,
            'order' => 1,
            'is_active' => true,
        ]);

        $menuOffers = SidebarMenu::create([
            'title' => 'Offers & Listings',
            'title_ar' => 'العروض العقارية',
            'icon' => 'home',
            'route' => null,
            'permission_slug' => 'offers.view',
            'order' => 2,
            'is_active' => true,
        ]);
        SubSidebarMenu::create([
            'sidebar_menu_id' => $menuOffers->id,
            'title' => 'All Property Offers',
            'title_ar' => 'جميع العروض',
            'route' => 'admin.offers.index',
            'permission_slug' => 'offers.view',
            'order' => 1,
            'is_active' => true,
        ]);
        SubSidebarMenu::create([
            'sidebar_menu_id' => $menuOffers->id,
            'title' => 'Add New Offer',
            'title_ar' => 'إضافة عرض جديد',
            'route' => 'admin.offers.create',
            'permission_slug' => 'offers.create',
            'order' => 2,
            'is_active' => true,
        ]);

        $menuLeads = SidebarMenu::create([
            'title' => 'Customer Care & Leads',
            'title_ar' => 'خدمة العملاء والطلبات',
            'icon' => 'phone-call',
            'route' => null,
            'permission_slug' => 'leads.view',
            'order' => 3,
            'is_active' => true,
        ]);
        SubSidebarMenu::create([
            'sidebar_menu_id' => $menuLeads->id,
            'title' => 'All Leads & Inquiries',
            'title_ar' => 'جميع الطلبات والاستفسارات',
            'route' => 'admin.leads.index',
            'permission_slug' => 'leads.view',
            'order' => 1,
            'is_active' => true,
        ]);

        $menuUsers = SidebarMenu::create([
            'title' => 'Staff & Users',
            'title_ar' => 'فريق العمل والمستخدمين',
            'icon' => 'users',
            'route' => null,
            'permission_slug' => 'users.view',
            'order' => 4,
            'is_active' => true,
        ]);
        SubSidebarMenu::create([
            'sidebar_menu_id' => $menuUsers->id,
            'title' => 'All Staff Members',
            'title_ar' => 'قائمة الموظفين',
            'route' => 'admin.users.index',
            'permission_slug' => 'users.view',
            'order' => 1,
            'is_active' => true,
        ]);
        SubSidebarMenu::create([
            'sidebar_menu_id' => $menuUsers->id,
            'title' => 'Add New Staff',
            'title_ar' => 'إضافة موظف جديد',
            'route' => 'admin.users.create',
            'permission_slug' => 'users.create',
            'order' => 2,
            'is_active' => true,
        ]);

        $menuRoles = SidebarMenu::create([
            'title' => 'Roles & Permissions',
            'title_ar' => 'الأدوار والصلاحيات',
            'icon' => 'shield-check',
            'route' => 'admin.roles.index',
            'permission_slug' => 'roles.view',
            'order' => 5,
            'is_active' => true,
        ]);

        $menuMenus = SidebarMenu::create([
            'title' => 'Sidebar Navigation',
            'title_ar' => 'إدارة القوائم',
            'icon' => 'menu',
            'route' => 'admin.menus.index',
            'permission_slug' => 'sidebar.manage',
            'order' => 6,
            'is_active' => true,
        ]);

        // 5. SAMPLE JEDDAH PROPERTY OFFERS
        PropertyOffer::create([
            'title' => 'Ultra-Luxury Modern Villa with Pool in Al-Shati',
            'title_ar' => 'فيلا مودرن فاخرة مع مسبح خاص بحي الشاطئ',
            'slug' => 'ultra-luxury-modern-villa-al-shati',
            'property_type' => 'Villa',
            'purpose' => 'sale',
            'price' => 7450000,
            'currency' => 'SAR',
            'city' => 'Jeddah',
            'district' => 'Al-Shati',
            'address' => 'Prince Faisal Bin Fahd St, Al-Shati, Jeddah',
            'bedrooms' => 6,
            'bathrooms' => 8,
            'area_sqm' => 720,
            'description' => 'Spectacular newly completed contemporary villa in prestigious Al-Shati district. Features smart home automation, expansive double-height ceilings, private illuminated swimming pool, Italian marble flooring, panoramic floor-to-ceiling glass, driver and maid suites, and elevator.',
            'features' => ['Private Pool', 'Smart Home', 'Elevator', 'Driver Room', 'Maid Suite', 'Rooftop Lounge', 'Garden', 'Covered Parking'],
            'main_image' => 'images/properties/villa_alshati.jpg',
            'status' => 'available',
            'is_featured' => true,
            'created_by' => $marketingUser->id,
        ]);

        PropertyOffer::create([
            'title' => 'Panoramic Red Sea Skyline Penthouse at Corniche',
            'title_ar' => 'بنتهاوس بانورامي بإطلالة كورنيش جدة ونافورة الملك فهد',
            'slug' => 'panoramic-red-sea-skyline-penthouse-corniche',
            'property_type' => 'Penthouse',
            'purpose' => 'sale',
            'price' => 5200000,
            'currency' => 'SAR',
            'city' => 'Jeddah',
            'district' => 'Al-Hamra',
            'address' => 'Corniche Road, Al-Hamra, Jeddah',
            'bedrooms' => 4,
            'bathrooms' => 5,
            'area_sqm' => 480,
            'description' => 'Exclusive sky residence overlooking the Red Sea and King Fahd Fountain. Features grand salon with rich walnut wood panels, designer dining hall, private jacuzzi terrace with sunset sea views, 24/7 concierge, private high-speed lift access, and two underground parking spots.',
            'features' => ['Direct Sea View', 'King Fahd Fountain View', 'Jacuzzi Terrace', 'Private Lift', 'Concierge Service', 'Gym & Spa', 'Valet Parking'],
            'main_image' => 'images/properties/penthouse_corniche.jpg',
            'status' => 'available',
            'is_featured' => true,
            'created_by' => $marketingUser->id,
        ]);

        PropertyOffer::create([
            'title' => 'The Jeddah Residences - Designer Duplex in Al-Rawdah',
            'title_ar' => 'شقق ومجمع ذا جدة رزيدنس الفاخر بحي الروضة',
            'slug' => 'the-jeddah-residences-designer-duplex-al-rawdah',
            'property_type' => 'Apartment',
            'purpose' => 'sale',
            'price' => 1950000,
            'currency' => 'SAR',
            'city' => 'Jeddah',
            'district' => 'Al-Rawdah',
            'address' => 'Prince Saud Al-Faisal Road, Al-Rawdah, Jeddah',
            'bedrooms' => 4,
            'bathrooms' => 4,
            'area_sqm' => 310,
            'description' => 'Architectural masterpiece in the heart of Al-Rawdah. Gated boutique residential community with illuminated fountains, traditional bronze mashrabiya latticework, children play area, central AC, landscaped courtyards, and close proximity to top restaurants and schools.',
            'features' => ['Gated Community', 'Bronze Mashrabiya', 'Landscaped Courtyard', 'Security 24/7', 'Modern Kitchen', 'Central AC'],
            'main_image' => 'images/properties/residences_rawdah.jpg',
            'status' => 'available',
            'is_featured' => true,
            'created_by' => $marketingUser->id,
        ]);

        // 6. SAMPLE CUSTOMER LEADS
        Lead::create([
            'name' => 'Eng. Abdulaziz Al-Otaibi',
            'email' => 'abdulaziz.otaibi@example.com',
            'phone' => '+966 50 443 2198',
            'type' => 'buyer',
            'property_offer_id' => 1,
            'message' => 'Interested in scheduling an on-site viewing for the Al-Shati luxury villa this Thursday evening.',
            'status' => 'new',
            'assigned_to' => $serviceUser->id,
            'notes' => 'Client is pre-approved for mortgage, looking for immediate purchase.',
        ]);

        Lead::create([
            'name' => 'Sheikh Mansour Al-Ghamdi',
            'email' => 'm.ghamdi@example.com',
            'phone' => '+966 55 112 3344',
            'type' => 'owner',
            'property_offer_id' => null,
            'message' => 'I have a 1,500 sqm commercial land plot on King Abdulaziz Road that I would like your agency to evaluate and market.',
            'status' => 'in_progress',
            'assigned_to' => $serviceUser->id,
            'notes' => 'Contacted owner. Requested deed copies and zoning certificates.',
        ]);

        Lead::create([
            'name' => 'Dr. Reem Al-Shehri',
            'email' => 'reem.shehri@example.com',
            'phone' => '+966 56 778 8990',
            'type' => 'buyer',
            'property_offer_id' => 2,
            'message' => 'Would like to know more about the penthouse HOA fees and available installment plans.',
            'status' => 'contacted',
            'assigned_to' => $serviceUser->id,
            'notes' => 'Sent brochure and payment schedule via WhatsApp.',
        ]);
    }
}
