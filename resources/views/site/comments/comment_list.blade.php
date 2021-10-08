@foreach($comments as $comment)
	<li>
		<div>
			<span>Author: {{$comment->user->name}}</span>
			<span>Date: {{$comment->setCommenttDate()}}</span>
		</div>
		<div>{{ $comment->comment }}</div>
	</li> 
@endforeach
  
{!! $comments->links() !!}