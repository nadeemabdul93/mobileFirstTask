@extends('layouts.app')

@section('content')

    <div class="wrapper">
      <!-- Sidebar -->
      @extends('layouts.sidebar')
      <!-- End Sidebar -->

      <div class="main-panel">        
      @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
        <div class="container">   
          <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center mb-0">
              <thead class="thead-light">
                <tr>
                  <th>Sno.</th>
                  <th>User Name</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
              </thead>
              @if(count($users)>0)
              <?php $n=1;?>
              @foreach($users as $user)
              <tbody>
                
                <tr>
                  <td> {{$n++ }}
                  </td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>
                    <button class="btn btn-primary"><a href="{{url('admin/editUser/'.$user->id)}}" style="color:white"> {{ __('Edit') }}</a></button>
                    <button class="btn btn-danger"><a href="{{url('admin/deleteUser/'.$user->id)}}" style="color:white"> {{ __('Delete') }}</a></button>
                  </td>
                </tr>
                
              </tbody>
              @endforeach
              @else
              <tbody>
                <tr>
                  <td colspan="4"></td>
                </tr>
              </tbody>
              @endif
            </table>
          </div>
          </div>
        </div>       
      </div>

    </div>

@endsection
