<div class="form-group webadmin" style="overflow: hidden;">
   {!! Form::label('', 'Docs',['class' => 'col-md-2']) !!}
	<div class="col-md-2" style="overflow: hidden;">
		{!! Form::label('icard', 'I Card') !!}
		@if(empty($noedit))
			{!! Form::file('icard', null, ['class' => 'form-control col-md-6 showPreview']) !!}
		@endif
		<div class="error-message"> {{ $errors->first('icard') }}</div>
		<div class="docPreview" id="icardpreview">
			@if(!empty($users->icard))
				<br><img src="{{asset($users->icard)}}" style="width:100%; height:180px"/>
			@endif
		</div>
	</div>
	<div class="col-md-2" style="overflow: hidden;">
		{!! Form::label('govt_issue_id', 'Govt Id (front)') !!}
		@if(empty($noedit))
			{!! Form::file('govt_issue_id', null, ['class' => 'form-control col-md-6']) !!}
		@endif
		<div class="error-message"> {{ $errors->first('govt_issue_id') }}</div>
		<div class="docPreview" id="govt_issue_idpreview">
			@if(!empty($users->govt_issue_id))
				<br><img src="{{asset($users->govt_issue_id)}}" style="width:100%; height:180px"/>
			@endif
		</div>
	</div>
	<div class="col-md-2" style="overflow: hidden;">
		{!! Form::label('back_govt_card', 'Govt Id (back)') !!}
		@if(empty($noedit))
			{!! Form::file('back_govt_card', null, ['class' => 'form-control col-md-6']) !!}
		@endif
		<div class="error-message"> {{ $errors->first('back_govt_card') }}</div>
		<div class="docPreview" id="back_govt_cardpreview">
			@if(!empty($users->back_govt_card))
				<br><img src="{{asset($users->back_govt_card)}}" style="width:100%; height:180px"/>
			@endif
		</div>
	</div>
</div>
<script type="text/javascript">
    $('#icard, #govt_issue_id, #back_govt_card').on('change',function(){
		var id = $(this).attr('id');
		var file = $(this).get(0).files[0];
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#'+id+'preview').html('<br><img src="' + reader.result + '" style="width:100%; height:180px"/>');
		}
		reader.readAsDataURL(file);
	});
</script>