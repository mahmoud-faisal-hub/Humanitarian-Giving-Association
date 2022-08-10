<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'عرض الأخبار',
            'عرض إحصائيات الأخبار',
            'إضافة خبر',
            'تعديل خبر',
            'حذف خبر',
            'عرض الأقسام',
            'عرض إحصائيات الأقسام',
            'إضافة قسم',
            'تعديل قسم',
            'حذف قسم',
            'عرض المعرض',
            'عرض إحصائيات المعرض',
            'إضافة وسائط',
            'تعديل وسائط',
            'حذف وسائط',
            'عرض الرسائل',
            'عرض إحصائيات الرسائل',
            'حذف رسالة',
            'عرض الأعضاء',
            'عرض إحصائيات الأعضاء',
            'إضافة عضو',
            'تعديل عضو',
            'حذف عضو',
            'عرض الأدوار',
            'إضافة دور',
            'تعديل دور',
            'حذف دور',
            'تعيين دور',
            'عرض الصلاحيات',
            'تعيين صلاحية',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }
    }
}
