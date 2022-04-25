@include('header')
<div class="container aboutpage paddtopbottom40">
	@foreach($cms_infot as $cms)
     <div class="commonttl-subttl">
                <h2>{{ $cms->title }}</h2>
            </div>
          		
		{!! $cms->description !!}

	@endforeach
</div>
</div>
@include('footer')