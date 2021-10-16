<div class="comments">
	@auth
		<div class="comments__list">
			<div class="comments__info-deletion">
				<span>Comment list</span>
				<span>Comment was successfully deleted</span>
			</div>
			<ul id="comments-deletion-list">
				@include('admin.comments.comment_list', ['comments' => $comments, 'id' => $id])
			</ul>
			<p id="noComments" style="text-align:center;">
				<b style="background:#f6f6f6;border-radius:5px;padding:4px 20px;">There are no comments for this post</b>
			</p>
		</div>
	@endauth
</div>

@push('scripts_bottom')
<script>
$(document).ready(function(){
	
	function getCommentItems(){
		
		$('.comments-deletion-list__item').on('click',function(event){
			//
				if(event.target.tagName === "INPUT"){
					//Save node of the clicked input parent node (label element)
					let otherInput = event.target.parentNode;
					let hideOrShow = '';
					//If radio input has the 'data-inp' attribute with 'hide' value
					if(event.target.dataset.inp == 'hide'){
						//Check out the radio input attribute 'checked'
						if(!event.target.getAttribute('checked') && otherInput.parentNode.nodeType === 1){
							//Go to another radio input and delete its attribute 'checked'
							otherInput.parentNode.children[1].children[0].removeAttribute('checked');
							hideOrShow = 'hide';
						}
						event.target.setAttribute('checked', 'checked');
					}
					//If radio input has the 'data-inp' attribute with 'show' value
					if(event.target.dataset.inp == 'show'){
						//Check out the radio input attribute 'checked'
						if(!event.target.getAttribute('checked') && otherInput.parentNode.nodeType === 1){
							//Go to another radio input and delete its attribute 'checked'
							otherInput.parentNode.children[0].children[0].removeAttribute('checked');
							hideOrShow = 'show';
						}
						event.target.setAttribute('checked', 'checked');
					}
					//Show and hide comment text
					let blockWithComments = otherInput.parentNode.parentNode.parentNode.children[1].children[0];
					if(hideOrShow === 'hide'){//Hide full comment
						//Paragraph
						$(blockWithComments.children[0]).show(700);
						//blockWithComments.children[0].style.display = 'block';
						//Text area
						$(blockWithComments.children[1]).hide(700);
						//blockWithComments.children[1].style.display = 'none';
					}else if(hideOrShow === 'show'){//Show full comment
						//Paragraph
						$(blockWithComments.children[0]).hide(700);
						//blockWithComments.children[0].style.display = 'none';
						//Text area
						$(blockWithComments.children[1]).show(700);
						//blockWithComments.children[1].style.display = 'block';
					}
				}
		});
		//The array of comment data from span elements: comment id, user id, post id
		let commentData = [];
		let url, _token, _method = ''; 
		$('.comments-deletion-list__delete-btn button').on('click',function(){
			//Disable deletion button
			$(this).attr('disabled','disabled');
			//Get data from the form. action attribute, CSRF Token and a Request METHOD
			let inputs = $(this).parent().children('form').children('input');
				_token = inputs.first().val();
				_method = inputs.last().val();
				url = $(this).parent().children('form').attr('action');
			//Get comment data from span elements: comment id, user id, post id
			$(this).parent().children('span').each(function(ind){
				commentData.push($(this).text());
			});	
			//console.log("Data ",commentData.join());
			//Make AJAX request to delete a comment
			deleteComment(url, _token, _method, commentData);
			//Reset array of the comment data
			commentData = [];
		});
		//Process the pagination block
		processLinks();
	}
	//Set click events on comment items when page has been loaded
	getCommentItems();
	
	//AJAX delete a comment
	function deleteComment(url, _token, _method, commentData){
		//Ajax to add new comment and get new view pagination
		$.ajax({
			async: true,
			url: url,
			method:"POST",
			data: JSON.stringify({
				_token:_token,
				_method: _method,
				comment_id: commentData[0],
				user_id: commentData[1],
				post_id: commentData[2]
			}),
			contentType:"application/json; charset=utf-8",
			success:function(data){
				$('.comments__info-deletion').children('span').last().css({ 'visibility': 'visible' });
				window.setTimeout(()=>{
					//Insert new comments with pagination
					$('#comments-deletion-list').html(data);
					//Set click events on comment items after a comment has been deleted
					getCommentItems();
					$('.comments__info-deletion').children('span').last().css({ 'visibility': 'hidden' });
				},2000);
			},
			error: function (data, textStatus, errorThrown) {
				console.log("Error ",data);
			}
		});
	}
	
	//Add 'click' event to all '.page-link' class and 'preventDefault'
	function processLinks(){
		//Hide list of comments if they are absent
		if($('#comments-deletion-list li').length > 0){
			$('#noComments').hide();
			$('.comments__info-deletion').show();
			$('#comments-deletion-list').show();
		}else{
			$('#noComments').show();
			$('.comments__info-deletion').hide();
			$('#comments-deletion-list').hide();
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
			url:"{{ route('posts.edit',['post'=>$id]) }}"+"?page="+page, //+"?page="+page
			method:"GET",
			contentType:"application/json; charset=utf-8",
			success:function(data){
				//Insert new comments with pagination
				$('#comments-deletion-list').html(data);
				//Add 'click' event to all '.page-link' class and 'preventDefault'
				processLinks();
				//Set click events on comment items after switched between pages
				getCommentItems();
			},
			error: function (data, textStatus, errorThrown) {
				console.log(data);
			}
		});
	}
	
});
</script>
@endpush