<?php

namespace App\Helpers;

class PermissionHelper
{
    /**
     * Map permissions to sidebar menu items
     */
    public static function getSidebarMenus(): array
    {
        return [
            [
                'route' => 'dashboard',
                'icon' => 'ti ti-home',
                'label' => 'Home',
                'permission' => null, // Everyone can access
            ],
            [
                'route' => 'email.inbox',
                'icon' => 'ti ti-inbox',
                'label' => 'Email Inbox',
                'permission' => 'Send Email',
            ],
            [
                'route' => 'text.inbox',
                'icon' => 'ti ti-message',
                'label' => 'Text Inbox',
                'permission' => 'Send Text',
            ],
            [
                'route' => 'primus.ai',
                'icon' => 'ti ti-brand-openai',
                'label' => 'Primus AI',
                'permission' => null, // Everyone can access
            ],
            [
                'route' => 'tasks.index',
                'icon' => 'ti ti-checkup-list',
                'label' => 'Tasks',
                'permission' => 'Create Tasks',
            ],
            [
                'route' => 'customers.index',
                'icon' => 'ti ti-users',
                'label' => 'Customers',
                'permission' => 'View All Dealer Deals/Customer Info',
            ],
            [
                'route' => 'desk-log.manager',
                'icon' => 'isax isax-programming-arrows5',
                'label' => 'Manager\'s Desklog',
                'permission' => 'Access To Manager\'s Desk Log',
            ],
            [
                'route' => 'inventory.web',
                'icon' => 'ti ti-building-warehouse',
                'label' => 'Inventory',
                'permission' => null, // Determine appropriate permission
            ],
            [
                'route' => 'employee-desk-log.employee',
                'icon' => 'ti ti-building-store',
                'label' => 'Employee Desklog',
                'permission' => 'Access To Showroom',
            ],
            [
                'route' => 'templates.index',
                'icon' => 'ti ti-template',
                'label' => 'Templates',
                'permission' => 'Access To Campaigns & Templates',
            ],
            [
                'route' => 'smart-sequences.index',
                'icon' => 'ti ti-brand-campaignmonitor',
                'label' => 'Smart Follow Up',
                'permission' => 'Access To Smart Sequences',
            ],
            [
                'route' => 'campaigns',
                'icon' => 'ti ti-sitemap',
                'label' => 'Campaigns',
                'permission' => 'Access To Campaigns',
            ],
            [
                'route' => 'users',
                'icon' => 'ti ti-users-group',
                'label' => 'Users',
                'permission' => 'Access To Users',
            ],
            [
                'route' => 'calendar.index',
                'icon' => 'ti ti-calendar-week',
                'label' => 'Calendar',
                'permission' => 'Access Calendar',
            ],
            [
                'route' => 'wishlist',
                'icon' => 'ti ti-heart',
                'label' => 'My Wishlist',
                'permission' => null, // Everyone can access their wishlist
            ],
            [
                'route' => 'reports-analytics',
                'icon' => 'ti ti-chart-bar',
                'label' => 'Reports & Analytics',
                'permission' => 'Access Reports & Analytics',
            ],
        ];
    }

    /**
     * Get submenu items for Help section
     */
    public static function getHelpSubmenu(): array
    {
        return [
            [
                'route' => 'settings',
                'label' => 'Settings',
                'permission' => 'Access To Dealership Settings',
            ],
            [
                'route' => 'product-update',
                'label' => 'Product Updates',
                'permission' => null,
            ],
            [
                'route' => 'contact-support',
                'label' => 'Contact Support',
                'permission' => null,
            ],
            [
                'route' => 'dealership-training-material',
                'label' => 'Dealership Training Material',
                'permission' => null,
            ],
        ];
    }

    /**
     * Check if user has permission to view menu item
     */
    public static function canViewMenu(?string $permission): bool
    {
        if (!$permission) {
            return true; // No permission required
        }

        return auth()->check() && auth()->user()->hasPermissionTo($permission);
    }
}
