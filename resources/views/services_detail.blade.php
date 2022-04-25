@include('header')
<div id="main" class="inner-content servicespage-detail">

	<div class="pagettl">
        <h1>{{ $service }}</h1>
    </div>

    <div class="searchbox">
    <div class="container">
        <form>
            <input type="text" placeholder="Enter Location, Project or Landmark" name="s_key" value="<?php echo (isset($_GET['s_key']) && $_GET['s_key'] != '' ) ? $_GET['s_key'] : '' ?>" id="s_key">
            <select id="s_city" name="s_city">
                <option value="ahmedabad" <?php echo (isset($_GET['s_city']) && $_GET['s_city'] == 'ahmedabad') ? 'selected' : ''; ?>>Ahmedabad</option>
                <option value="gandhinagar" <?php echo (isset($_GET['s_city']) && $_GET['s_city'] == 'gandhinagar') ? 'selected' : ''; ?>>Gandhinagar</option>
            </select>
			<select id="s_cate" name="s_cate" required>
                <option value="">Category</option>
                    <?php foreach ($category as $key => $value) {
                        if ($service_id == $value->id) { ?>
                            <option value="<?php echo $value->id; ?>" selected><?php echo $value->name; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php }
                    } ?>
            </select>
            <select id="s_sub_cate" name="s_sub_cate">
                <option value="">Sub Category</option>
                <?php foreach ($type as $key => $value) {
                        if ($type_id != '' && $type_id == $value->id) { ?>
                            <option value="<?php echo $value->id; ?>" selected><?php echo $value->name; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php } ?>
                <?php } ?>
            </select>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    </div>

<div class="popular-listing-row">
<div class="container padd100">
<div class="row">
    <?php
        if ($result) {
            foreach ($result as $key => $value) {
                $maxLength = 150;
                $startPos = 0;
                $excerpt = '';
                if(strlen($value->l_description) > $maxLength) {
                    $excerpt   = substr($value->l_description, $startPos, $maxLength-3);
                    $lastSpace = strrpos($excerpt, ' ');
                    $excerpt   = substr($excerpt, 0, $lastSpace);
                    $excerpt  .= '...';
                } else {
                    $excerpt = $value->l_description;
                }


                ?>
                <div class="col-xs-6 col-sm-6 col-md-3">
                    <a class="h-listing-box" href="<?php echo url('/')?>/detail/{{ $value->vl_id }}">
                        <figure>
                            <img src="<?php echo url('/')?>/assets/images/featureimg5.png" alt="Popular Listing">
                            <div class="user">
                                <img src="<?php echo url('/')?>/assets/images/user.png" alt="User">
                            </div>
                            <div class="like">
                                {{ $value->l_view }} <i class="fa fa-heart"></i>
                            </div>
                        </figure>
                        <div class="content">
                            <h4>{{ $value->l_title }}</h4>
                            <p>{{ $excerpt }}</p>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <span>( {{ $value->l_view }} count )</span>
                            </div>

                            <div class="address">
                                <i class="fa fa-map-marker"></i> {{ $value->l_nearby }}
                            </div>
                        </div>
                    </a>
                </div>
            <?php }
        } else {
            echo '<h2>No result found.</h2>';
        }?>
</div>
</div></div>
	</div>

<script type="text/javascript">
    jQuery("#s_cate").on('change',function(){
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getType')}}?category="+this.value,
            success:function(data){
                if ( data ) {
                    //Empty Drop Down
                    $("#s_sub_cate").empty();

                    $("#s_sub_cate").append('<option value="">Sub Category</option>');
                    $.each( data, function( key, value ) {
                        $("#s_sub_cate").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            }
        })
    });
</script>
@include('footer')