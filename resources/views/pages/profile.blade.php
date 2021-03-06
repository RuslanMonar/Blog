@extends('layout')
@section('content')
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <div class="leave-comment mr0">
                    <!--leave comment-->
                    <h3 class="text-uppercase">Мій профіль</h3>
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @include('admin.errors')
                    <br>
                    <img src="{{$user->getImage() }}" alt="" class="profile-image">
                    <form class="form-horizontal contact-form" role="form" method="post" action="/profile" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Ім'я"
                                    required value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                                    required value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="password" name="password"
                                    placeholder="Пароль">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="file" class="form-control" id="image" name="avatar">
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn send-btn">Оновити</button>

                    </form>
                </div>
                <!--end leave comment-->
            </div>
            @include('pages._sidebar')
        </div>
    </div>
</div>
<!-- end main content-->
@endsection