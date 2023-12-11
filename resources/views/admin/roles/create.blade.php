@extends('admin.layouts.app')
@section('title', 'Create Roles')
@section('content')

    <div class="card">
        <h1>Create</h1>
    </div>


    <div>
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <div class="input-group input-group-static mb-4">
                <label>Name</label>
                <input name="name" value="{{ old('name') }}" type="text" class="form-control">
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label>Display name</label>
                <input name="display_name" value="{{ old('display_name')}}" type="text" class="form-control">
                @error('display_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group input-group-static mb-4">
                <label for="exampleFormControlSelect1" name="group" class="ms-0">Group</label>
                <select name="group" class="form-control" >
                  <option value="system">System</option>
                  <option value="user">User</option>

                </select>
                @error('group')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>


            <div class="form-group">
                <label for="">Permission</label>
                <div class="row">
                    @foreach ($permissions as $groupName => $permissions)
                    <div class="col-5">
                        <h4>{{ $groupName }}</h4>
                        <div>
                            @foreach ($permissions as $item)
                                <div class="form-check">
                                    <input class="form-check-input" name="permission_ids[]" type="checkbox"
                                        value="{{ $item->id }}">
                                    <label class="custom-control-label"
                                        for="customCheck1">{{ $item->display_name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                </div>





            </div>

            <button type="submit" class="btn btn-submit btn-primary">Submit</button>

        </form>
    </div>

@endsection
