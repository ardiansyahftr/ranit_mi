@extends('master')

@section('title-navbar','Schedule')

@section('title','SCHEDULE')

@section('active-schedule','active')

@section('content')
<div class="col-md-12">
  <div class="card ">
    <div class="card-header card-header-rose card-header-text">
      <div class="card-text">
        <h4 class="card-title">Add Schedule</h4>
      </div>
    </div>
    <div class="card-body ">
      <form method="post" id="save_schedule" class="form-horizontal" enctype="multipart/form-data">        

        <div class="row">
          <label class="col-sm-2 col-form-label">Category</label>
          <div class="col-sm-5">
            <div class="form-group">
              <select name="category" class="form-control selectpicker" data-style="btn btn-link" id="category">                            
                <option value="" disabled="" selected=""> --Category-- </option>                
                @foreach($category as $ctrg)
                <option value="{{$ctrg->id}}">{{$ctrg->category}}</option>
                @endforeach
              </select> 
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group">
              <select name="category" class="form-control selectpicker" data-style="btn btn-link" id="category">                            
                <option value="" disabled="" selected=""> --Vechile-- </option>                
                @foreach($category as $ctrg)
                <option value="{{$ctrg->id}}">{{$ctrg->category}}</option>
                @endforeach
              </select> 
            </div>
          </div>
        </div>
    
        <div class="row">
          <label class="col-sm-2 col-form-label">Date</label>
          <div class="col-sm-5">
            <div class="form-group">
              <input name="date" type="text" class="form-control datepicker" value=""  placeholder="Date">
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group">
              <input name="status_km" id="status_km" type="text" class="form-control" value="" placeholder="Status KM (Speedometer)">
            </div>
          </div>
        </div>

        <div class="row">
          <label class="col-sm-2 col-form-label">Time Depart</label>
          <div class="col-sm-5">
            <div class="form-group">
              <input name="time_depart" id="time_depart" type="text" class="form-control timepicker" value="" placeholder="Time Depart">
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group">
              <input name="arrival" id="arrival" type="text" class="form-control timepicker" value="" placeholder="EST. Arrival">
            </div>
          </div>
        </div>

        <div class="row">
          <label class="col-sm-2 col-form-label">From</label>
          <div class="col-sm-5">
            <div class="form-group">
              <input name="from" id="from" type="text" class="form-control" value="" placeholder="From">
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-group">
              <input name="to" id="to" type="text" class="form-control" value="" placeholder="To">
            </div>
          </div>
        </div>

        <div class="row">
          <label class="col-sm-2 col-form-label">Request</label>
          <div class="col-sm-10">
            <div class="form-group">
              <input name="request" id="request" type="text" class="form-control" value="" placeholder="Request">
            </div>
          </div>
        </div>        
        
        <div class="card-footer">
        <div class="row">
          <div class="col-sm-12">
            <a onclick="save_data()" class="btn btn-fill btn-rose" style="color: white">Save</a>
            <a href="">
              <button class="btn btn-fill btn-rose">Cancel</button>
            </a>
          </div>
        </div>
      </div>      
      </form>
    </div>
  </div>
</div>

@endsection

@section('js')
<script>
 function save_data() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "",
        processData: false,
        contentType : false,
        data: new FormData($('#save_pallet')[0]),
        type: 'post',
        success: function (result) {    
            if (result == 'sukses') {               
                $.notify({
                  icon: "notification_important",
                  message: "Data Added Successfully"

                }, {
                  type: "success",
                  timer: 3000,
                  placement: {
                    from: "top",
                    align: "center"
                  }
                });
                location.href="";
            }else{                
                $.notify({
                  icon: "notification_important",
                  message: "Data Added Failed"

                }, {
                  type: "danger",
                  timer: 3000,
                  placement: {
                    from: "top",
                    align: "center"
                  }
                });
            }
        },
        error : function (data) {        
            $.notify(data, "error");
        }
    })
}
</script>
@endsection