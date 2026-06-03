<?php

namespace App\Http\Controllers\Admin;

use App\Shop\Admins\Requests\CreateEmployeeRequest;
use App\Shop\Admins\Requests\UpdateEmployeeRequest;
use App\Shop\Employees\Requests\UpdateProfileRequest;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Shop\Roles\Repositories\RoleRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Validation\Rule;
use App\Admin;

class EmployeeController extends Controller
{
    /**
     * @var EmployeeRepositoryInterface
     */
    private $employeeRepo;
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepo;

    /**
     * EmployeeController constructor.
     *
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->employeeRepo = $employeeRepository;
        $this->roleRepo = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->employeeRepo->listEmployees('created_at', 'desc');

        return view('admin.staffs.list', [
            'employees' => $this->employeeRepo->paginateArrayResults($list->all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roleRepo->listRoles();

        return view('admin.staffs.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateEmployeeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRequest $request)
    {
        if ($request->has('avatar') && $request->file('avatar') != '') {
            $file = $request->file('avatar');
            request()->validate([
                'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:548',
            ]);
            $id = Admin::max('id') + 1;
            //$destinationPath = 'storage/profile/users/'.$id;
            $file->move(public_path('storage/profile/users/'), $file->getClientOriginalName());
        }

        $employee = $this->employeeRepo->createEmployee($request->all());

        if ($request->has('role')) {
            $employeeRepo = new EmployeeRepository($employee);
            $employeeRepo->syncRoles([$request->input('role')]);
        }

        return redirect()->route('admin.staffs.index')->with('message', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        return view('admin.staffs.show', ['admin' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        $roles = $this->roleRepo->listRoles('created_at', 'desc');
        $isCurrentUser = $this->employeeRepo->isAuthUser($employee);

        return view(
            'admin.staffs.edit',
            [
                'admin' => $employee,
                'roles' => $roles,
                'isCurrentUser' => $isCurrentUser,
                'selectedIds' => $employee->roles()->pluck('role_id')->all()
            ]
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEmployeeRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $this->validate($request, [
            'phone' => ['numeric', 'nullable', Rule::unique('employees')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('employees')->ignore($id)]
        ]);

        $employee = $this->employeeRepo->findEmployeeById($id);
        $isCurrentUser = $this->employeeRepo->isAuthUser($employee);

        if ($request->has('password') && $request->input('password') != '' && $request->input('password') != $request->input('confirm-password')) {

            return redirect()->route('admin.staffs.edit', $id)
                ->with('error', 'Password and confirmed password do not match');
        }

        $empRepo = new EmployeeRepository($employee);
        $empRepo->updateEmployee($request->except('_token', '_method', 'password'));

        if ($request->has('password') && !empty($request->input('password'))) {
            $employee->password = Hash::make($request->input('password'));
            $employee->save();
        }

        if ($request->has('roles') and !$isCurrentUser) {
            $employee->roles()->sync($request->input('roles'));
        } elseif (!$isCurrentUser) {
            $employee->roles()->detach();
        }
        if ($request->has('avatar') && $request->file('avatar') != '') {
            $file = $request->file('avatar');
            request()->validate([
                'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:548',
            ]);

            // $destinationPath = 'storage/profile/users/'.$id;
            $file->move(public_path('storage/profile/users/'), $file->getClientOriginalName());
        }

        return redirect()->route('admin.staffs.edit', $id)
            ->with('message', 'Update successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        $employeeRepo = new EmployeeRepository($employee);
        $employeeRepo->deleteEmployee();
        DB::table("employees")->where("id", $id)->delete();
        DB::table("role_user")->where([['user_id', $id],  ['role_id', 2]])->delete();

        return redirect()->route('admin.staffs.index')->with('message', 'Delete successful');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProfile()
    {
        $employee = $this->employeeRepo->findEmployeeById(auth('admin')->user()->id);
        if ($employee->type == 2) {

            return view('admin.subadmin.profile', ['admin' => $employee]);
        } else {

            return view('admin.staffs.profile', ['admin' => $employee]);
        }
    }

    /**
     * @param UpdateProfileRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $id = auth('admin')->user()->id;
        $employee = $this->employeeRepo->findEmployeeById($id);

        if ($request->has('password') && $request->input('password') != '' && !password_verify($request->input('old-password'), $employee->password)) {
            return redirect()->route('admin.staffs.profile')
                ->with('error', 'Invalid Old Password');
        }

        if ($request->has('password') && $request->input('password') != '' && $request->input('password') != $request->input('confirm-password')) {

            return redirect()->route('admin.staffs.profile')
                ->with('error', 'Password and confirmed password do not match');
        }

        if ($request->has('avatar') && $request->file('avatar') != '') {
            $file = $request->file('avatar');
            request()->validate([
                'avatar' => 'required|mimes:jpg,jpeg,png,gif,svg',
            ]);

            //$destinationPath = 'storage/profile/users/'.$id;
            $file->move(public_path('storage/profile/users/'), $file->getClientOriginalName());
        }

        $update = new EmployeeRepository($employee);
        $update->updateEmployee($request->except('_token', '_method', 'password'));

        if ($request->has('password') && $request->input('password') != '') {
            $update->updateEmployee($request->only('password'));
        }

        return redirect()->route('admin.staffs.profile')
            ->with('message', 'Update successful');
    }

    /**
     * @param UpdateProfileRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function staffUpdateProfile(UpdateProfileRequest $request)
    {
        $id = auth('admin')->user()->id;
        $employee = $this->employeeRepo->findEmployeeById($id);

        if ($request->has('password') && $request->input('password') != '' && !password_verify($request->input('old-password'), $employee->password)) {
            return redirect()->back()
                ->with('error', 'Invalid Old Password');
        }

        if ($request->has('password') && $request->input('password') != '' && $request->input('password') != $request->input('confirm-password')) {

            return redirect()->back()
                ->with('error', 'Password and confirmed password do not match');
        }

        if ($request->has('avatar') && $request->file('avatar') != '') {
            $file = $request->file('avatar');
            request()->validate([
                'avatar' => 'required|mimes:jpg,jpeg,png,gif,svg',
            ]);

            //$destinationPath = 'storage/profile/users/'.$id;
            $file->move(public_path('storage/profile/users/'), $file->getClientOriginalName());
        }

        $update = new EmployeeRepository($employee);
        $update->updateEmployee($request->except('_token', '_method', 'password'));

        if ($request->has('password') && $request->input('password') != '') {
            $update->updateEmployee($request->only('password'));
        }

        return redirect()->back()
            ->with('message', 'Update successful');
    }

    public function employeeApprove($id)
    {

        $employee = $this->employeeRepo->findEmployeeById($id);
        if ($employee) {
            $employee->status = 1;
            $employee->save();
            return redirect()->back()->with('message', 'Approved successfully');
        }
    }

    public function employeeUnapprove($id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        if ($employee) {
            $employee->status = 0;
            $employee->save();
            return redirect()->back()->with('error', 'Unapproved successfully');
        }
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function staff_profile()
    {
        $employee = $this->employeeRepo->findEmployeeById(auth('admin')->user()->id);

        return view('admin.staffs.profile', ['admin' => $employee]);
    }

    public function subadmin_index()
    {
        $list = Admin::where('merchant_id', NULL)->where('id', '!=', 1)->orderBy('id', 'desc')->get();

        return view('admin.subadmin.list', [
            'employees' => $list
        ]);
    }

    public function subadmin_create()
    {
        $roles = $this->roleRepo->listRoles();

        return view('admin.subadmin.create', compact('roles'));
    }

    public function subadmin_store(CreateEmployeeRequest $request)
    {
        $this->validate($request, [
            'phone' => ['numeric', 'nullable', Rule::unique('employees')],
            'email' => ['required', 'email', Rule::unique('employees')]

        ]);

        if ($request->has('avatar') && $request->file('avatar') != '') {
            $file = $request->file('avatar');
            request()->validate([
                'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:548',
            ]);
            // $id = Admin::max('id')+1;
            // $destinationPath = 'storage/profile/users/'.$id;
            // $file->move($destinationPath,$file->getClientOriginalName());
            $file->move(public_path('storage/profile/users/'), $file->getClientOriginalName());
        }

        $employee = $this->employeeRepo->createEmployee($request->all());
        $lid = $employee->id;
        $update_user = Admin::where('id', $lid)->update(['type' => 2]);
        // if ($request->has('role')) {
        //     $employeeRepo = new EmployeeRepository($employee);
        //     $employeeRepo->syncRoles([$request->input('role')]);
        // }

        return redirect()->back()->with('message', 'Created successfully');
    }


    public function subadmin_show(int $id)
    {

        $employee = $this->employeeRepo->findEmployeeById($id);
        return view('admin.subadmin.show', ['admin' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function subadmin_edit(int $id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        $roles = $this->roleRepo->listRoles('created_at', 'desc');
        //$isCurrentUser = $this->employeeRepo->isAuthUser($employee);

        return view(
            'admin.subadmin.edit',
            [
                'admin' => $employee,
                'roles' => $roles,
                'selectedIds' => $employee->roles()->pluck('role_id')->all()
            ]
        );
    }

    public function subadmin_update(UpdateEmployeeRequest $request, $id)
    {
        $this->validate($request, [
            'phone' => ['numeric', 'nullable', Rule::unique('employees')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('employees')->ignore($id)]
        ]);

        $employee = $this->employeeRepo->findEmployeeById($id);
        //$isCurrentUser = $this->employeeRepo->isAuthUser($employee);

        if ($request->has('password') && $request->input('password') != '' && $request->input('password') != $request->input('confirm-password')) {

            return redirect()->route('subadmin.edit', $id)
                ->with('error', 'Password and confirmed password do not match');
        }

        $empRepo = new EmployeeRepository($employee);
        $empRepo->updateEmployee($request->except('_token', '_method', 'password'));

        if ($request->has('password') && !empty($request->input('password'))) {
            $employee->password = Hash::make($request->input('password'));
            $employee->save();
        }

        // if ($request->has('roles') and !$isCurrentUser) {
        //     $employee->roles()->sync($request->input('roles'));
        // } elseif (!$isCurrentUser) {
        //     $employee->roles()->detach();
        // }
        if ($request->has('avatar') && $request->file('avatar') != '') {
            $file = $request->file('avatar');
            request()->validate([
                'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:548',
            ]);

            // $destinationPath = 'storage/profile/users/'.$id;
            // $file->move($destinationPath,$file->getClientOriginalName());
            $file->move(public_path('storage/profile/users/'), $file->getClientOriginalName());
        }

        return redirect()->back()->with('message', 'Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function subadmin_destroy(int $id)
    {

        $employee = $this->employeeRepo->findEmployeeById($id);
        $employeeRepo = new EmployeeRepository($employee);
        $employeeRepo->deleteEmployee();
        DB::table("employees")->where("id", $id)->delete();

        return redirect()->back()->with('message', 'Delete successfully');
    }
}
