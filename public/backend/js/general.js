jQuery(document).ready(function() {
	jQuery(".delete_user").on('click',function(){
		var dataId = jQuery(this).data('id');
		jQuery('#delete_confirm #deleteuserurl').attr('href', "/delete/"+dataId);
	});
});