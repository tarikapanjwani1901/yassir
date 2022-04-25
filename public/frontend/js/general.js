$(window).load(function(){
  $('.flexslider').flexslider({
    animation: "slide",
    start: function(slider){
      $('body').removeClass('loading');
    }
  });
});

$(window).load(function(){
  $('.flexslider1').flexslider({
    animation: "slide",
    animationLoop: false,
    itemWidth: 210,
    itemMargin: 20,
    minItems: 1,
    maxItems: 3,
    start: function(slider){
      $('body').removeClass('loading');
    }
  });
});


$( document ).ready(function() {
   $(".menuicon").click(function(){
    $(this).toggleClass("active");
    $(".mobmenu").toggleClass("open");
});
});