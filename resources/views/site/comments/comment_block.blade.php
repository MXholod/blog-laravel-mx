<div class="comments">
	@auth
	<div class="comments__form">	
		<form action="{{ route('comment.add', ['slug' => $slug]) }}" method="POST">
			@csrf
			<label for="comment" class="form-label" style="width:100%;">Leave a comment
				<textarea name="comment" class="form-control" id="comment" rows="3"></textarea>
			</label>
			<input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
			<input type="hidden" name="post_id" value="{{ $post_id }}" />
			
			<button type="submit" id="submit" class="btn btn-primary btn-sm">Add comment</button>
		</form>
		<div class="commentAbsent" role="alert">
			Comment text is absent
		</div>
		<div class="commentAdded">
			Comment has been added to this post
		</div>
	</div>
	@endauth
	<div class="comments__list">
		<h1>Comment list</h1>
		<ul id="comment_list">
			@if($totalComments > 0)
				@include('site.comments.comment_list', ['comments' => $comments])
			@endif
		</ul>
		@if($totalComments == 0)
			<p id="noComments" style="text-align:center;">
				<b style="background:#f6f6f6;border-radius:5px;padding:4px 20px;">There are no comments for this post</b>
			</p>
		@endif
	</div>
</div>

@push('scripts_bottom')
<script>
	const commentList = document.getElementById("comment_list");
	const pagination = commentList.getElementsByClassName('pagination');
	
	//Add 'click' event to all '.page-link' class and 'preventDefault'
	function processLinks(){
		//Hide list of comments if they are absent
		if($('#comment_list li').length > 0){
			$('#noComments').hide();
		}
		//
		$('.pagination .page-link').on('click', function(e){
			e.preventDefault();
			let currentPageNumber;
			if($(this).attr('href')){
				currentPageNumber = $(this).attr('href').split('page=')[1];
				getCommentsByPage(currentPageNumber);
			}
		});
	}
	//Get all comment with pagination when click on pagination buttons
	function getCommentsByPage(page){
		//Ajax to add new comment and get new view pagination
		$.ajax({
			async: true,
			url:"{{ route('posts.single',['slug'=>$slug]) }}"+"?page="+page, //+"?page="+page
			method:"GET",
			contentType:"application/json; charset=utf-8",
			success:function(data){
				//Insert new comments with pagination
				$('#comment_list').html(data);
				//Add 'click' event to all '.page-link' class and 'preventDefault'
				processLinks();
			},
			error: function (data, textStatus, errorThrown) {
				console.log(data);
			}
		});
	}
	
	$('document').ready(function(){
		//Add 'click' event to all '.page-link' class and 'preventDefault'
		processLinks();
		//Hide error absent comment
		$('.commentAbsent').hide();
		$('.commentAdded').hide();
		
		//Create a new comment using the POST AJAX method
		$('#submit').on('click', function(e){
			e.preventDefault();
			//Blocking the 'submit' button
			$('#submit').attr('disabled', 'disabled');
			//Collect all the data from the comment form 
			const _token = $("input[name=_token]").val();
			const user_id = $("input[name=user_id]").val();
			const post_id = $("input[name=post_id]").val();
			const comment = $("#comment").val();
			if(!comment.length){
				//Show error absent comment
				$('.commentAbsent').show();
				return;
			}else{
				//Hide error absent comment
				$('.commentAbsent').hide();
			}
			//Ajax to add new comment and get new view pagination
			$.ajax({
				async: true,
				url:"{{ route('comment.add', ['slug' => $slug]) }}",
				method:"POST",
				data: JSON.stringify({
					_token:_token,
					comment,
					user_id: Number(user_id),
					post_id: Number(post_id)
				}),
				contentType:"application/json; charset=utf-8",
				success:function(data){
					if(data.commentAbsent){
						$('.commentAbsent').show();
					}else{
						//If comment exists
						$('.commentAbsent').hide();
						//Insert new comments with pagination
						$('#comment_list').html(data);
						//Add 'click' event to all '.page-link' class and 'preventDefault'
						processLinks();
						$('.commentAdded').show();
						window.setTimeout(()=>{
							$('.commentAdded').hide();
							$('#submit').removeAttr('disabled');
						},3000);
					}
					//Reset 'textarea' field
					$("#comment").val('');
				},
				error: function (data, textStatus, errorThrown) {
					console.log(data);
				}
			});
		});
	});
</script>
@endpush