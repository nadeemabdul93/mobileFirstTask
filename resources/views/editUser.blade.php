@extends('layouts.app')

@section('content')
<div class="wrapper"> 
@extends('layouts.sidebar')   
<div class="main-panel">      
    <div class="container"> 
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit user form</div>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card-body">
                <form action="{{ route('admin.updateUser') }}" method="POST">
                @csrf
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}"
                                />
                                <input type="hidden" class="form-control" id="id" name="id" value="{{$user->id}}"
                                />
                            </div>                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="email2">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}"
                                />
                            </div>                        
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <input type="submit" class="btn btn-success" value="Save" />
                
                </div>
                </form>
            </div>
        </div>
        
    </div>
</div>
    
</div>
@endsection