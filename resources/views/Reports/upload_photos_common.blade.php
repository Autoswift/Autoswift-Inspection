<div class="col-md-4 col-12">
   <div class="form-group">
	  <input rel="{{ $photo_type }}" type="file" 
		 name="uploadPhotos[{{ $photo_type }}][]"  style="background-color: #337ab7; color: #fff;"
		 class="uploadPhoto form-control" accept="image/*"
		 multiple="multiple">
   </div>
</div>
<div class="col-md-12 col-12">
   <div class="profile-header" >
	  <div class="relative uploadImageMultiapl">
		 <div class="row" id="listImages_{{$photo_type}}"></div>
		 <ul id="sortable_{{$photo_type}}" class="sortable" >
			@if(!empty($finance))
				@php 
				   $photo=json_decode($finance->photo, 1);
				   $approve_photo=json_decode($finance->approve_photo, 1);
				   $approve_photo=isset($approve_photo[$photo_type]) ? $approve_photo[$photo_type] : [];
				@endphp
				@if(!empty($photo))
					@if(!empty($photo[$photo_type]))
						@foreach($photo[$photo_type] as $key=>$item)
							<li class="ui-state-default image{{$key}}" id="image{{$photo_type}}_{{$key}}"><div><ul class="photo-remove"><li><a href="#" onclick=removimg("{{$item}}","{{$key}}","photo","{{$photo_type}}")>Remove</a></li><li><a href="#" onclick=rotate("{{$item}}","right","photo_{{$photo_type.$key}}")><i class="fa fa-rotate-right"></i></a></li><li><a href="#" onclick=rotate("{{$item}}","left","photo_{{$photo_type.$key}}")><i class="fa fa-rotate-left"></i></a></li></ul></div><img src="{{asset($item)}}" title="{{$item}}" id="photo_{{$photo_type.$key}}"><div style="text-align: center;"><input type="checkbox" name="approve_photo[{{ $photo_type }}][]" class="approve-check" value="{{$item}}" @if(in_array($item,$approve_photo)) checked @endif></div>
							</li>
						@endforeach
					@endif
				@endif
			@endif
		 </ul>
	  </div>
   </div>
</div>
@if(!empty($finance))
<script type="text/javascript">
	$("#sortable_{{$photo_type}}").sortable({
		update: function(e) {
			var imageids_arr = [];
			$('#sortable_{{$photo_type}} .ui-state-default').each(function() {
				id = $(this).attr('id');
				split_id = id.split("_");
				imageids_arr.push(split_id[1]);
			});
			$.post("{{route('image_reorder')}}",{id:"{{$finance->id}}",imageids_arr:imageids_arr, photo_type: '{{$photo_type}}'},function(result) {
				if (result.status == true) {
					toastr.success(result.msg, "success");
				} else {
					toastr.error(result.msg, "Error");
				}
			});
		}
	});
</script>
@endif