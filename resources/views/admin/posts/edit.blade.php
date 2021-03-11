@extends('admin.layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @if($current_user->is_admin ||  $post->user_id == $current_user->id)
    <section class="content-header">
      <h1>
        Изменить статью
        <small>приятные слова..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      {{Form::open([
        'route' => [$current_user->userStatusRouting('update') , $post->id ] ,
        'files' => true,
        'method' => 'put'
      ])}}
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Обновляем статью</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Название</label>
              <input name="title" type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$post->title}}">
            </div>
            
            <div class="form-group">
            <img src="{{$post->getImage()}}"  alt="" class="img-responsive" width="200">
              <label for="exampleInputFile">Лицевая картинка</label>
              <input type="file" name="image" id="exampleInputFile">

              <p class="help-block">Какое-нибудь уведомление о форматах..</p>
            </div>
            <div class="form-group">
              <label>Категория</label>
              {{Form::select('category_id', $categories, 
               $post->getCategoryId(),
               ['class' => 'form-control select2'])}}
            </div>
            <div class="form-group">
              <label>Теги</label>
              {{Form::select('tags[]', $tags, $selectedTags,
               ['class' => 'form-control select2' , 'multiple' => 'multiple' , 'data-placeholder' => 'Выберите теги'])}}
            </div>
            <!-- Date -->
            <div class="form-group">
              <label>Дата:</label>

              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
              <input type="text" class="form-control pull-right" id="datepicker" value="{{$post->date}}" name="date">
              </div>
              <!-- /.input group -->
            </div>
            @if(Auth::user()->is_admin)
            <!-- checkbox -->
            <div class="form-group">
              <label>
              {{Form::checkbox('is_featured', '1', $post->is_featured , ['class' => 'minimal']) }}
              </label>
              <label>
                Рекомендовать
              </label>
            </div>
            <!-- checkbox -->
            <div class="form-group">
              <label>
                {{Form::checkbox('is_draft', '1', $post->is_draft , ['class' => 'minimal']) }}
              </label>
              <label>
                Черновик
              </label>
            </div>
            @endif
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Описание</label>
            <textarea name="description" id="" cols="30" rows="10" class="form-control">{{$post->description}}</textarea>
          </div>
        </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Полный текст</label>
              <textarea name="content" id="" cols="30" rows="10" class="form-control">
                {{$post->content}}
              </textarea>
          </div>
        </div>
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-default">Назад</button>
          <button class="btn btn-warning pull-right">Изменить</button>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
      {{Form::close()}}
    </section>
    @else
    <h1>Помилка доступу</h1>
    @endif
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection