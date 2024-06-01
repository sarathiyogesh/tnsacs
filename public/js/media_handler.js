$(document).ready(function(){
	$(document).on('click','.image-picker', function(){
		$('#mediaiFrameLoading').show();
		$('.dummy-placeholder').hide();
		$('#mediaModal').modal('show');
		$('#setiFrame').find('iframe').remove();
		$('#setiFrame').append('<iframe height="100%" width="100%" frameborder="0" src="'+$(this).attr('data-url')+'">Your browser isnt compatible</iframe>');
	});

	$(document).on('click','.removeMediaImg', function(){
		console.log('asdf');
		if($(this).parents('.sortable_images').length){
			$(this).parents('.sortable_images').remove();
		}
	});
});