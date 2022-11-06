	$(document).ready(function(){
		$('#multicheck').click(function() {
			if ($('#multicheck').is(':checked')) {
				$('.multicheck').prop('checked', true);
			} else {
				$('.multicheck').prop('checked', false);
			}
		});
		
		$(document).on('click','.multicheck',function(){
			if (!$(this).is(':checked')) {
				$('#multicheck').prop('checked', false);
			}
		});
	});
	
	function multicheck_action (url){
		var multicheck_action_value = $('#multicheck_action').val();
		if(multicheck_action_value != 'none') {
			if( $('.multicheck').filter(':checked').length > 0 ) {
				var toastText = $("#multicheck_action option:selected").attr("toast-text");
				var selectedCheckboxes = new Array();
				$("input.multicheck:checked").each(function() {
					selectedCheckboxes.push($(this).val());
				});
				swal({
					title: "Are you sure",
					text: toastText+' (Total selected records: '+selectedCheckboxes.length+')',
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willReset) => {
					if (willReset) {
						if(multicheck_action_value == 'update_deposit') {
							$('#deposit_form').attr('action','update_deposit_multicheck');
							$('#deposit_form input[name=multicheck]').remove();
							$('#deposit_form').append('<input type="hidden" name="multicheck" value="'+selectedCheckboxes+'">');
							$('#deposite_Modal').modal('show');
						} else {
							$.ajax({
								type:"POST",
								url:url,
								data:{action:multicheck_action_value, multicheck:selectedCheckboxes},
								success: function(response){
									if(response.status==true){
										$('#multicheck_action').val('none');
										$('#multicheck, .multicheck').prop('checked', false);
										toastr.success(response.msg,"Success");
										location.reload();
									} else{
										toastr.error(response.msg,"Error");
									}
								}
							});
						}						
					}
				});
			} else {
				$('#multicheck_action').val('none');
				toastr.error('Please Check At Least 1 Checkbox to Perform Multi Check Action.');
				return false;
			}
			$('#multicheck_action').val('none');
		}
    }