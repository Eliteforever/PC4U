@extends('layouts.header')
    <meta id="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="<?php echo asset('css/imageSelector.css')?>" type="text/css">
@section('content')
	<div id="container">
		<div class="row">
			<form class="uploadImage" method="post" action="{{ route('commercial-post') }}" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="col s10">
					<div class="file-field input-field">
			      		<button type="button" onclick="imageSelectorHandler.show(this)" name="bannerImage" class="imageSelectorButton waves-effect waves-light btn">Selecteer Foto</button>
				    </div>
				</div>
				<div class="col s2">
					<p>
				    	<input type="checkbox" name="isBanner" id="test7"/>
				    	<label for="test7">is banner</label>
				    </p>
				</div>
				<input type="submit" class="waves-effect waves-light btn">
			</form>
		</div>
		<br><br><br>
	    <hr>
	    <p><b>Banner:</b></p>
      @forelse($arr[0] as $banner)
	    	<div class="contentImg">
	    		<img style="width: 300px; height: 300px;" src="/imgs{{ $banner['folder'] }}{{ $banner['filename'] }}">
	    		<a href="deleteCommercial/{{ $banner['id'] }}" class="action1 blue-grey lighten-1">
	    			 <i style="color: white;" class="material-icons">broken_image</i>
	    		</a>
	    	</div>
      @empty

	    @endforelse
	    <br>
	    <p><b>Other</b></p>
	    @forelse($arr[1] as $commercial)
	    	  @foreach($commercial as $comm)
              <div class="contentImg">
	    		        <img style="width: 300px; height: 300px;" src="/imgs{{ $comm['folder'] }}{{ $comm['filename'] }}">
	    		        <a href="deleteCommercial/{{ $comm['id'] }}" class="action1 blue-grey lighten-1">
	    			          <i style="color: white;" class="material-icons">broken_image</i>
	    		        </a>
	    		        <a href="makeBanner/{{ $comm['id'] }}" class="action2 blue-grey lighten-1">
	    			          <i style="color: white;" class="material-icons">crop_free</i>
	    		        </a>
	    	      </div>
          @endforeach
      @empty

	    @endforelse
	</div>

	<script type="text/javascript" src="{!! asset('js/imageSelector.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/admin/commercials.js') !!}" ></script>
@endsection
