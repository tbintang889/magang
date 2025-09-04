<?php
  /**
     * @param UserUpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @noinspection PhpUndefinedMethodInspection
     */
namespace App\Http\Controllers;
use App\Exports\UsersExport;
use App\Helpers\UserQueryBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = UserQueryBuilder::build($request)->paginate(10);
        $title = 'User Management';
        $roles = Role::all(); 
        return view('admin.users.index', compact('users', 'title', 'roles'));
    }

    public function create()
    {
        $title = 'User Management';
        $roles = Role::all();
        return view('admin.users.create', compact('title', 'roles'));
    }

        /**
         * @param UserStoreRequest $request
         * @return \Illuminate\Http\RedirectResponse
         * @noinspection PhpUndefinedMethodInspection
         */
        public function store(UserStoreRequest $request)
        {   
            // dd($request->validated()['role_id']);
            $user = User::create($request->validated());
            $user->assignRole($request->input('role_id'));

            return redirect()->route('users.index')->with('success', 'User created.');
        }

    public function edit(User $user)
    {
        $title = 'User Management';
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'title', 'roles'));
    }

  
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();

    // Jika password kosong, jangan update
    if (empty($data['password'])) {
        unset($data['password']);
    } else {
        $data['password'] = Hash::make($data['password']);
    }

    $user->update($data);

    // Update role jika pakai Spatie
    $user->syncRoles([$request->input('role_id')]);

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    public function export(Request $request)
    {
        return Excel::download(new UsersExport($request), 'users.xlsx');
    }
}
