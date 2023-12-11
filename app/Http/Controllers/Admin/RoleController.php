<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\CreateRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = Role::latest('id')->paginate(5); // chuyển dữ liệu vào biến $roles và phân trang bằng paginate() "5" item 1 trang

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permissions = Permission::all()->groupBy('group');
        return view('admin.roles.create', compact('permissions'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
    {
        //
        $dataCreate = request()->all();
        $dataCreate['guard_name'] = 'web';
        $role = Role::create($dataCreate); // tạo 1 bản ghi mới từ biến $dataCreate và lưu vào bảng roles
        $role->permissions()->attach($dataCreate['permission_ids']);
        return to_route('roles.index')->with(['message' => 'Create success']); // chuyển hướng trang về trang roles.index và gửi kèm thông báo thành công

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $role = Role::With('permissions')->findOrFail($id) ;// tìm kiếm bản ghi trong database dựa vào id
        $permissions = Permission::all()->groupBy('group');
        // dd($permissions);
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = Role::with('permissions')->findOrFail($id) ;// tìm kiếm bản ghi trong database dựa vào id
        $dataUpdate = $request->all();
        $role->update($dataUpdate);
        $role->permissions()->sync($dataUpdate['permission_ids']);
        return to_route('roles.index')->with(['message' => 'Update success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
        return to_route('roles.index')->with(['message' => 'Delete success']);
    }
}

