<div class="col-12 logo-block">
	<div class="logo-block__header">Site logo management</div>
	<div class="logo-block__uploading">
		<p class="lead">Add or update site logo. <span>Site logo no more than 1 MB</span></p>
		<form action="{{ route('logo.store') }}" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
			@csrf
			<div class="input-group mb-3">
				<input type="file" class="form-control" id="logoImage" name="logo" />
			</div>
			@if($logo->count())
				<div class="form-check">
				  <input class="form-check-input" type="radio" name="logo_img_display" id="showLogo" value="0" {{ $logo->logo_img_display == 0 ? 'checked' : ''  }} />
				  <label class="form-check-label" for="showLogo">
					Show logo on the site
				  </label>
				</div>
				<div class="form-check">
				  <input class="form-check-input" type="radio" name="logo_img_display" id="hideLogo"  value="1" {{ $logo->logo_img_display == 1 ? 'checked' : ''  }} />
				  <label class="form-check-label" for="hideLogo">
					Hide logo on the site
				  </label>
				</div>
				<label>Title for logo
					<input class="form-control" type="text" placeholder="Logo title" aria-label="default input example" name="logo_title" value="{{ $logo->logo_title }}" />
				</label>
				<div class="logo-block__logo-size">
					<label>
						<input type="radio" name="logo_size" {{ $logo->logo_size == 's' ? 'checked' : ''  }} value="s" /> 
						Width: 115px, Height: 50px <b>(Small)</b>
					</label>
					<label>
						<input type="radio" name="logo_size" {{ $logo->logo_size == 'm' ? 'checked' : ''  }} value="m" /> 
						Width: 160px, Height: 80px <b>(Medium)</b>
					</label>
				</div>
				<input type="hidden" name="rewrite_logo" value="{{ $logo->id }}" />
				<input type="submit" value="Replace logo with another one" class="btn btn-secondary btn-sm" role="button" />
			@else
				<div class="form-check">
				  <input class="form-check-input" type="radio" name="logo_img_display" id="showLogo" value="0" checked />
				  <label class="form-check-label" for="showLogo">
					Show logo on the site
				  </label>
				</div>
				<div class="form-check">
				  <input class="form-check-input" type="radio" name="logo_img_display" id="hideLogo"  value="1" />
				  <label class="form-check-label" for="hideLogo">
					Hide logo on the site
				  </label>
				</div>
				<label>Title for logo
					<input class="form-control" type="text" placeholder="Logo title" aria-label="default input example" name="logo_title" />
				</label>
				<div class="logo-block__logo-size">
					<label>
						<input type="radio" name="logo_size" checked value="s" /> 
						Width: 115px, Height: 50px <b>(Small)</b>
					</label>
					<label>
						<input type="radio" name="logo_size" value="m" /> 
						Width: 160px, Height: 80px <b>(Medium)</b>
					</label>
				</div>
				<input type="submit" value="Add logo to the site" class="btn btn-primary btn-sm" role="button" />
			@endif
		</form>
	</div>
	<div class="logo-block__deletion">
		<p class="lead">Delete site logo</p>
		@if($logo->count())
			<img src="{{ $logo->getLogoImage() }}"  width="160" height="120" alt="{{$logo->logo_title}}" class="img-thumbnail" />
			<form action="{{ route('logo.destroy', ['id' => $logo->id]) }}" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
				@csrf
				@method('DELETE')
				<button type="submit" class="btn btn-danger btn-sm">Delete logo</button>
			</form>
		@else
			There isn't site logo here
		@endif
	</div>
</div>
