$(document).ready(function(){
	
	window.basePath =$('#site_baseurl').val();
	window.site_prefix = $('#site_prefix').val();
	window.site_pulgin = $('#site_pulgin').val();   
	window.site_controller = $('#site_controller').val();
	window.site_base = $('#site_base').val();
	
	if(site_controller == "finances/"){
		$('.form-control').keypress(function(e) {
	            $(this).val($(this).val().toUpperCase());
	        });
		$('.form-control').keydown(function(e) {
	            $(this).val($(this).val().toUpperCase());
	        });
	}
	$.greenColor = function(id){
		$(id).css("background-color", "#93f793");
		$(id).css("color", "black");
		if( (id == "#policy_no") || (id == "#validity") || (id == "#policy_type") 
				|| (id == "#owner_in_policy") || (id == "#sum_inms") || (id == "#FinanceTaxPaid") 
				|| (id == "#vechile_condition") || (id == "#fule_used") || (id == "#ac") || (id == "#steereo") 
				|| (id == "#airbag") || (id == "#power_window") || (id == "#power_window") || (id == "#general_comment") ){
			$(id).attr("value", "-");
		}
	}


	$.changeColor = function(id){
		/*$(id).css("background-color", "#93f793");
		$(id).css("color", "black");*/
		$(id).change(function(){
			if(($(this).val() != "") ){
				$(id).css("background-color", "#93f793");
				$(id).css("color", "black");
			}else{
				$(id).css("background-color", "#f397976b");
				$(id).css("color", "black");
			}
		});
	};

	$.redColor = function(id){
		$(id).change(function(){
			alert(id);
			$(id).css("background-color", "#f39797")
		});			
	}

	$.uncheckFieldColor = function(id){
		$(id).focus(function(){
			//alert(id);
			if(($(this).val() == "") || ($(this).val() == "0")){
				$(id).css("background-color", "#f397976b");
				$(id).css("color", "black");
			}else{
				$(id).css("background-color", "#93f793");	
				$(id).css("color", "black");
			}
			
		});
	}
	window.basePath =$('#site_baseurl').val();
	window.site_prefix = $('#site_prefix').val();
	window.site_pulgin = $('#site_pulgin').val();   
	window.site_controller = $('#site_controller').val();
	$(".datepicker").datepicker({
		dateFormat: 'dd-mm-yy',
		yearRange: "-30:+0",
		 changeMonth: true,
      	 changeYear: true	
	});
	/* $("#paid_date").datepicker({
		dateFormat: 'dd-mm-yy',
		yearRange: "-30:+0",
		 changeMonth: true,
      	 changeYear: true	
	}); */
		
		
		/* Start Key Type Registration Number */
		
			$("#registrationNumber").keypress(function(){
			var n = $(this).val();
				$("#registrationNumber").val(n.replace(/\s/g,'-'));
			});
			
			$("#FinanceRegistrationNo").keypress(function(){
			var n = $(this).val();
				$("#FinanceRegistrationNo").val(n.replace(/\s/g,'-'));
			});
		/* End Key Type Registration Number */
		
		
		$("#valuation_by").css("background-color", "#f39797");
		$("#valuation_by").css("color", "black");
		var url = $(location).attr('href');
		// Getting the file name i.e last segment of URL (i.e. example.html)
		var fn = url.split('/').reverse()[0];
		// Getting the extension (i.e. html)
		var ext = url.split('/').reverse()[0].split('.').reverse()[0];
		// Getting the second last segment of URL (i.e. segment1)
		var lm =  url.split('/').reverse()[0];

		
		
		if(lm == "create"){
			
				$(".form-control").css("background-color", "#f397976b");
				$(".form-control").css("color", "black");	
			
			    $.greenColor("#reference_no");
			    $.greenColor("#mobile_no");
			    $.greenColor("#policy_no");
			    $.greenColor("#validity");
			    $.greenColor("#policy_type");
			    $.greenColor("#owner_in_policy");
			    $.greenColor("#sum_inms");
			    $.greenColor("#FinanceTaxPaid");
			    $.greenColor("#vechile_condition");
			    //$.greenColor("#fule_used");
			    $.greenColor("#ac");
			    $.greenColor("#steereo");
			    $.greenColor("#power_steering");
			    $.greenColor("#airbag");
			    $.greenColor("#power_window");
			    $.greenColor("#c_engine_condition");
			    $.greenColor("#c_cooling_system");
			    $.greenColor("#c_suspension_system");
			    $.greenColor("#c_electrical_system");
			    $.greenColor("#c_wheel");
			    $.greenColor("#c_chassis");
			    $.greenColor("#c_cabin");
			    $.greenColor("#c_condition_of_interiors");
			    $.greenColor("#c_glass");
			    $.greenColor("#c_paint");
			    $.greenColor("#c_damage");
			    $.greenColor("#general_comment");
			    
			    for(var c = 2; c<=5; c++){
					$("#FinanceRightTyerQuantity"+c).css("background-color", "white");
					$("#FinanceRightTyerQuantity"+c).css("color", "black");
					$("#FinanceRightTyerCompany"+c).css("background-color", "white");
					$("#FinanceRightTyerCompany"+c).css("color", "black");
					$("#FinanceRightQuality"+c).css("background-color", "white");
					$("#FinanceRightQuality"+c).css("color", "black");

					$("#FinanceLeftTyerQuantity"+c).css("background-color", "white");
					$("#FinanceLeftTyerQuantity"+c).css("color", "black");
					$("#FinanceLeftTyerCompany"+c).css("background-color", "white");
					$("#FinanceLeftTyerCompany"+c).css("color", "black");
					$("#FinanceLeftQuality"+c).css("background-color", "white");
					$("#FinanceLeftQuality"+c).css("color", "black");
				}
		}else if($.isNumeric(lm) == true){
			$("#valuation_by").css("background-color", "#93f793");
			$("#valuation_by").css("color", "black");
			$(".form-control").css("background-color", "#93f793");
			$(".form-control").css("color", "black");
			for(var c = 2; c<=5; c++){
				$("#FinanceRightTyerQuantity"+c).css("background-color", "#93f793");
				$("#FinanceRightTyerQuantity"+c).css("color", "black");
				$("#FinanceRightTyerCompany"+c).css("background-color", "#93f793");
				$("#FinanceRightTyerCompany"+c).css("color", "black");
				$("#FinanceRightQuality"+c).css("background-color", "#93f793");
				$("#FinanceRightQuality"+c).css("color", "black");

				$("#FinanceLeftTyerQuantity"+c).css("background-color", "#93f793");
				$("#FinanceLeftTyerQuantity"+c).css("color", "black");
				$("#FinanceLeftTyerCompany"+c).css("background-color", "#93f793");
				$("#FinanceLeftTyerCompany"+c).css("color", "black");
				$("#FinanceLeftQuality"+c).css("background-color", "#93f793");
				$("#FinanceLeftQuality"+c).css("color", "black");
			}
		}
		
		

		
		
	
	$("#genereatePdf").click(function(){
		
	});

	$("#paid_amount").change(function(){
		var paidAmount = $(this).val();
		var totalAmount = $("#totalAmount").val();
		
		if(!paidAmount){
			paidAmount = 0;
		}
		if(!totalAmount){
			totalAmount = 0;
		}

		if(parseFloat(paidAmount) > parseFloat(totalAmount)){
			alert("Insufficient Amount");
						$("#ramining_amount").val(0);
			$("#totalAmount").val( 0);
			$("#paid_amount").val( 0);
			return false;
		}else{
			var reminingAmount = parseFloat(totalAmount) - parseFloat(paidAmount);
			if(reminingAmount == 0){
				//$("#amount_paid").removeAttr("readOnly");
				//$("#paid_person").removeAttr("readOnly");
				//$("#paid_date").removeAttr("readOnly");
			}else{
				$("#amount_paid").val("");
				//$("#amount_paid").attr("readOnly", true);
				//$("#paid_person").attr("readOnly", true);
				$("#paid_person").val("");
				//$("#paid_date").attr("readOnly", true);
				$("#paid_date").val("");
			}
			
			$("#ramining_amount").val(reminingAmount);
		}
	});
	$("#totalAmount").change(function(){
		var paidAmount = $("#paid_amount").val();
		var totalAmount = $(this).val();

		if(!paidAmount){
			paidAmount = 0;
		}
		if(!totalAmount){
			totalAmount = 0;
		}
		
		if(parseFloat(paidAmount) > parseFloat(totalAmount)){
			alert("Insufficient Amount");
			$("#ramining_amount").val(0);
			$("#totalAmount").attr(0);
			$("#paid_amount").val( 0);
			return false;
		}else{			
			var reminingAmount = parseFloat(totalAmount) - parseFloat(paidAmount);
			if(reminingAmount == 0){
				//$("#amount_paid").removeAttr("readOnly");
				//$("#paid_person").removeAttr("readOnly");
				//$("#paid_date").removeAttr("readOnly");
			}else{
				$("#amount_paid").val("");
				//$("#amount_paid").attr("readOnly", true);
				//$("#paid_person").attr("readOnly", true);
				$("#paid_person").val("");
				//$("#paid_date").attr("readOnly", true);
				$("#paid_date").val("");
			}
			$("#ramining_amount").val(reminingAmount);
		}
	});

	$("#pdfGenerateButton").click(function(){
		$(".pdfGenerate").attr("value", "1");
	});

	$(".btn-default").click(function(){
		if(confirm("Please confirm before submit")){
        	return true
	    }
	    else{
	        return false;
	    }
		
	});
	$("#deleteFinance").click(function(){
		if(confirm("Are you sure to delete this report")){
        	return true
	    }
	    else{
	        return false;
	    }
		
	});
	
	/*****Deposite******/
	
	
	
	/*****End Deposite******/
	
	
	var multipalImages = "";
	$("#registrationNumber").change(function(){
		var  data = $(this).val();
		//alert(data);		
		$.ajax( {
			  url: window.basePath+window.site_base+'/finances/checkRegistration',
			  type: "POST",
			  data: {RegistrationNumber: data},
			  success: function( data ) { 
			  	//alert(data);
				if((data != "") && (data != 0) ){
					var a =  jQuery.parseJSON(data);
					var FinanceRightTyerQuantity = jQuery.parseJSON(a.Finance.right_tyer_quantity);
					var FinanceRightTyerCompany = jQuery.parseJSON(a.Finance.right_tyer_company);
					var FinanceRightQuality = jQuery.parseJSON(a.Finance.right_quality);
					var FinanceLeftTyerQuantity = jQuery.parseJSON(a.Finance.left_tyer_quantity);
					var FinanceLeftTyerCompany = jQuery.parseJSON(a.Finance.left_tyer_company);
					var FinanceLeftQuality = jQuery.parseJSON(a.Finance.left_quality);
					//alert(FinanceRightTyerQuantity);
					for( key in FinanceRightTyerQuantity ) {
						//alert(key);
						var keyd = parseInt(key)+1;
						//alert(keyd);
						$("#FinanceRightTyerQuantity"+keyd).css("background-color", "#93f793");
						$("#FinanceRightTyerQuantity"+keyd).css("color", "black");
						$("#FinanceRightTyerQuantity"+keyd).attr("value", FinanceRightTyerQuantity[key]);
						

						$("#FinanceRightTyerCompany"+keyd).css("background-color", "#93f793");
						$("#FinanceRightTyerCompany"+keyd).css("color", "black");
						$("#FinanceRightTyerCompany"+keyd).attr("value", FinanceRightTyerCompany[key]);
						
						
						$("#FinanceRightQuality"+keyd).css("background-color", "#93f793");
						$("#FinanceRightQuality"+keyd).css("color", "black");
						$("#FinanceRightQuality"+keyd).attr("value", FinanceRightQuality[key]);

						
						$("#FinanceLeftTyerQuantity"+keyd).css("background-color", "#93f793");
						$("#FinanceLeftTyerQuantity"+keyd).css("color", "black");
						$("#FinanceLeftTyerQuantity"+keyd).attr("value", FinanceLeftTyerQuantity[key]);
						
						
						$("#FinanceLeftTyerCompany"+keyd).css("background-color", "#93f793");
						$("#FinanceLeftTyerCompany"+keyd).css("color", "black");
						$("#FinanceLeftTyerCompany"+keyd).attr("value", FinanceLeftTyerCompany[key]);
						
						
						$("#FinanceLeftQuality"+keyd).css("background-color", "#93f793");
						$("#FinanceLeftQuality"+keyd).css("color", "black");
						$("#FinanceLeftQuality"+keyd).attr("value", FinanceLeftQuality[key]);
					}	


					$("#c_damage").attr("value", a.Finance.c_damage);
					$.greenColor("#c_damage");

					$("#financer_representative").attr("value", a.Finance.financer_representative);
					$.greenColor("#financer_representative");

					$("#mobile_no").attr("value", a.Finance.staff_name);
					$.greenColor("#mobile_no");
					
					$("#place_of_valuation").attr("value", a.Finance.place_of_valuation);
					$.greenColor("#place_of_valuation");

					$("#valuation_by option[value="+a.Finance.valuation_by+"]").attr("selected" ,"selected");
					$.greenColor("#valuation_by");

					$("#makeModel").attr("value", a.Finance.make_model);
					$.greenColor("#makeModel");

					$("#chachees_number").attr("value", a.Finance.chachees_number);
					$.greenColor("#chachees_number");

					$("#engine_number").attr("value", a.Finance.engine_number);
					$.greenColor("#engine_number");

					$("#color").attr("value", a.Finance.color);
					$.greenColor("#color");

					$("#registerd_owner").attr("value", a.Finance.registerd_owner);
					$.greenColor("#registerd_owner");

					$("#seating_capacity").attr("value", a.Finance.seating_capacity);
					$.greenColor("#seating_capacity");

					$("#financed_by").attr("value", a.Finance.financed_by);
					$.greenColor("#financed_by");

					$("#laden_wt").attr("value", a.Finance.laden_wt);
					$.greenColor("#laden_wt");

					$("#hypothecation").attr("value", a.Finance.hypothecation);
					$.greenColor("#hypothecation");

					$("#tyres").attr("value", a.Finance.tyres);
					$.greenColor("#tyres");

					$("#unladen_wt").attr("value", a.Finance.unladen_wt);
					$.greenColor("#unladen_wt");

					$("#fule_used").attr("value", a.Finance.fule_used);
					$.greenColor("#fule_used");
					$("#fule_used option[value='"+a.Finance.fule_used+"']").attr("selected" ,"selected");


					$("#policy_no").attr("value", a.Finance.policy_no);
					$.greenColor("#policy_no");

					$("#mm_reading").attr("value", a.Finance.mm_reading);
					$.greenColor("#mm_reading");

					$("#validity").attr("value", a.Finance.validity);
					$.greenColor("#validity");

					$("#battery").attr("value", a.Finance.battery);
					$.greenColor("#battery");

					$("#policy_type").attr("value", a.Finance.policy_type);
					$.greenColor("#policy_type");

					$("#radiator").attr("value", a.Finance.radiator);
					$.greenColor("#radiator");

					$("#sum_inms").attr("value", a.Finance.sum_inms);
					$("#ac").attr("value", a.Finance.ac);
					$("#ac option[value="+a.Finance.ac+"]").attr("selected" ,"selected");
					$.greenColor("#ac");

					$("#FinanceTaxPaid").attr("value", a.Finance.FinanceTaxPaid);
					$("#steereo").attr("value", a.Finance.steereo);
					$("#steereo option[value="+a.Finance.steereo+"]").attr("selected" ,"selected");
					$.greenColor("#steereo");

					$("#vechile_condition").attr("value", a.Finance.vechile_condition);
					$.greenColor("#vechile_condition");

					$("#power_steering").attr("value", a.Finance.power_steering);
					$("#power_steering option[value="+a.Finance.power_steering+"]").attr("selected" ,"selected");
					$.greenColor("#power_steering");


					$("#major_accidentented").attr("value", a.Finance.major_accidentented);
					$("#major_accidentented option[value="+a.Finance.major_accidentented+"]").attr("selected" ,"selected");
					$.greenColor("#major_accidentented");

					$("#power_window").attr("value", a.Finance.power_window);
					$("#power_window option[value="+a.Finance.power_window+"]").attr("selected" ,"selected");
					$.greenColor("#power_window");
					//alert( a.Finance.air_bag);
					$("#airbag").attr("value", a.Finance.air_bag);
					$("#airbag option[value="+a.Finance.air_bag+"]").attr("selected" ,"selected");
					$.greenColor("#airbag");

					$("#owner_serial_number").attr("value", a.Finance.owner_serial_number);
					$.greenColor("#owner_serial_number");

					$("#cube_capacity").attr("value", a.Finance.cube_capacity);
					$.greenColor("#cube_capacity");
					
					var reportDate = new Date(parseInt(a.Finance.report_date) * 1000);
					var mm = reportDate.getDate();
					var dd = reportDate.getMonth();
					dd++;
					if(dd <=9){
						dd = "0"+dd;
					}
					if(mm <= 9){
						mm = "0"+mm;
					}
					//alert(reportDate.ToString("yy/MM/dd"));
					var yy = reportDate.getFullYear();
					$("#reportDate").attr("value", mm+"-"+dd+"-"+yy);
					$.greenColor("#reportDate");

					$("#inspectionDate").attr("value", a.Finance.inspection_date);
					$.greenColor("#inspectionDate");

					$("#registrationDate").attr("value", a.Finance.registration_date);
					$.greenColor("#registrationDate");

					$("#owner_in_policy").attr("value", a.Finance.owner_in_policy);
					$("#sum_insured").attr("value", a.Finance.sum_insured);
					$("#FinanceTaxPaid").attr("value", a.Finance.tax_paid);
					$.greenColor("#FinanceTaxPaid");

					$("#general_comment").attr("value", a.Finance.general_comment);
					$("#general_comment").css("background-color", "#93f793");

					$("#totalAmount").css("background-color", "#93f793");
					$("#totalAmount").css("color", "black");
					$("#totalAmount").attr("value", a.Finance.total_amount);
					$("#paid_amount").css("background-color", "#93f793");
					$("#paid_amount").css("color", "black");
					$("#paid_amount").attr("value", a.Finance.amount_paid);
					$("#ramining_amount").css("background-color", "#93f793");
					$("#ramining_amount").css("color", "black");
					$("#ramining_amount").attr("value", a.Finance.remaining_amount);
					$("#fair_amount").css("background-color", "#93f793");
					$("#fair_amount").css("color", "black");
					$("#fair_amount").attr("value", a.Finance.fair_amount);
					
					$("#notice").attr("value", a.Finance.notice);
					$("#notice option[value="+a.Finance.notice+"]").attr("selected" ,"selected");
					$.greenColor("#notice");

					$("#chachees_number").css("background-color", "#f397976b");
					$("#chachees_number").css("color", "black");
					$("#registrationNumber").css("background-color", "#f397976b");
					$("#registrationNumber").css("color", "black");
					
					/* var photoChassis = (a.Finance.chachees_number_photo);
					//alert(photoChassis);
					$("#crop_wrapper").children("img").attr("src", "/img/user/finance/"+photoChassis);
					$("#FinanceChacheesNumberPhoto").attr("type" , "hidden");
					$("#FinanceChacheesNumberPhoto").attr("value" , photoChassis);
					$("#chachees_number_photo").attr("value" , photoChassis);
					
					$("#crop_div").remove();
					var photo = jQuery.parseJSON(a.Finance.photo) ;
					$("#FinancePhoto1").attr("type" , "hidden");
					$("#FinancePhoto1").attr("value" , a.Finance.photo);
					var lengthPhoto = photo.length;
					//$(".user_imgMultipalImages").children().empty()
					/*for(var i=0; i<=lengthPhoto; i++){
						$(".user_imgMultipalImages").children().append("img src='/finances/img/user/finace/'"++" ")
					}
					$.each(photo, function(key,value) {
						
						multipalImages += "<div class='col-md-2'> <div class='user_imgMultipalImages'> </div> <img img-responsive imageCounter_0 src='/img/user/finance/"+value+"' style='height:100px;width: 100px;'/> </div>";
					});
					//alert(multipalImages);
					  $("#uploadImageMultiapl").removeClass("col-md-2");
					  $("#uploadImageMultiapl").addClass("col-md-12");
					  $(".user_imgMultipalImages").html("<br>"+multipalImages);

					  $("#oldFinanceId").attr("value", a.Finance.id); */
					//var photo = jQuery.parseJSON(a.Finance.photo) ;
					$(".duplicate_entry").attr("value", "1");					
				}else{
					$(".duplicate_entry").attr("value", "0");
				  /* //alert("Not Dele#te");
				  	
				  	/*$("#chachees_number").css("background-color", "#ffffff");
					$("#chachees_number").css("color", "black");
					$("#registrationNumber").css("background-color", "#ffffff");
					$("#registrationNumber").css("color", "black");

					$("#financer_representative").attr("value", "");
					$("#financer_representative").css("background-color", "#f39797");

					$("#mobile_no").attr("value", "-");

					$("#place_of_valuation").attr("value", "");
					$("#place_of_valuation").css("background-color", "#f39797");

					$("#valuation_by option").removeAttr("selected" );
					$("#valuation_by").css("background-color", "#f39797");


				    $("#makeModel").attr("value", "");
					$("#makeModel").css("background-color", "#f39797");

					$("#chachees_number").attr("value", "");
					$("#chachees_number").css("background-color", "#f39797");

					$("#engine_number").attr("value", "");
					$("#engine_number").css("background-color", "#f39797");

					$("#color").attr("value", "");
					$("#color").css("background-color", "#f39797");

					$("#registerd_owner").attr("value", "");
					$("#registerd_owner").css("background-color", "#f39797");

					$("#seating_capacity").attr("value", "");
					$("#seating_capacity").css("background-color", "#f39797");

					$("#financed_by").attr("value", "");
					$("#financed_by").css("background-color", "#f39797");

					$("#laden_wt").attr("value", "");
					$("#laden_wt").css("background-color", "#f39797");

					$("#hypothecation").attr("value", "");
					$("#hypothecation").css("background-color", "#f39797");

					$("#tyres").attr("value", "");
					$("#tyres").css("background-color", "#f39797");

					$("#unladen_wt").attr("value", "");
					$("#unladen_wt").css("background-color", "#f39797");

					
				  //$("#valuation_by option[value="+a.Finance.valuation_by+"]").attr("selected" ,"selected");
					$("#fule_used option[value='-']").attr("selected", "selected");
					//$("#fule_used").css("background-color", "#f39797");

					//$("#fule_used").children("option").val(a.Finance.fule_used).attr("selected", "selected");
					$("#policy_no").attr("value", "-");
					//$("#policy_no").css("background-color", "#f39797");

					$("#mm_reading").attr("value", "");
					$("#mm_reading").css("background-color", "#f39797");

					$("#validity").attr("value", "-");
					//$("#validity").css("background-color", "#f39797");

					$("#battery").attr("value", "");
					$("#battery").css("background-color", "#f39797");

					$("#policy_type").attr("value", "-");
					//$("#policy_type").css("background-color", "#f39797");

					$("#radiator").attr("value", "");
					$("#radiator").css("background-color", "#f39797");

					$("#sum_inms").attr("value", "-");
					//$("#sum_inms").css("background-color", "#f39797");

					$("#ac option[value='-']").attr("selected", "selected");
					//$("#ac").css("background-color", "#f39797");

					//$("#ac").children("option").val(a.Finance.ac).attr("selected", "selected");
					//$("#FinanceTaxPaid").attr("value", "");
					$("#steereo option[value='-']").attr("selected", "selected");
					//$("#steereo").children("option").val(a.Finance.steereo).attr("selected", "selected");
					$("#vechile_condition").attr("value", "-");
					
					$("#power_steering option[value='-']").attr("selected", "selected");
					//$("#power_steering").children("option").val(a.Finance.power_steering).attr("selected", "selected");
					
					$("#major_accidentented option[value='no']").attr("selected", "selected");
					//$("#major_accidentented").children("option").val(a.Finance.major_accidentented).attr("selected", "selected");
					
					$("#power_window option[value='-']").attr("selected", "selected");
					//$("#power_window").children("option").val(a.Finance.power_window).attr("selected", "selected");
					
					$("#airbag option[value='-']").attr("selected", "selected");
					//$("#airbag").children("option").val(a.Finance.airbag).attr("selected", "selected");
					$("#owner_serial_number").attr("value", "");
					$("#owner_serial_number").css("background-color", "#f39797");

					$("#cube_capacity").attr("value", "");
					$("#cube_capacity").css("background-color", "#f39797");
					//$("#FinanceLeftTyerQuantity").attr("value", "");
					$("#reportDate").attr("value", "");
					$("#reportDate").css("background-color", "#f39797");

					$("#inspectionDate").attr("value", "");
					$("#inspectionDate").css("background-color", "#f39797");

					$("#registrationDate").attr("value", "");
					$("#registrationDate").css("background-color", "#f39797");

					$("#owner_in_policy").attr("value", "-");
					$("#sum_insured").attr("value", "");
					$("#FinanceTaxPaid").attr("value", "-");
					$("#general_comment").attr("value", "-");

					$("#totalAmount").attr("value", "");
					$("#totalAmount").css("background-color", "#f39797");

					$("#paid_amount").attr("value", "");
					$("#paid_amount").css("background-color", "#f39797");

					$("#ramining_amount").attr("value", "");
					$("#ramining_amount").css("background-color", "#f39797");

					$("#fair_amount").attr("value", "");
					$("#fair_amount").css("background-color", "#f39797");

					$("#notice").attr("value", "");
					$("#notice").css("background-color", "#f39797");

					for( var i=1; i<=7; i++ ) {
						if(i==1){
							$("#FinanceRightTyerQuantity"+i).css("background-color", "#f39797");
							$("#FinanceRightTyerQuantity"+i).css("color", "black");
							$("#FinanceRightTyerCompany"+i).css("background-color", "#f39797");
							$("#FinanceRightTyerCompany"+i).css("color", "black");
							$("#FinanceRightQuality"+i).css("background-color", "#f39797");
							$("#FinanceRightQuality"+i).css("color", "black");
							$("#FinanceLeftTyerQuantity"+i).css("background-color", "#f39797");
							$("#FinanceLeftTyerQuantity"+i).css("color", "black");
							$("#FinanceLeftTyerCompany"+i).css("background-color", "#f39797");
							$("#FinanceLeftTyerCompany"+i).css("color", "black");
							$("#FinanceLeftQuality"+i).css("background-color", "#f39797");
							$("#FinanceLeftQuality"+i).css("color", "black");
						}else{
							$("#FinanceRightTyerQuantity"+i).css("background-color", "white");
							$("#FinanceRightTyerQuantity"+i).css("color", "black");
							$("#FinanceRightTyerCompany"+i).css("background-color", "white");
							$("#FinanceRightTyerCompany"+i).css("color", "black");
							$("#FinanceRightQuality"+i).css("background-color", "white");
							$("#FinanceRightQuality"+i).css("color", "black");
							$("#FinanceLeftTyerQuantity"+i).css("background-color", "white");
							$("#FinanceLeftTyerQuantity"+i).css("color", "black");
							$("#FinanceLeftTyerCompany"+i).css("background-color", "white");
							$("#FinanceLeftTyerCompany"+i).css("color", "black");
							$("#FinanceLeftQuality"+i).css("background-color", "white");
							$("#FinanceLeftQuality"+i).css("color", "black");
						}
						
						$("#FinanceRightTyerQuantity"+i).attr("value", "");
						$("#FinanceRightTyerCompany"+i).attr("value", "");
						$("#FinanceRightQuality"+i).attr("value", "");
						$("#FinanceLeftTyerQuantity"+i).attr("value", "");						
						$("#FinanceLeftTyerCompany"+i).attr("value", "");						
						$("#FinanceLeftQuality"+i).attr("value", "");
					} */	
					
				}
			  }
			});
	});

    $(".uploadBtn").change(function(){
        readURL(this, $(this).attr("data-value"));
    });
	
	$("#stamp").click(function(){
    	if($(this).val() == 1){
    		$(this).val(0);
    	}else{
    		$(this).val(1);
    	}
    });
	
	$("#amount_paid").change(function(){
		var totalAmount = $("#totalAmount").val();
		var amountPaid = $(this).val();
		
		if(parseInt(amountPaid) > parseInt(totalAmount)){
			alert("Depostie amount is lesser then total amount");
			return false;
		}else{
			$("#paid_date").val(parseInt(totalAmount) - parseInt(amountPaid) );
		}
	});
	
	/*** For multiapl file upload ***/
    $(".uploadMultipalBtn").change(function () {
    	//alert("sdf");
    	$("#uploadImageMultiapl").removeClass("col-md-2");
    	$("#uploadImageMultiapl").prepend("<br>");
    	$("#uploadImageMultiapl").addClass("col-md-12");
        if (typeof (FileReader) != "undefined") {
            var dvPreview = $(".user_imgMultipalImages");
            dvPreview.html("");
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                //if (regex.test(file[0].name.toLowerCase())) {
                if (regex.test(file[0].name)) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var div = $('<div class="col-md-2"><div class="user_imgMultipalImages"> ');
                        var img = $('<img class="img-responsive imageCounter_0" />');
                        img.attr("style", "height:100px;width: 100px;");
                        img.attr("src", e.target.result);
                        var htmlData = div.append(img);
                        div.append("</div> </div>");

                        //$('.imageCounter_0').attr('src', e.target.result);
                        dvPreview.append(div);
                    }
                    reader.readAsDataURL(file[0]);
                } /* else {
                    alert(file[0].name + " is not a valid image file.");
                    dvPreview.html("");
                    return false;
                } */
            });
        } else {
            alert("This browser does not support HTML5 FileReader.");
        }
    });
	
	
	
	
	/********* Validation Start  ********/
	
	$("#HeaderCreateForm").validate({
                    rules: {
                        'data[Header][mobile_number]': {
                            required: true,
                        },
                        'data[Header][licence_no]': {
                            required: true,
                        },
                        'data[Header][expire]': {
                            required: true,
                        },
                        'data[Header][email1]': {
                        	email: true,
                            required: true,
                        },
                        'data[Header][email2]': {
                        	email: true,
                            required: true,
                        },
                    },
                    messages: {
                        'data[Header][mobile_number]': {
                            required: "Please fill mobile number",
                        },
                        'data[Header][licence_no]': {
                            required: "Please Licence Number",
                        },
                        'data[Header][expire]': {
                            required: "Please enter Expire",
                        },
                        'data[Header][email1]': {
                            email: "Invalid Email",
                            required: "Please fill email",
                        },
                        'data[Header][email2]': {
                        	email: "Invalid Email",
                            required: "Please fill email",
                        }
                    }
                });
				
				
		$("#QueryCreateForm").validate({
			rules: {
				'data[Query][area]': {
					required: true,
				},
				'data[Query][name]': {
					required: true,
				},
				'data[Query][mobile]': {
					required: true,
				},
				'data[Query][address]': {
					required: true,
				},
				'data[Query][registration_no]': {
					required: true,
				},
				'data[Query][payment]': {
					required: true,
				},
			},
			messages: {
				'data[Query][area]': {
					required: "Please select area for send query",
				},
				'data[Query][name]': {
					required: "Please enter name",
				},
				'data[Query][mobile]': {
					required: "Please enter mobile number",
				},
				'data[Query][address]': {
					required: "Please fill address",
				},
				'data[Query][registration_no]': {
					required: "Please fill registration number",
				},
				'data[Query][payment]': {
					required: "Please fill payment amount",
				}
			}
		});


	jQuery.validator.addMethod("requiredTyer", jQuery.validator.methods.required, "Fill Detail");
	
	$("#FinanceCreateForm").validate({
			rules: {
				'data[Finance][reference_no]': {
					required: true,
				},
				'data[Finance][valuation_by]': {
					required: true,
				},
				'data[Finance][place_of_valuation]': {
					required: true,
				},
				'data[Finance][staff_name]': {
					required: true,
				},
				'data[Finance][financer_representative]': {
					required: true,
				},
				'data[Finance][registration_no]': {
					required: true,
				},
				'data[Finance][report_date]': {
					required: true,
					//validDate: true,
				},
				'data[Finance][make_model]': {
					required: true,
				},
				'data[Finance][inspection_date]': {
					required: true,
				},
				'data[Finance][chachees_number]': {
					required: true,
				},
				'data[Finance][registration_date]': {
					required: true,
				},
				'data[Finance][engine_number]': {
					required: true,
				},
				'data[Finance][color]': {
					required: true,
				},'data[Finance][registerd_owner]': {
					required: true,
				},
				'data[Finance][seating_capacity]': {
					required: true,
				},
				'data[Finance][financed_by]': {
					required: true,
				},
				'data[Finance][laden_wt]': {
					required: true,
				},
				'data[Finance][hypothecation]': {
					required: true,
				},
				'data[Finance][unladen_wt]': {
					required: true,
				},
				'data[Finance][fule_used]': {
					required: true,
				},
				'data[Finance][policy_no]': {
					required: true,
				},
				'data[Finance][owner_serial_number]': {
					required: true,
				},
				'data[Finance][validity]': {
					required: true,
				},'data[Finance][cube_capacity]': {
					required: true,
				},
				'data[Finance][policy_type]': {
					required: true,
				},'data[Finance][mm_reading]': {
					required: true,
				},
				'data[Finance][owner_in_policy]': {
					required: true,
				},'data[Finance][battery]': {
					required: true,
				},
				'data[Finance][sum_insured]': {
					required: true,
				},
				'data[Finance][radiator]': {
					required: true,
				},
				'data[Finance][tax_paid]': {
					required: true,
				},
				'data[Finance][ac]': {
					required: true,
				},
				'data[Finance][vechile_condition]': {
					required: true,
				},
				'data[Finance][steereo]': {
					required: true,
				},
				'data[Finance][major_accidentented]': {
					required: true,
				},
				'data[Finance][power_steering]': {
					required: true,
				},'data[Finance][air_bag]': {
					required: true,
				},
				'data[Finance][power_window]': {
					required: true,
				},
				'data[Finance][general_comment]': {
					required: true,
				},
				'data[Finance][c_damage]': {
					required: true,
				},
				'data[Finance][notice]': {
					required: true,
				},
				'data[Finance][total_amount]': {
					required: true,
				},
				'data[Finance][amount_paid]': {
					required: true,
				},
				'data[Finance][fair_amount]': {
					required: true,
				},
			},
			messages: {
				'data[Finance][reference_no]': {
					required: "Please fill reference number",
				},
				'data[Finance][valuation_by]': {
					required: "Please fill valuation initiated by",
				},
				'data[Finance][place_of_valuation]': {
					required: "Please fill place of valuation",
				},
				'data[Finance][staff_name]': {
					required: "Please fill staff name",
				},
				'data[Finance][financer_representative]': {
					required: "Please fill financer representative",
				},
				'data[Finance][registration_no]': {
					required: "Please fill registration no",
				},
				'data[Finance][report_date]': {
					required: "Please fill report date",
					//validDate: "Please fill valid date",
				},
				'data[Finance][make_model]': {
					required: "Please fill make model",
				},
				'data[Finance][inspection_date]': {
					required: "Please fill inspection date",
				},
				'data[Finance][chachees_number]': {
					required: "Please fill chassis number",
				},
				'data[Finance][registration_date]': {
					required: "Please fill registration date",
				},
				'data[Finance][engine_number]': {
					required: "Please fill engine number",
				},
				'data[Finance][color]': {
					required: "Please fill color",
				},
				'data[Finance][registerd_owner]': {
					required: "Please fill registered owner",
				},
				'data[Finance][seating_capacity]': {
					required: "Please fill seating capacity",
				},
				'data[Finance][financed_by]': {
					required: "Please fill finance taken by",
				},
				'data[Finance][laden_wt]': {
					required: "Please fill laden wt",
				},
				'data[Finance][hypothecation]': {
					required: "Please fill hypothecation",
				},
				'data[Finance][unladen_wt]': {
					required: "Please fill unladen wt",
				},
				'data[Finance][fule_used]': {
					required: "Please select fuel used",
				},
				'data[Finance][policy_no]': {
					required: "Please fill policy no",
				},
				'data[Finance][owner_serial_number]': {
					required: "Please fill owner serial number",
				},
				'data[Finance][validity]': {
					required: "Please fill validity",
				},
				'data[Finance][cube_capacity]': {
					required: "Please fill cubic capacity",
				},
				'data[Finance][policy_type]': {
					required: "Please fill policy type",
				},
				'data[Finance][mm_reading]': {
					required: "Please fill mm reading",
				},
				'data[Finance][owner_in_policy]': {
					required: "Please fill owner in policy",
				},'data[Finance][battery]': {
					required: "Please fill battery",
				},
				'data[Finance][sum_insured]': {
					required: "Please fill sum insured",
				},
				'data[Finance][radiator]': {
					required: "Please fill radiator",
				},
				'data[Finance][tax_paid]': {
					required: "Please fill tax paid",
				},
				'data[Finance][ac]': {
					required: "Please fill ac",
				},
				'data[Finance][vechile_condition]': {
					required: "Please fill vechile condition",
				},
				'data[Finance][steereo]': {
					required: "Please fill stereo",
				},
				'data[Finance][major_accidentented]': {
					required: "Please select major accidentented",
				},
				'data[Finance][power_steering]': {
					required: "Please fill power steering",
				},
				'data[Finance][air_bag]': {
					required: "Please fill air bag",
				},
				'data[Finance][power_window]': {
					required: "Please fill power window",
				},
				'data[Finance][general_comment]': {
					required: "Please fill general comment",
				},
				'data[Finance][c_damage]': {
					required: "Please select damages",
				},
				'data[Finance][notice]': {
					required: "Please fill declaration",
				},
				'data[Finance][total_amount]': {
					required: "Please fill total amount",
				},
				'data[Finance][amount_paid]': {
					required: "Please fill amount paid",
				},
				'data[Finance][fair_amount]': {
					required: "Please fill fair amount",
				},
				
			}
		});

	/* $.validator.addMethod("validDate", function(value, element) {
		
        return this.optional(element) || moment(value,"dd/mm/Y").isValid();
    }, "Please enter a valid date in the format dd/mm/Y"); */
	//$("#FinanceCreateForm").validate();
	$(".FinanceRightTyerQuantity1").rules("add", {
        required:true,
         	messages: {
                required: "Fill Quantity"
         	}
    });
	
    //$.validator.addClassRules("FinanceRightTyerCompany1", {
	$(".FinanceRightTyerCompany1").rules("add", {
        required:true,
         	messages: {
                required: "Fill Company"
         	}
    });
    //$.validator.addClassRules("FinanceRightQuality1", {
    $(".FinanceRightQuality1").rules("add", {
		required:true,
         	messages: {
                required: "Fill Company"
         	}
    });

    //$.validator.addClassRules("FinanceLeftTyerQuantity1", {
	$(".FinanceLeftTyerQuantity1").rules("add", {
        required:true,
         	messages: {
                required: "Fill Quantity"
         	}
    });
    //$.validator.addClassRules("FinanceLeftTyerCompany1", {
	$(".FinanceLeftTyerCompany1").rules("add", {
        required:true,
         	messages: {
                required: "Fill Company"
         	}
    });
    //$.validator.addClassRules("FinanceLeftQuality1", {
	$(".FinanceLeftQuality1").rules("add", {
        required:true,
         	messages: {
                required: "Fill Company"
         	}
    });

	/* $.validator.addClassRules("hasDatepicker", {
        validDate:true,
         	messages: {
                validDate: "Fill Actual Date"
         	}
    }); */
	

    /********Green All Filed*******/

	$("#c_damage").change(function(){
		if($(this).val() == "-"){
			$(this).css("background-color", "#93f793");
		}
	});
	$("#FinanceTaxPaid").change(function(){
		if($(this).val() == "-"){
			$(this).css("background-color", "#93f793");
		}
	});





    
	/******* If Check All Field ********/
		$.changeColor("#reference_no");
	$.changeColor("#registrationNumber");
	$.changeColor("#valuation_by");
	$.changeColor("#place_of_valuation");
	$.changeColor("#financer_representative");
	$.changeColor("#mobile_no");
	$.changeColor("#registration_no");
	$.changeColor("#reportDate");
	$.changeColor("#makeModel");
	$.changeColor("#inspectionDate");
	$.changeColor("#chachees_number");
	$.changeColor("#registrationDate");
	$.changeColor("#engine_number");
	$.changeColor("#color");
	$.changeColor("#registerd_owner");
	$.changeColor("#seating_capacity");
	$.changeColor("#financed_by");
	$.changeColor("#laden_wt");
	$.changeColor("#hypothecation");
	$.changeColor("#unladen_wt");
	$.changeColor("#fule_used");
	$.changeColor("#policy_no");
	$.changeColor("#owner_serial_number");
	$.changeColor("#validity");
	$.changeColor("#cube_capacity");
	$.changeColor("#policy_type");
	$.changeColor("#mm_reading");
	$.changeColor("#owner_in_policy");
	$.changeColor("#battery");
	$.changeColor("#sum_inms");
	$.changeColor("#radiator");
	$.changeColor("#tax_paid");
	$.changeColor("#ac");
	$.changeColor("#vechile_condition");
	$.changeColor("#steereo");
	$.changeColor("#major_accidentented");
	$.changeColor("#power_steering");
	$.changeColor("#air_bag");
	$.changeColor("#power_window");
	$.changeColor("#c_engine_condition");
	$.changeColor("#c_cooling_system");
	$.changeColor("#c_suspension_system");
	$.changeColor("#FinanceTaxPaid");
	$.changeColor("#airbag");
	$.changeColor("#general_comment");
	$.changeColor("#FinanceRightTyerQuantity1");
	$.changeColor("#FinanceRightTyerCompany1");
	$.changeColor("#FinanceRightQuality1");
	$.changeColor("#FinanceLeftTyerQuantity1");
	$.changeColor("#FinanceLeftTyerCompany1");
	$.changeColor("#FinanceLeftQuality1");
	$.changeColor("#totalAmount");
	$.changeColor("#paid_amount");
	$.changeColor("#fair_amount");
	$.changeColor("#notice");
	$.changeColor("#c_damage");
	$.changeColor("#amount_paid");
	$.changeColor("#paid_person");
	$.changeColor("#QueryArea");
	$.changeColor("#QueryName");
	$.changeColor("#QueryMobile");
	$.changeColor("#QueryAddress");
	$.changeColor("#QueryRegistration");
	$.changeColor("#QueryPayment");
	$.changeColor("#paid_date");

	

	/********* If uncheck all filed **********/
	$.uncheckFieldColor("#reference_no");
	$.uncheckFieldColor("#registrationNumber");
	$.uncheckFieldColor("#valuation_by");
	$.uncheckFieldColor("#place_of_valuation");
	$.uncheckFieldColor("#financer_representative");
	$.uncheckFieldColor("#mobile_no");
	$.uncheckFieldColor("#registration_no");
	$.uncheckFieldColor("#reportDate");
	$.uncheckFieldColor("#makeModel");
	$.uncheckFieldColor("#inspectionDate");
	$.uncheckFieldColor("#chachees_number");
	$.uncheckFieldColor("#registrationDate");
	$.uncheckFieldColor("#engine_number");
	$.uncheckFieldColor("#color");
	$.uncheckFieldColor("#registerd_owner");
	$.uncheckFieldColor("#seating_capacity");
	$.uncheckFieldColor("#financed_by");
	$.uncheckFieldColor("#laden_wt");
	$.uncheckFieldColor("#unladen_wt");
	$.uncheckFieldColor("#fule_used");
	$.uncheckFieldColor("#policy_no");
	$.uncheckFieldColor("#owner_serial_number");
	$.uncheckFieldColor("#validity");
	$.uncheckFieldColor("#cube_capacity");
	$.uncheckFieldColor("#policy_type");
	$.uncheckFieldColor("#mm_reading");
	$.uncheckFieldColor("#owner_in_policy");
	$.uncheckFieldColor("#battery");
	$.uncheckFieldColor("#sum_inms");
	$.uncheckFieldColor("#radiator");
	$.uncheckFieldColor("#tax_paid");
	$.uncheckFieldColor("#ac");
	$.uncheckFieldColor("#vechile_condition");
	$.uncheckFieldColor("#steereo");
	$.uncheckFieldColor("#major_accidentented");
	$.uncheckFieldColor("#power_steering");
	$.uncheckFieldColor("#air_bag");
	$.uncheckFieldColor("#power_window");
	$.uncheckFieldColor("#c_engine_condition");
	$.uncheckFieldColor("#c_cooling_system");
	$.uncheckFieldColor("#c_suspension_system");
	$.uncheckFieldColor("#hypothecation");
	$.uncheckFieldColor("#FinanceTaxPaid");
	$.uncheckFieldColor("#airbag");
	$.uncheckFieldColor("#general_comment");
	$.uncheckFieldColor("#FinanceRightTyerQuantity1");
	$.uncheckFieldColor("#FinanceRightTyerCompany1");
	$.uncheckFieldColor("#FinanceRightQuality1");
	$.uncheckFieldColor("#FinanceLeftTyerQuantity1");
	$.uncheckFieldColor("#FinanceLeftTyerCompany1");
	$.uncheckFieldColor("#FinanceLeftQuality1");
	$.uncheckFieldColor("#totalAmount");
	$.uncheckFieldColor("#paid_amount");
	$.uncheckFieldColor("#fair_amount");
	$.uncheckFieldColor("#notice");
	


	var reference_no = $("#reference_no").val();
	if(reference_no == "-"){
		$("#reference_no").css("background-color", "#f397976b")
	}
	var mobile_no = $("#mobile_no").val();
	if(mobile_no == ""){
		$("#mobile_no").css("background-color", "#97e6f3")
	}
	var FinanceTaxPaid = $("#FinanceTaxPaid").val();
	if(FinanceTaxPaid == "-"){
		$("#FinanceTaxPaid").css("background-color", "#93f793")
	}
	var ac = $("#ac").val();
	if(ac == ""){
		$("#ac").css("background-color", "#f397976b")
	}

	var steereo = $("#steereo").val();
	if(steereo == ""){
		$("#steereo").css("background-color", "#f397976b")
	}

	var power_steering = $("#power_steering").val();
	if(power_steering == ""){
		$("#power_steering").css("background-color", "#f397976b")
	}

	var power_window = $("#power_window").val();
	if(power_window == ""){
		$("#power_window").css("background-color", "#f397976b")
	}

	var airbag = $("#airbag").val();
	if(airbag == ""){
		$("#airbag").css("background-color", "#f397976b")
	}

	var general_comment = $("#general_comment").val();
	if(general_comment == "-"){
		$("#general_comment").css("background-color", "#93f793")
	}

	var c_damage = $("#c_damage").val();
	if(c_damage == "-"){
		$("#c_damage").css("background-color", "#93f793")
	}

	var valuation_by = $("#valuation_by").val();
	if(valuation_by == ""){
		$("#valuation_by").css("background-color", "#97e6f3");
	}

	var place_of_valuation = $("#place_of_valuation").val();
	if(place_of_valuation == ""){
		$("#place_of_valuation").css("background-color", "#97e6f3");
	}

	var financer_representative = $("#financer_representative").val();
	if(financer_representative == ""){
		$("#financer_representative").css("background-color", "#97e6f3");
	}

	/* var mobile_no = $("#mobile_no").val();
	if(mobile_no == "-"){
		$("#mobile_no").css("background-color", "#97e6f3");
	} */

	var reportDate = $("#reportDate").val();
	if(reportDate == ""){
		$("#reportDate").css("background-color", "#97e6f3");
	}

	var inspectionDate = $("#inspectionDate").val();
	if(inspectionDate == ""){
		$("#inspectionDate").css("background-color", "#97e6f3");
	}

	var financed_by = $("#financed_by").val();
	if(financed_by == ""){
		$("#financed_by").css("background-color", "#97e6f3");
	}

	var mm_reading = $("#mm_reading").val();
	if(mm_reading == ""){
		$("#mm_reading").css("background-color", "#97e6f3");
	}

	var battery = $("#battery").val();
	if(battery == ""){
		$("#battery").css("background-color", "#97e6f3");
	}

	var radiator = $("#radiator").val();
	if(radiator == ""){
		$("#radiator").css("background-color", "#97e6f3");
	}


	var ac = $("#ac").val();
	if(ac == ""){
		$("#ac").css("background-color", "#97e6f3");
	}

	var steereo = $("#steereo").val();
	if(steereo == ""){
		$("#steereo").css("background-color", "#97e6f3");
	}

	var power_steering = $("#power_steering").val();
	if(power_steering == ""){
		$("#power_steering").css("background-color", "#97e6f3");
	}

	var airbag = $("#airbag").val();
	if(airbag == ""){
		$("#airbag").css("background-color", "#97e6f3");
	}

	var power_window = $("#power_window").val();
	if(power_window == ""){
		$("#power_window").css("background-color", "#97e6f3");
	}

	var major_accidentented = $("#major_accidentented").val();
	if(major_accidentented == "-"){
		$("#major_accidentented").css("background-color", "#97e6f3");
		//$("#major_accidentented").css("background-color", "#93f793");
	}

	var vechile_condition = $("#vechile_condition").val();
	if(vechile_condition == "Good"){
		$("#vechile_condition").css("background-color", "#93f793");
	}

	/* var c_damage = $("#c_damage").val();
	if(c_damage == "-"){
		$("#c_damage").css("background-color", "#93f793");
	}

	var general_comment = $("#general_comment").val();
	if(general_comment == "-"){
		$("#general_comment").css("background-color", "#97e6f3");
	} */

	var amount_paid = $("#amount_paid").val();
	if(amount_paid == ""){
		$("#amount_paid").css("background-color", "#97e6f3");
	}
	var paid_person = $("#paid_person").val();
	if(paid_person == ""){
		$("#paid_person").css("background-color", "#97e6f3");
	}
	var paid_date = $("#paid_date").val();
	if(paid_date == ""){
		$("#paid_date").css("background-color", "#97e6f3");
	}
	

	var FinanceRightTyerQuantity1 = $("#FinanceRightTyerQuantity1").val();
	if(FinanceRightTyerQuantity1 == ""){
		$("#FinanceRightTyerQuantity1").css("background-color", "#97e6f3");
	}
	var FinanceRightTyerCompany1 = $("#FinanceRightTyerCompany1").val();
	if(FinanceRightTyerCompany1 == ""){
		$("#FinanceRightTyerCompany1").css("background-color", "#97e6f3");
	}
	var FinanceRightQuality1 = $("#FinanceRightQuality1").val();
	if(FinanceRightQuality1 == ""){
		$("#FinanceRightQuality1").css("background-color", "#97e6f3");
	}
	var FinanceLeftTyerQuantity1 = $("#FinanceLeftTyerQuantity1").val();
	if(FinanceLeftTyerQuantity1 == ""){
		$("#FinanceLeftTyerQuantity1").css("background-color", "#97e6f3");
	}
	var FinanceLeftTyerCompany1 = $("#FinanceLeftTyerCompany1").val();
	if(FinanceLeftTyerCompany1 == ""){
		$("#FinanceLeftTyerCompany1").css("background-color", "#97e6f3");
	}
	var FinanceLeftQuality1 = $("#FinanceLeftQuality1").val();
	if(FinanceLeftQuality1 == ""){
		$("#FinanceLeftQuality1").css("background-color", "#97e6f3");
	}

	var totalAmount = $("#totalAmount").val();
	if(totalAmount == ""){
		$("#totalAmount").css("background-color", "#97e6f3");
	}

	var paid_amount = $("#paid_amount").val();
	if(paid_amount == ""){
		$("#paid_amount").css("background-color", "#97e6f3");
	}

	var ramining_amount = $("#ramining_amount").val();
	if(ramining_amount == ""){
		$("#ramining_amount").css("background-color", "#97e6f3");
	}

	var fair_amount = $("#fair_amount").val();
	if(fair_amount == ""){
		$("#fair_amount").css("background-color", "#97e6f3");
	}

	var notice = $("#notice").val();
	if(notice == ""){
		$("#notice").css("background-color", "#97e6f3");
	}
	
	/*$("#crop_div").on('drag', function(){
		var posi = document.getElementById('crop_div');
    	document.getElementById("top").value=posi.offsetTop;
        document.getElementById("left").value=posi.offsetLeft;
        document.getElementById("right").value=posi.offsetWidth;
        document.getElementById("bottom").value=posi.offsetHeight;
	});*/
	/*$( "#crop_div" ).draggable({ 
			containment: "parent",
	});*/


	$(".addMoreImage").click(function(){
		$(".moreImages").parent().append('<div class="col-md-4" style="margin-top:35px;"> <div class="fileUpload btn btn-primary"><input type="file" name="data[Finance][photo1][]" class="upload uploadBtn" accept="image/*" data-value="30" id="FinanceChacheesNumberPhoto"> <div></div>');
	});

	$("#FinanceChacheesNumberPhoto").change(function(){
		$('.imageCounter_30').imgAreaSelect({ 
                aspectRatio: '1:1', 
                handles: true,
                persistent: true,
                x1: 72, y1: 5, x2: 360, y2: 293,
                //onInit: preview,
                onSelectChange: preview, 
                onSelectEnd: function ( image, selection ) {
                    $('.x1').val(selection.x1); 
                    $('.y1').val(selection.y1); 
                    $('.x2').val(selection.x2); 
                    $('.y2').val(selection.y2);
                    $('.w').val(selection.width);
                    $('.h').val(selection.height);  
                } 
            });
	});

});


function preview(img, selection) { 
            var scaleX = 200 / (selection.width || 1); 
            var scaleY = 200 / (selection.height || 1); 
            $('#FinanceChacheesNumberPhoto + div > img').css({ 
                width: Math.round(scaleX * 400) + 'px', 
                height: Math.round(scaleY * 400) + 'px', 
                marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
                marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
            }); 
        } 
/*unction PrintDiv() {
	   var divToPrint = document.getElementById('divToPrint');
	   var popupWin = window.open('Print Finance', '', 'width=1000,height=300');
	   $(".heading").attr("style", "border-radius: 15px; text-align:center; border:1px solid #e2d7d7; padding:20px;");
	   $(".user_img").children("img").attr("style", "width:50%;");
	   popupWin.document.open();
	   popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
	   popupWin.document.close();
	}*/
	
	
	/******* Remove image ********/
function removeimage(id ,name, removeClass){
	$.ajax( {
			  url: window.basePath+window.site_base+'/finances/removePhoto',
			  type: "POST",
			  data: {id: id, name: name},
			  success: function( data ) { 
			  		if(data == 1){
			  			$(".user_img"+removeClass).children().remove();
			  			$(".checkBoxImage"+removeClass).remove();
			  			$("#oldImagesReport"+removeClass).remove();
			  			//$(".user_img"+removeClass).append("<div class='fileUpload btn btn-primary'><input type='file' class='upload uploadBtn' name='data[Finance][photo1][]' id='FinanceChacheesNumberPhoto'/></div>")
			  		}
			  }
			});
}

function removeChassisImage(id ,name, removeClass){
	$.ajax( {
			  url: window.basePath+window.site_base+'/finances/removeChassisPhoto',
			  type: "POST",
			  data: {id: id, name: name},
			  success: function( data ) { 
			  		if(data == 1){
			  			//alert("#"+removeClass);
						
			  			$("#UpdateImage").html("<div class='fileUpload btn btn-primary'><input type='file' class='upload uploadBtn' name='data[Finance][chachees_number_photo]' accept='image/*' data-value='30' onclick='uploadNewChassisImage();' /></div>")
			  			$("#"+removeClass).parent().removeClass('col-md-4');
			  			$("#"+removeClass).parent().addClass('col-md-2');
			  			$("#"+removeClass).children().remove();
			  			$("#"+removeClass).html('<img src="/img/no-image.png" onmouseover="cropImage();" class="img-responsive imageCounter_30" data-value="30" >');
			  			$("#imguser").attr("style", "width:248%");
			  			$("#imguser").append("<div id='crop_div' ></div>");
			  		}
			  }
			});
}

function PrintDiv() {
	   var divToPrint = document.getElementById('divToPrint');
	   var popupWin = window.open('Print Finance', '', 'width=1000,height=300');
	   $(".heading").attr("style", "border-radius: 15px; text-align:center; border:1px solid #e2d7d7; padding:20px;");
	   $(".user_img").children("img").attr("style", "width:50%;");
	   popupWin.document.open();
	   popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
	   popupWin.document.close();
	}

function uploadNewChassisImage(){
	$(".uploadBtn").change(function(){
        readURL(this, $(this).attr("data-value"));

    });
}


function readURL(input, number) {
	//alert(input.files);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('.imageCounter_'+number).attr('src', e.target.result);
        	$('.imageCounter_'+number).attr('width', "89%");
    	}
		reader.readAsDataURL(input.files[0]);
    }
}
    
function cropImage(){
	/* $( "#crop_div" ).draggable({ 
			containment: "imageCounter_30",
	});
//$("#crop_div").on('drag', function(){
		var posi = document.getElementById('crop_div');
    	document.getElementById("top").value=posi.offsetTop;
        document.getElementById("left").value=posi.offsetLeft;
        document.getElementById("right").value=posi.offsetWidth;
        document.getElementById("bottom").value=posi.offsetHeight;
//	}); */
	$('.imageCounter_30').imgAreaSelect({ 
                aspectRatio: '1:1', 
                handles: true,
                persistent: true,
                x1: 72, y1: 5, x2: 360, y2: 293,
                //onInit: preview,
                onSelectChange: preview, 
                onSelectEnd: function ( image, selection ) {
                    $('.x1').val(selection.x1); 
                    $('.y1').val(selection.y1); 
                    $('.x2').val(selection.x2); 
                    $('.y2').val(selection.y2);
                    $('.w').val(selection.width);
                    $('.h').val(selection.height);  
                } 
            });
}