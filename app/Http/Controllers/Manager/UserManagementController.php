<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Area;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    /**
     * Tampilkan daftar user
     */
    public function index(Request $request)
    {
        $query = User::with(['roles', 'area', 'shift']);

        // Filter berdasarkan role
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        // Filter berdasarkan departemen
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->where('is_active', true);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_number', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        $roles = Role::all();
        $departments = User::select('department')->distinct()->pluck('department');

        return view('manager.users.index', compact('users', 'roles', 'departments'));
    }

    /**
     * Form tambah user
     */
    public function create()
    {
        $currentUser = auth()->user();
        
        // Manager bisa create: Admin, Pengawas, Karyawan
        // Admin bisa create: Pengawas, Karyawan
        $availableRoles = Role::whereIn('name', 
            $currentUser->hasRole('Manager') 
                ? ['Admin', 'Pengawas', 'Karyawan']
                : ['Pengawas', 'Karyawan']
        )->get();

        $areas = Area::where('is_active', true)->get();
        $shifts = Shift::all();
        $departments = User::select('department')->distinct()->pluck('department');

        return view('manager.users.create', compact('availableRoles', 'areas', 'shifts', 'departments'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $currentUser = auth()->user();

        // Validasi role yang boleh dibuat
        $allowedRoles = $currentUser->hasRole('Manager') 
            ? ['Admin', 'Pengawas', 'Karyawan']
            : ['Pengawas', 'Karyawan'];

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'employee_number' => 'required|string|unique:users,employee_number',
            'role' => 'required|in:' . implode(',', $allowedRoles),
            'employee_type' => 'required|in:AREA_BASED,NON_AREA',
            'area_id' => 'required_if:employee_type,AREA_BASED|nullable|exists:areas,id',
            'shift_id' => 'nullable|exists:shifts,id',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Buat user baru (password akan diset oleh user via email)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt(Str::random(32)), // Password temporary (akan diganti via email)
                'employee_number' => $request->employee_number,
                'employee_type' => $request->employee_type,
                'area_id' => $request->employee_type == 'AREA_BASED' ? $request->area_id : null,
                'shift_id' => $request->shift_id,
                'department' => $request->department,
                'position' => $request->position,
                'is_active' => true,
                'email_verified_at' => null, // Belum terverifikasi
            ]);

            // Assign role
            $user->assignRole($request->role);

            // Kirim email verifikasi & set password
            event(new Registered($user));

            DB::commit();

            return redirect()->route('manager.users.index')
                ->with('success', 'User berhasil ditambahkan! Email verifikasi telah dikirim ke ' . $user->email);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Form edit user
     */
    public function edit(User $user)
    {
        $areas = Area::where('is_active', true)->get();
        $shifts = Shift::all();
        $departments = User::select('department')->distinct()->pluck('department');

        return view('manager.users.edit', compact('user', 'areas', 'shifts', 'departments'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'employee_number' => 'required|string|unique:users,employee_number,' . $user->id,
            'employee_type' => 'required|in:AREA_BASED,NON_AREA',
            'area_id' => 'required_if:employee_type,AREA_BASED|nullable|exists:areas,id',
            'shift_id' => 'nullable|exists:shifts,id',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'employee_number' => $request->employee_number,
                'employee_type' => $request->employee_type,
                'area_id' => $request->employee_type == 'AREA_BASED' ? $request->area_id : null,
                'shift_id' => $request->shift_id,
                'department' => $request->department,
                'position' => $request->position,
                'is_active' => $request->is_active,
            ]);

            DB::commit();

            return redirect()->route('manager.users.index')
                ->with('success', 'User berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Soft delete user
     */
    public function destroy(User $user)
    {
        try {
            // Soft delete
            $user->delete();

            return redirect()->route('manager.users.index')
                ->with('success', 'User berhasil dihapus!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Restore soft deleted user
     */
    public function restore($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore();

            return redirect()->route('manager.users.index')
                ->with('success', 'User berhasil direstore!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}