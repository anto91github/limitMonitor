<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\AuditTrailHelper;
use App\Models\Role as RolesModel;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\ProfileUpdateRequest;

/**
 *
 */
class UsersController extends Controller
{
    /**
     * Display all users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('role')->orderBy('id','ASC')->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show form for creating user
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roleData = RolesModel::all();
        return view('users.create', ['roleData' => $roleData]);
    }

    /**
     * Store a newly created user
     *
     * @param User $user
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, StoreUserRequest $request)
    {
        $status = $request->has('is_active') ? 1 : 0;

        $user->create(array_merge($request->validated(), [
            'password' => Hash::make($request->password),
            'uid' => $request->uid,
            'role_id' => $request->role,
            'status' => $status
        ]));

        AuditTrailHelper::add_log('Insert', [
            'password' => '',
            'uid' => $request->uid,
            'role_id' => $request->role,
            'status' => $status
        ]);

        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully.'));
    }

    /**
     * Show user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Edit user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roleData = RolesModel::all();

        AuditTrailHelper::add_log('View', '/users/'. $user['id'].'/edit');

        return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roleData' => $roleData,
            'roles' => Role::latest()->get()
        ]);
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param ProfileUpdateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, ProfileUpdateRequest $request)
    {
        $data = $request->validated();

        $status = $request->has('is_active') ? 1 : 0;

         // Hanya update password jika diisi
         if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password); // Hash password
        } else {
            // Jika password tidak diisi, hapus key password dari data
            unset($data['password']);
        }

        $dataToUpdate = array_merge($data, [
            'status' => $status,
            'role_id' => $request->role,
        ]);

        AuditTrailHelper::add_log('Edit', $dataToUpdate);

        $user->update($dataToUpdate);

        // $user->syncRoles($request->get('role'));

        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('User deleted successfully.'));
    }
}
