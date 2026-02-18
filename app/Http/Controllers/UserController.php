<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\SecuritySetting;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Rap2hpoutre\FastExcel\FastExcel;
use Dompdf\Dompdf;
use Dompdf\Options;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        // Check permission
        if (!auth()->user()->hasPermissionTo('Access To Users')) {
            abort(403, 'You do not have permission to access users.');
        }

        // Build query for users with roles
        $query = User::with('roles')->orderBy('name');

        // Apply global search if provided (search name, email, or role name)
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'LIKE', "%{$q}%")
                    ->orWhere('email', 'LIKE', "%{$q}%")
                    ->orWhereHas('roles', function ($r) use ($q) {
                        $r->where('name', 'LIKE', "%{$q}%");
                    });
            });
        }

        $users = $query->paginate(50)->appends($request->only('q'));

        return view('users', compact('users'));
    }

    public function usersList(){
        $users = User::with('roles')
            ->orderBy('name')
            ->get();
         return response()->json([
            'status'  => 'success',
            'message' => 'User fetched successfully',
            'data'    => $users
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(Request $request)
    {
        // Check permission
        if (!auth()->user()->hasPermissionTo('Access To Users')) {
            abort(403, 'You do not have permission to create users.');
        }

        $roles = Role::orderBy('name')->get();
        $permissions = \Spatie\Permission\Models\Permission::orderBy('name')->get();
        
        // Check if we're duplicating an existing user
        $duplicateUser = null;
        if ($request->has('duplicate')) {
            $duplicateUser = User::with(['roles', 'permissions'])->find($request->duplicate);
        }
        
        // Get all users for Assigned Manager (all users)
        $allUsers = User::where('is_active', true)->orderBy('name')->get();
        
        // Get users by role for filtering
        $bdcAgents = User::where('is_active', true)
            ->whereHas('roles', function($query) {
                $query->where('name', 'LIKE', '%BDC%');
            })
            ->orderBy('name')
            ->get();
            
        $serviceAgents = User::where('is_active', true)
            ->whereHas('roles', function($query) {
                $query->where('name', 'LIKE', '%Service%');
            })
            ->orderBy('name')
            ->get();

        // Finance managers list for Assigned Finance Manager dropdown
        $financeManagers = User::where('is_active', true)
            ->whereHas('roles', function($query) {
                $query->where('name', 'LIKE', '%Finance%');
            })
            ->orderBy('name')
            ->get();
        
        return view('add-user', compact('roles', 'permissions', 'duplicateUser', 'allUsers', 'bdcAgents', 'serviceAgents', 'financeManagers'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        // Check permission
        if (!auth()->user()->hasPermissionTo('Access To Users')) {
            abort(403, 'You do not have permission to create users.');
        }

        // Apply configured minimum password length to request validation
        $minPassword = optional(SecuritySetting::first())->min_password_length ?? 8;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:' . (int) $minPassword,
            'work_phone' => 'nullable|string|max:20',
            'cell_phone' => 'nullable|string|max:20',
            'home_phone' => 'nullable|string|max:20',
            'title' => 'nullable|string|max:255',
            'sales_team' => 'required|string', // This is the role name
            'dealership_franchises' => 'nullable|array',
            'email_signature' => 'nullable|string',
            'working_hours' => 'nullable|string', // JSON string
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'assigned_manager' => 'nullable|integer|exists:users,id',
            'assigned_bdc_agent' => 'nullable|integer|exists:users,id',
            'assigned_finance_manager' => 'nullable|integer|exists:users,id',
            'receive_internet_lead' => 'nullable',
            'receive_off_hours' => 'nullable',
        ]);

        // Generate unique 4-digit employee number if not filled
        if(!$request->employee_number){
            $employeeNumber = str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
            $request->employee_number = $employeeNumber;
        }

        // Parse working hours JSON if provided
        $workingHours = null;
        if (!empty($validated['working_hours'])) {
            $decoded = json_decode($validated['working_hours'], true);
            // Only save if valid JSON was decoded
            if (is_array($decoded) && count($decoded) > 0) {
                $workingHours = $decoded;
            }
        }

        // Validate password against security settings
        $this->validatePasswordAgainstSecuritySettings($validated['password'] ?? null);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'work_phone' => $validated['work_phone'] ?? null,
            'cell_phone' => $validated['cell_phone'] ?? null,
            'home_phone' => $validated['home_phone'] ?? null,
            'title' => $validated['title'] ?? null,
            'employee_number' => $request->employee_number,
            'email_signature' => $validated['email_signature'] ?? null,
            'working_hours' => $workingHours,
            'dealership_franchises' => $validated['dealership_franchises'] ?? null,
            'is_active' => true,
            'assigned_manager' => $validated['assigned_manager'] ?? null,
            'assigned_bdc_agent' => $validated['assigned_bdc_agent'] ?? null,
            'assigned_finance_manager' => $validated['assigned_finance_manager'] ?? null,
            'receive_internet_lead' => isset($validated['receive_internet_lead']) ? 1 : 0,
            'receive_off_hours' => isset($validated['receive_off_hours']) ? 1 : 0,
        ]);

        // Assign role based on sales team selection
        $user->assignRole($validated['sales_team']);

        // Assign additional permissions if provided (permissions are sent as IDs)
        if (!empty($validated['permissions'])) {
            $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $validated['permissions'])->pluck('name');
            $user->givePermissionTo($permissions);
        }

        // Handle profile photo if uploaded
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/profile-photos'), $filename);
            $user->update(['profile_photo' => 'assets/profile-photos/' . $filename]);
        }

        // Return JSON for AJAX or redirect for normal form
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User created successfully!',
                'redirect' => route('users')
            ]);
        }

        return redirect()->route('users')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles', 'permissions');
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Check permission - users can edit themselves, or need 'Access To Users' permission
        if (auth()->id() !== $user->id && !auth()->user()->hasPermissionTo('Access To Users')) {
            abort(403, 'You do not have permission to edit this user.');
        }

        $roles = Role::orderBy('name')->get();
        $permissions = \Spatie\Permission\Models\Permission::orderBy('name')->get();
        $user->load('roles', 'permissions');
        
        // Get all users for Assigned Manager (all users)
        $allUsers = User::where('is_active', true)->orderBy('name')->get();
        
        // Get users by role for filtering
        $bdcAgents = User::where('is_active', true)
            ->whereHas('roles', function($query) {
                $query->where('name', 'LIKE', '%BDC%');
            })
            ->orderBy('name')
            ->get();
            
        $serviceAgents = User::where('is_active', true)
            ->whereHas('roles', function($query) {
                $query->where('name', 'LIKE', '%Service%');
            })
            ->orderBy('name')
            ->get();

                    // Finance managers list for Assigned Finance Manager dropdown
        $financeManagers = User::where('is_active', true)
            ->whereHas('roles', function($query) {
                $query->where('name', 'LIKE', '%Finance%');
            })
            ->orderBy('name')
            ->get();
        
        return view('add-user', compact('user', 'roles', 'permissions', 'allUsers', 'bdcAgents', 'serviceAgents', 'financeManagers'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        // Check permission - users can update themselves, or need 'Access To Users' permission
        if (auth()->id() !== $user->id && !auth()->user()->hasPermissionTo('Access To Users')) {
            abort(403, 'You do not have permission to update this user.');
        }

        // Apply configured minimum password length to request validation
        $minPassword = optional(SecuritySetting::first())->min_password_length ?? 8;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:' . (int) $minPassword,
            'work_phone' => 'nullable|string|max:20',
            'cell_phone' => 'nullable|string|max:20',
            'home_phone' => 'nullable|string|max:20',
            'title' => 'nullable|string|max:255',
            'sales_team' => 'required|string',
            'dealership_franchises' => 'nullable|array',
            'email_signature' => 'nullable|string',
            'working_hours' => 'nullable|string', // JSON string
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'assigned_manager' => 'nullable|integer|exists:users,id',
            'assigned_bdc_agent' => 'nullable|integer|exists:users,id',
            'assigned_finance_manager' => 'nullable|integer|exists:users,id',
            'receive_internet_lead' => 'nullable',
            'receive_off_hours' => 'nullable',
            'employee_number' => 'nullable',
        ]);

        // Parse working hours JSON if provided
        $workingHours = null;
        if (!empty($validated['working_hours'])) {
            $decoded = json_decode($validated['working_hours'], true);
            // Only save if valid JSON was decoded
            if (is_array($decoded) && count($decoded) > 0) {
                $workingHours = $decoded;
            }
        }

        // Update user data
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'work_phone' => $validated['work_phone'] ?? null,
            'cell_phone' => $validated['cell_phone'] ?? null,
            'home_phone' => $validated['home_phone'] ?? null,
            'employee_number' => $validated['employee_number'] ?? null,
            'title' => $validated['title'] ?? null,
            'email_signature' => $validated['email_signature'] ?? null,
            'working_hours' => $workingHours,
            'dealership_franchises' => $validated['dealership_franchises'] ?? null,
            'assigned_manager' => $validated['assigned_manager'] ?? null,
            'assigned_bdc_agent' => $validated['assigned_bdc_agent'] ?? null,
            'assigned_finance_manager' => $validated['assigned_finance_manager'] ?? null,
            'receive_internet_lead' => isset($validated['receive_internet_lead']) ? 1 : 0,
            'receive_off_hours' => isset($validated['receive_off_hours']) ? 1 : 0,
        ];

        // Update password if provided
        if (!empty($validated['password'])) {
            $this->validatePasswordAgainstSecuritySettings($validated['password'], $user);
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        // Update role based on sales team selection
        $user->syncRoles([$validated['sales_team']]);

        // Sync permissions - always sync to handle both adding and removing permissions
        if (isset($validated['permissions']) && is_array($validated['permissions'])) {
            $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $validated['permissions'])->pluck('name');
            $user->syncPermissions($permissions);
        } else {
            // If no permissions selected, remove all permissions
            $user->syncPermissions([]);
        }

        // Handle profile photo if uploaded
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                unlink(public_path($user->profile_photo));
            }
            
            $file = $request->file('profile_photo');
            $filename = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/profile-photos'), $filename);
            $user->update(['profile_photo' => 'assets/profile-photos/' . $filename]);
        }

        // Return JSON for AJAX or redirect for normal form
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully!',
                'redirect' => route('users')
            ]);
        }

        return redirect()->route('users')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Validate a raw password against the configured SecuritySetting rules.
     * Throws ValidationException on failure.
     */
    protected function validatePasswordAgainstSecuritySettings(?string $password, User $user = null)
    {
        if (empty($password)) {
            return; // nothing to validate
        }

        $settings = SecuritySetting::first();
        if (! $settings) {
            return; // no settings configured
        }

        $errors = [];

        $min = (int) ($settings->min_password_length ?? 8);
        if (mb_strlen($password) < $min) {
            $errors[] = "Password must be at least {$min} characters.";
        }

        if ($settings->require_uppercase) {
            if (! preg_match('/[A-Z]/', $password)) {
                $errors[] = 'Password must contain at least one uppercase letter.';
            }
        }

        if ($settings->require_numbers) {
            if (! preg_match('/\\d/', $password)) {
                $errors[] = 'Password must contain at least one number.';
            }
        }

        if ($settings->require_special) {
            if (! preg_match('/[^A-Za-z0-9]/', $password)) {
                $errors[] = 'Password must contain at least one special character.';
            }
        }

        // Password history enforcement is not implemented (no history table).
        // If configured > 0, we conservatively skip enforcement but log a warning.

        if (! empty($errors)) {
            throw ValidationException::withMessages(['password' => $errors]);
        }
    }

    /**
     * Toggle user active status.
     */
    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activated' : 'deactivated';
        
        return response()->json([
            'success' => true,
            'message' => "User {$status} successfully!",
            'is_active' => $user->is_active
        ]);
    }

    /**
     * Delete the specified user.
     */
    public function destroy(User $user)
    {
        try {
            $userName = $user->name;
            
            // Delete the user (this will also remove related data if cascade is set up)
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => "User '{$userName}' has been deleted successfully!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reactivate a deactivated user.
     */
    public function reactivate(User $user)
    {
        $user->update(['is_active' => true]);

        return redirect()->route('users')
            ->with('success', 'User reactivated successfully!');
    }

    /**
     * Send password reset email to user.
     */
    public function sendPasswordReset(User $user)
    {
        // Use Laravel's built-in password reset
        $user->sendPasswordResetNotification(
            app('auth.password.broker')->createToken($user)
        );

        return response()->json([
            'success' => true,
            'message' => 'Password reset email sent to ' . $user->email
        ]);
    }

    /**
     * Export users to Excel.
     */
    public function exportExcel()
    {
        $export = new UsersExport();
        return (new FastExcel($export->collection()))
            ->download('users_' . date('Y-m-d_His') . '.xlsx');
    }

    /**
     * Export users to PDF.
     */
    public function exportPdf()
    {
        $users = User::with('roles')->get();
        
        // Configure Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        
        // Generate HTML
        $html = view('exports.users-pdf-download', compact('users'))->render();
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // Set paper size
        $dompdf->setPaper('A4', 'landscape');
        
        // Render PDF
        $dompdf->render();
        
        // Download PDF
        return $dompdf->stream('users_' . date('Y-m-d_His') . '.pdf');
    }

    /**
     * Bulk delete users.
     */
    public function bulkDelete(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_ids' => 'required|array|min:1',
                'user_ids.*' => 'integer|exists:users,id'
            ]);

            $userIds = $validated['user_ids'];
            $count = count($userIds);

            // Prevent deleting currently authenticated user
            $currentUserId = auth()->id();
            if (in_array($currentUserId, $userIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account!'
                ], 400);
            }

            // Delete users
            User::whereIn('id', $userIds)->delete();

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$count} user(s)!"
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid user selection.'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete users: ' . $e->getMessage()
            ], 500);
        }
    }
}
