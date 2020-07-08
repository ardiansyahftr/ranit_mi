@extends('master')

@section('title-navbar','Dashboard')

@section('title','DASHBOARD')

@section('active-dashboard','active')

@section('content')
<style>
    th{
        text-align:center;
        font-size:14px;
    }
    td{
        font-size:14px;
    }
@media (max-width: 767px){
#bar-chart-1{
    height: 5;
}
#bar-chart-1{
    height: 10;
}
}

.info-box-icon{
    padding-top: 10%;
}
</style>

<!-- Your custom  HTML goes here -->

@include('Info_Boxes.info_boxes')
    <div class="row" >
      <!-- /.row -->
        <div class="col-lg-12 col-xs-12">
            <div class="card">
                <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                      <i class="material-icons">insert_chart</i>
                    </div>
                    <h4 class="card-title">
                        Graph Order per Month
                    </h4>
                </div>
                <div class="card-body">
                    <div id=canvas_pan class="panel-body" >
                        <canvas id="bar-chart-1" width="29" height="150"></canvas>
                    </div>
                    <div class="ct-chart ct-perfect-fourth" id="chart1" hidden=""></div>
                </div>
            </div>
        </div>
    </div>
  <div class="card">
    <div class="card-header card-header-info card-header-icon">
      <div class="card-icon">
        <i class="material-icons">assignment</i>
      </div>
      <h4 class="card-title">List PO</h4>
    </div>
    <div class="card-body">
      <div class="toolbar">
        <!--        Here you can write extra buttons/actions for the toolbar              -->
      </div>
    </div>
    <!-- end content-->
  </div>
  <!--  end card  -->
<!-- ADD A PAGINATION -->

</script>
@endsection

@section('js')
<script>

</script>
@endsection