<?php
	use App\Models\Media;
?>
<div class="single-image-wrapper col-md-8 p-0">
    <div class="single-image image-holder-wrapper">
            <div class="image-holder-box {{$options['input_name']}}">
            	@if(isset($options['select_type']))
            		@if($options['select_type'] == 'multiple')
                        <?php
                            $values = [];
                            try{
                                if(isset($options['values'])){
                                    if(is_array($options['values'])){
                                        $values = $options['values'];
                                    } 
                                }
                            }catch(\Exception $e){ }
                        ?>
            			@foreach($values as $img_id)
                            <div class="sortable_images">
    	            			<img src="{{ Media::geturl($img_id) }}" height="100px;" width="100px;">
    	                        <input type="hidden" class="image-holder-input" name="{{$options['input_name']}}[]" value="{{$img_id}}">
                                <a href="javascript:;" class="removeMediaImg">remove</a>
                            </div>
                        @endforeach
            		@else
                        <div>
                            @if($options['values'])
                			    <img src="{{ Media::geturl($options['values']) }}" height="100px;" width="100px;">
                            @else
                                <img src="https://placehold.co/100x100/" height="100px;" width="100px;" class="dummy-placeholder">
                            @endif
                            <input type="hidden" class="image-holder-input" name="{{$options['input_name']}}" value="{{$options['values']}}">
                        </div>
            		@endif
            	@else
            		<img src="https://placehold.co/100x100/" height="100px;" width="100px;" class="dummy-placeholder">
            	@endif
            	
            </div>
    </div>
    <button type="button" class="image-picker btn btn-default btn-border pull-left clearfix" data-url="{{route('media.template',$options)}}">
        <i class="fas fa-folder-open mr-2"></i> Choose
    </button>
</div>