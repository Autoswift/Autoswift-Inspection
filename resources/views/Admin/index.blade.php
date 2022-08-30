@extends('Admin.layout')
@section('content')   
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="{{route('mobile_home')}}">Home</a> <i class="fa fa-angle-right"></i>Dashboard</li>
</ol>
<!--four-grids here-->
<div class="four-grids">
   <div class="col-md-3 four-grid">
      <div class="four-agileits" style="background-color:#f7bd1a">
         <div class="icon">
            <i class="glyphicon fa fa-clock-o" aria-hidden="true"></i>
         </div>
         <a href="{{route('reports')}}?status=pending">
            <div class="four-text">
               <h3>Pending</h3>
               <h4 id="pending">{{$all['pending']}}</h4>
            </div>
         </a>
      </div>
   </div>
   <div class="col-md-3 four-grid">
      <div class="four-agileits">
         <div class="icon">
            <i class="glyphicon fa fa-ban" aria-hidden="true"></i>
         </div>
         <a href="{{route('rejected_reports')}}">
            <div class="four-text">
               <h3>Rejected</h3>
               <h4 id="completed">{{$all['rejected']}}</h4>
            </div>
         </a>
      </div>
   </div>
   <div class="col-md-3 four-grid">
      <div class="four-agileinfo">
         <div class="icon">
            <i class="glyphicon fa fa-check" aria-hidden="true"></i>
         </div>
         <a href="{{route('reports')}}?status=approve">
            <div class="four-text">
               <h3>Approved</h3>
               <h4 id="approved">{{$all['approve']}}</h4>
            </div>
         </a>
      </div>
   </div>
   <div class="col-md-3 four-grid">
      <div class="four-w3ls">
         <div class="icon">
            <i class="glyphicon  fa fa-check-circle" aria-hidden="true"></i>
         </div>
         <a href="{{route('reports')}}?status=complete">
            <div class="four-text">
               <h3>Completed</h3>
               <h4 id="completed">{{$all['complete']}}</h4>
            </div>
         </a>
      </div>
   </div>
   
   <div class="clearfix"></div>
</div>
<div class="w3-agileits-pane">
   <div class="charts">
      <div class="col-md-12 w3layouts-char">
         <div class="charts-grids widget">
            <h4 class="title">File Chart</h4>
            <canvas id="bar"> </canvas>
         </div>
      </div>
      <div class="clearfix"> </div>
      <script></script>
   </div>
   <div class="col-md-4 wthree-pan">
      <div class="panel panel-default">
         <!-- /.panel-heading -->
         <!-- /.panel-body --> 
      </div>
   </div>
   <div class="col-md-8 agile-info-stat">
   </div>
   <div class="clearfix"></div>
</div>
@endsection
@section('script') 
<script type="text/javascript">
   $(document).ready(function(){
      $( ".pickadate" ).datepicker({
          dateFormat: 'dd-mm-yy', 
      });
      $( ".pickadate" ).prop('autocomplete','off');
      var data=[]
      var labels=[]
      xdata=JSON.parse("{{$reports}}".replace(/&quot;/g,'"'));
      $.each(xdata, function( index, value ) {
            data.push(value.count)
            labels.push(GetMonthName(value.month))
      });
                  var barChartData = {
            labels : labels,
            datasets : [
                     {
                        fillColor : "rgb(199, 54, 39)",
                        strokeColor : "rgba(233, 78, 2, 0.9)",
                        highlightFill: "#e74c3c",
                        highlightStroke: "#e74c3c",
                        data : data
                     }
                  ]
                  
               };
               
            new Chart(document.getElementById("bar").getContext("2d")).Bar(barChartData);
   
                        
   function GetMonthName(monthNumber) {
   
      var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      return months[monthNumber - 1];
   
      }
   })
   
</script>
@endsection