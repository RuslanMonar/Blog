
@foreach ($comments as $comment)
<h1>
</h1>
<div class="doter-comment-text">
    <a onclick=" $( '#{{$comment->id}}' ).toggle( 'fast');" class="{{$comment->id}} btn pull-right"> Відповісти</a>
<div class="comment-img">
    <img class="img-circle comment-avatar" src="{{$comment->author->getImage()}}">
</div>
    <h5>{{$comment->author->name}}</h5>
    <p class="comment-date">
        {{$comment->created_at->diffForHumans()}}
    </p>
<p class="para"><a href="">{{$parent_comment->author->name}} , </a> {{$comment->text}}</p>
</div>
<div class="replay-comment-margin">
    {!! Form::open(['route' => 'comment.reply' ,'method' => 'post' , 'class' => 'daughter-replay-comment' , 'id' => $comment->id]) !!}
    {{ csrf_field() }}
<input type="hidden" name="parent_id" value="{{$comment->id}}">
<input type="hidden" name="post_id" value="{{$post->id}}">
    <div class="form-group">
        <div class="col-md-12">
                    <textarea class="form-control" rows="6" name="message"
                              placeholder="Write Massage"></textarea>
                              <button class="btn send-btn ">Answer</button>
        </div>
    </div>
{!! Form::close() !!}
@include('pages._replies' , ['comments' => $comment->getReplays(), 'parent_comment' => $comment])
</div>
@endforeach

