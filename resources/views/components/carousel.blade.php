<link rel="stylesheet" type="text/css" href="{{url('/')}}/css/responsiveslides.css"/>

<div class="text-center">
    <h2>Gallery</h2>
</div>
<div class="container-fluid" id="spinner" style="text-align: center; margin: 10px;">
    <i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
</div>
<div class="container-fluid" id="gallery-container" style="visibility: hidden;">
    <ul class="rslides" id="carousel-slides">
        @foreach($images as $image)
            <li><span class="helper-slides"></span><img src="{{ $image }}" alt=""/></li>
        @endforeach
    </ul>
</div>
<script type="text/javascript" src="{{ url('/') }}/js/gallery-load.js"></script>
<script type="text/javascript" src="{{url('/')}}/js/carousel.js"></script>
<script type="text/javascript" src="{{ url('/') }}/js/responsiveslides.js"></script>
