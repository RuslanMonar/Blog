@extends('layout')
@section('content')
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <div class="leave-comment mr0"><!--leave comment-->
                    @if (session('status'))
                    <div class="alert alert-danger">
                        {{session('status')}}
                    </div>
                    @endif
                    <h3 class="text-uppercase">Вхід</h3>
                    @include('admin.errors')
                    <br>
                    <form class="form-horizontal contact-form" role="form" method="post" action="/login">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="name" name="name"
                            value="{{old('name')}}"       placeholder="І'мя">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Пароль">
                            </div>
                        </div>
                        <button type="submit"  class="btn send-btn">Ввійти</button>

                    </form>
                </div><!--end leave comment-->
            </div>
            @include('pages._sidebar')
        </div>
    </div>
</div>
<!-- end main content-->
@endsection