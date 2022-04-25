
@include('header')
@foreach($cms_infos as $cms)
  
  {!! $cms->description !!}
  
@endforeach
@include('footer')