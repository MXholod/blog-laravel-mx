@foreach($comments as $comment)
	<li class="comments-deletion-list__item">
		<span>Author: {{$comment->user->name}}</span>
		<span>Date: {{$comment->setCommenttDate()}}</span>
		<div>
			<div>
				<div class="comments-deletion-list__radio">
					<label>
						<input type="radio" data-inp="hide" checked="checked" name='com["{{$comment->id}}"]' />
						Hide full text
					</label>
					<label>
						<input type="radio" data-inp="show" name='com["{{$comment->id}}"]' />
						Show full text
					</label>
				</div>
			</div>
			<div class="comments-deletion-list__text-and-btn">
				<div>	
					<p class="comments-deletion-list__text-preview">
						<span>Comment text: </span>
						{{ $comment->initialPartOfComment() }}
					</p>
					<div class="comments-deletion-list__full-text">
						{{ $comment->comment }}
					</div>
				</div>
				<div class="comments-deletion-list__delete-btn">
					<form method="POST" action="{{ route('admin.post_comment.delete', [
						'id' => $id, 'commentId' => $comment->id ]) }}">
						@csrf
						@method('DELETE')
					</form>
					<span style="display:none;">{{ $comment->id }}</span>
					<span style="display:none;">{{ $comment->user_id }}</span>
					<span style="display:none;">{{ $comment->post_id }}</span><!-- or $slug -->
					<button type="button" class="btn btn-danger btn-sm">Remove comment</button>
				</div>
			</div>
		</div>
	</li> 
@endforeach
  
{!! $comments->links() !!}