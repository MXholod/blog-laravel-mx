<script src="{{ asset('assets/admin/js/CKEditor.js') }}"></script>

<script>
class MyUploadAdapter {
    // ...
	constructor( loader ) {
        // The file loader instance to use during the upload. It sounds scary but do not
        // worry — the loader will be passed into the adapter later on in this guide.
        this.loader = loader;
    }
	
    // Starts the upload process.
    upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
    }

    // Aborts the upload process.
    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }

	//Making Request
	// Initializes the XMLHttpRequest object using the URL passed to the constructor.
    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();
		
        // Note that your request may look different. It is up to you and your editor
        // integration to choose the right communication channel. This example uses
        // a POST request with JSON as a data structure but your configuration
        // could be different.
			'@if($post_id)'
				xhr.open( 'POST', '{{ route('admin.image_upload.edit') }}', true );
			'@else'
				xhr.open( 'POST', '{{ route('admin.image_upload.store') }}', true );	
			'@endif'
		xhr.setRequestHeader( 'x-csrf-token', '{{ csrf_token() }}' );
        xhr.responseType = 'json';
    }
	
	//Making Response
	// Initializes XMLHttpRequest listeners.
    _initListeners( resolve, reject, file ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${ file.name }.`;

        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;

            // This example assumes the XHR server's "response" object will come with
            // an "error" which has its own "message" that can be passed to reject()
            // in the upload promise.
            //
            // Your integration may handle upload errors in a different way so make sure
            // it is done properly. The reject() function must be called when the upload fails.
            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }

            // If the upload is successful, resolve the upload promise with an object containing
            // at least the "default" URL, pointing to the image on the server.
            // This URL will be used to display the image in the content. Learn more in the
            // UploadAdapter#upload documentation.
			resolve( {
                default: response.url
            } );
			
			/*resolve( {
				urls:{
					default: response.url
				},
				//Get the image ID from DB
				imageId: response.imageId
            } );*/
        } );

        // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
        // properties which are used e.g. to display the upload progress bar in the editor
        // user interface.
        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
		// Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
        // properties which are used e.g. to display the upload progress bar in the editor
        // user interface.
        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
    }
	// Prepares the data and sends the request.
    _sendRequest( file ) {
        // Prepare the form data.
        const data = new FormData();
		
		//File name using in controller action
        data.append( 'upload', file );
		'@if($post_id)'
			data.append( 'post_id', '{{ $post_id }}' );
		'@endif'
        // Important note: This is the right place to implement security mechanisms
        // like authentication and CSRF protection. For instance, you can use
        // XMLHttpRequest.setRequestHeader() to set the request headers containing
        // the CSRF token generated earlier by your application.

        // Send the request.
        this.xhr.send( data );
    }

	
}//End of class MyUploadAdapter

//Custom Plugin to upload images
function SimpleUploadAdapterPlugin( editor ) {
	
    //Add class of custom image upload adapter
	editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new MyUploadAdapter( loader );
    };
	//Watching for changes and get
	editor.model.document.on('change', (eventInfo, batch) => {
		//Array of all images within the content place
		let postImages = Array.from( new DOMParser().parseFromString( editor.getData(), 'text/html' )
			.querySelectorAll( 'img' ) )
			.map( img => {
				//console.log("Image ",img.parent);
				let imgStr = img.getAttribute( 'src' );
				if(imgStr){
					//http://laravelblog/spatie/177/conversions/avatar-thumb.jpg
					let lastSlashIndex = imgStr.lastIndexOf('/',imgStr.length-1);
					let imgName = imgStr.substring(lastSlashIndex+1, imgStr.length).replace(/-thumb[\.\w]*/gi,'');
					//http://laravelblog/spatie/177
					let imgId = Number(imgStr.split('/')[4]);
					return { imgName, imgId };
				}
			});
		
		let id = document.querySelector("#postImages");
		id.value = JSON.stringify(postImages);
		
		/*let selected = eventInfo?.source?.selection?.getSelectedElement();
		//If image is selected
		if(selected){
			console.log( 'The data has changed! 1', selected.getAttribute('src') );
		}else{
			console.log( 'The data has changed! 2' );
		}*/
	} );
}
</script>