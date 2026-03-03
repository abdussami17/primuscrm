<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    /**
     * Get all roles
     */
    public function getRoles()
    {
        $roles = Role::orderBy('name')->get(['id', 'name']);
        
        return response()->json($roles);
    }

    /**
     * Get permissions for a specific role
     */
    public function getRolePermissions($roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = $role->permissions()->pluck('name')->toArray();
        
        return response()->json([
            'role' => $role->name,
            'permissions' => $permissions
        ]);
    }

    /**
     * Get all available permissions grouped by category
     */
    public function getAllPermissions()
    {
        $permissions = Permission::orderBy('name')->get(['id', 'name']);
        
        // Group permissions by category (first part before space or dash)
        $grouped = [];
        foreach ($permissions as $permission) {
            // Extract category from permission name
            // e.g., "View Customers" -> "Customers", "Create Customer" -> "Customer"
            $parts = explode(' ', $permission->name);
            $category = count($parts) > 1 ? end($parts) : 'General';
            
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            
            $grouped[$category][] = [
                'id' => $permission->id,
                'name' => $permission->name
            ];
        }
        
        return response()->json($grouped);
    }

    /**
     * Update permissions for a role
     */
    public function updateRolePermissions(Request $request, $roleId)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name'
        ]);

        $role = Role::findOrFail($roleId);
        
        // Sync permissions (this will remove old ones and add new ones)
        $role->syncPermissions($request->permissions);

        return response()->json([
            'success' => true,
            'message' => 'Permissions updated successfully for ' . $role->name
        ]);
    }

    /**
     * Toggle a single permission for a role
     */
    public function togglePermission(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required|string|exists:permissions,name',
            'enabled' => 'required|boolean'
        ]);

        $role = Role::findOrFail($roleId);
        
        if ($request->enabled) {
            $role->givePermissionTo($request->permission);
        } else {
            $role->revokePermissionTo($request->permission);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permission ' . ($request->enabled ? 'granted' : 'revoked')
        ]);
    }
}
