@extends('layouts.app')
@section('content')
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Options</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><a href="{{route('users.show', $user)}}">{{$user->name}}</a></td>
                        <td>{{$user->email}}</td>
                        <td>{{implode(',',$user->roles()->pluck('name')->toArray())}}</td>
                        <td>
                            <a href="{{route('admin.edit_user', $user->id)}}"><button class="btn btn-outline-primary">Edit</button></a>
                            <form action="{{route('admin.delete', $user->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection