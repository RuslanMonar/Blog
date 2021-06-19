@extends('layout')
@section('content')
    <!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @foreach ($posts as $post)
                <article class="post">
                    <div class="post-thumb">
                        <a href="{{route('post.show' , $post->slug)}}"><img src="{{$post->getImage()}}" alt=""></a>

                        <a href="{{route('post.show' , $post->slug)}}" class="post-thumb-overlay text-center">
                            <div class="text-uppercase text-center">Переглянути </div>
                        </a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            @if($post->hasCategory())
                            <h6><a href="{{route('category.show' , $post->category->slug)}}"> {{$post->getCategoryTitle()}}</a></h6>
                            @endif
                            <h1 class="entry-title"><a href="{{route('post.show' , $post->slug)}}">{{$post->title}}</a></h1>


                        </header>
                        <div class="entry-content">
                           
                                {!!$post->description!!}
                            

                            <div class="btn-continue-reading text-center text-uppercase">
                                <a href="{{route('post.show' , $post->slug)}}" class="more-link">Продовжити читати</a>
                            </div>
                        </div>
                        <div class="social-share">
                        <span class="social-share-title pull-left text-capitalize">Автор: <a href="#">{{$post->author->name}} , </a> Опубліковано : {{$post->getDate()}}</span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="s-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="s-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a class="s-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="s-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </article>
                @endforeach
                
                {{$posts->links()}}
            </div>
            @include('pages._sidebar')
        </div>
    </div>
</div>

<style type="text/css">
    .glyphicon { margin-right:5px; }
.thumbnail
{
    margin-bottom: 20px;
    padding: 0px;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}

.item.list-group-item
{
    float: none;
    width: 100%;
    background-color: #fff;
    margin-bottom: 10px;
}
.item.list-group-item:nth-of-type(odd):hover,.item.list-group-item:hover
{
    background: #428bca;
}

.item.list-group-item .list-group-image
{
    margin-right: 10px;
}
.item.list-group-item .thumbnail
{
    margin-bottom: 0px;
}
.item.list-group-item .caption
{
    padding: 9px 9px 0px 9px;
}
.item.list-group-item:nth-of-type(odd)
{
    background: #eeeeee;
}

.item.list-group-item:before, .item.list-group-item:after
{
    display: table;
    content: " ";
}

.item.list-group-item img
{
    float: left;
}
.item.list-group-item:after
{
    clear: both;
}
.list-group-item-text
{
    margin: 0 0 11px;
}

</style>
<!-- end main content-->
@endsection