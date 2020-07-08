<!-- First you need to extend the CB layout -->
@extends('master')

@section('title-navbar','Management Project')

@section('title','Management Project')

@section('active-project','active')

@section('show-master','show')

@section('content')
<!-- Your custom  HTML goes here -->
<style type="text/css">
    th{
        text-align: center;
        font-size:14px;
    }
    td{
        font-size:14px;
    }
</style>
<style>
    
    .tab-space {
    padding: 20px 0 0px 0px;
}
    .col-form-label{
        padding: 10px 5px 0 0 !important;
        text-align: right;
    }.form-inline .bootstrap-select, .form-horizontal .bootstrap-select, .form-group .bootstrap-select {
        margin-bottom: 0;
        padding: 0px !important;
    }
    .bootstrap-select .btn.dropdown-toggle.select-with-transition {
        padding-left: 1px !important;
    }
</style>
<ul class="nav nav-pills nav-pills-info" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist" aria-expanded="true">
            List Project
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#link2" role="tablist" aria-expanded="false">
            New Project
        </a>
    </li>
    <li class="nav-item" id="id_Project_tab">
        <a class="nav-link" data-toggle="tab" href="#link4" role="tablist" aria-expanded="false">
            Edit Project
        </a>
    </li>
    <li class="nav-item" hidden="">
        <a class="nav-link" data-toggle="tab" href="#link3" role="tablist" aria-expanded="false">
            Report
        </a>
    </li>
</ul>
<div class="tab-content tab-space">
    <div class="tab-pane active" id="link1" aria-expanded="true">
        
    </div>
    <div class="tab-pane" id="link2" aria-expanded="false">
        <form autocomplete='off' action="{{ route('saveAddProject') }}" enctype="multipart/form-data" method="post" id="form-input">
        {{ csrf_field() }}
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-icon card-header-info">
                  <div class="card-icon">
                    <i class="material-icons">perm_identity</i>
                  </div>
                  <h4 class="card-title">Add Project
                  </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Project Name</label>
                          <input type="text" class="form-control" value="" name="name" required="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <select name="status" id="status" class="selectpicker col-md-12" data-style="select-with-transition">
                                <option value="">Status</option>
                                @foreach ($project_status as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="inputState">Start Date</label>
                          <input type="text" class="form-control datepicker" value="{{date('Y-m-d')}}" name="start_date" id="start_date">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="inputState">Deadline</label>
                          <input type="text" class="form-control datepicker" value="{{date('Y-m-d')}}" name="deadline" id="deadline">
                        </div>
                      </div>
                    </div>
                    <div class="user-form">
                      
                    </div>
                    <div class="row">
                      <br>
                    </div>
                    <button type="submit" class="btn btn-info pull-right">Save</button>
                    <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>
      </form>
    </div>
    <div class="tab-pane" id="link4" aria-expanded="false">
        <form autocomplete='off' action="{{ route('editProject') }}" enctype="multipart/form-data" method="post">
{{ csrf_field() }}
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-icon card-header-info">
                  <div class="card-icon">
                    <i class="material-icons">perm_identity</i>
                  </div>
                  <h4 class="card-title">
                    <div class="row">
                      <div class="col-6" style="padding: 0;">
                        Project Code : <label for="" class="label label-primary" id="edit_code_project" style="font-size: 1em; font-weight: bolder"></label>
                      </div>
                      <div class="col-6" style="padding: 0; text-align: right;">
                        PM : <label for="" class="label label-primary" id="edit_pm_name" style="font-size: 1em; font-weight: bolder">Nama</label>
                      </div>
                    </div>

                  </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Project Name</label>
                          <input type="text" class="form-control" value="" name="name" id="edit_name" required="">
                          <input type="hidden" class="form-control" name="id" value="" id="edit_id">
                          <!-- <input type="hidden" class="form-control" name="privilege" value="2" name="privilege"> -->
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <select name="status" id="edit_status" class="selectpicker col-md-12" data-style="select-with-transition">
                                <option value="">Status</option>
                                @foreach ($project_status as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="inputState">Start Date</label>
                          <input type="text" class="form-control datepicker" value="" name="start_date" id="edit_start_date">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="inputState">Deadline</label>
                          <input type="text" class="form-control datepicker" value="" name="deadline" id="edit_deadline">
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-info pull-right">Update</button>
                    <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>
      </form>
    </div>
    <div class="tab-pane" id="link3" aria-expanded="false">

    </div>
</div>
  <div class="card">
    <div class="card-header card-header-info card-header-icon">
      <div class="card-icon">
        <i class="material-icons">assignment</i>
      </div>
      <h4 class="card-title">List Project <!-- 
        <a href="{{asset('admin/master/user/add')}}" id='btnAdd' class="btn btn-sm btn-primary pull-right" title="Add Order" >
            <i class="fa fa-plus-circle"></i> Add Project
        </a> -->
      </h4>
    </div>
    <div class="card-body">
      <div class="toolbar">
        <!--        Here you can write extra buttons/actions for the toolbar              -->
      </div>
      <div class="material-datatables">
        <table id="" class="table datatables" cellspacing="0" width="100%" style="width:100%">
            <thead class="text-center">
                <tr>
                    <th width="30">#</th>
                    <th>Project Code</th>
                    <th>Project Name</th>
                    <th>Start Date</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th width="15%" align="right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($result as $row)
                
                <tr>
                    <td align="center"><?php echo $no; $no++; ?></td>
                    <td align="">{{$row->code_project}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->start_date}}</td>
                    <td>{{($row->deadline)}}</td>
                    <th>{{($row->status_name)}}</th>
                    <td align="right"><!-- 
                        <a class="btn btn-link btn-just-icon btn-info btn-detail" title="View Data" href="{{asset('admin/master/user/edit/'.$row->id)}}"><i class="fa fa-eye"></i></a> --><!-- 
                        <a class="btn btn-link btn-just-icon btn-success btn-detail" title="Edit Data" href="{{asset('admin/master/user/edit/'.$row->id)}}"><i class="fa fa-pencil"></i></a> -->
                        <button onclick="get_data({{$row->id}})" type="button" class="btn btn-link btn-just-icon btn-primary btn-edit" data-original-title="Edit Data" title="Edit Data">
                            <i class="material-icons">edit</i>
                        </button>
                        <a class="btn btn-link btn-just-icon btn-danger btn-delete" title="Delete" href="javascript:void(0);" onclick="swal({   
                        title: 'Are you sure to delete this Project ?',   
                        // text: 'You will not be able to recover this record data!',   
                        type: 'warning',   
                            showCancelButton: true,   
                            confirmButtonText: 'Yes!', 
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            cancelButtonText: 'No',  
                            closeOnConfirm: false,
                            buttonsStyling: false
                        }).then (function (result) {

                        if (result.hasOwnProperty('dismiss')) {
                          return;
                        }else{
                          location.href='{{asset('admin/project/delete/'.$row->id)}}'
                        }

                        });"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
    <!-- end content-->
  </div>
    

<!-- ADD A PAGINATION -->
@endsection
<style>
    .panel{
        
    }
    .small-box{
        background-color: #1f4e79;
        color: aliceblue;
    
    }
    
    .col-md-2{
    background:#1f4e79;
    color:#FFF;
    margin-bottom: 1%;
    border-radius: 7.5%;      
    }
    .col-half-offset{
        margin-left:2.7%
    
    }
    .small-box p{
        font-size: 11px !important;
    }
    .table-responsive{
        min-height: .01%;
        overflow-x: hidden !important;
    }
    
    @media only screen and (max-width: 600px){
        .table-responsive{
            min-height: .01%;
            overflow-x: scroll !important;
        }
    }
    
    @media only screen and (max-width: 30px){
        .col-xs-5{
            width: 44.666667%;
        }
    }
    
</style>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>
$(document).ready(function() {
$('#id_Project_tab').hide();
    $('#table').DataTable({
        responsive: true,
        info: false
    });
} );
function get_data(id) {
$('#myTab li:nth-child(3) a').tab('show') // Select third tab
$('#id_Project_tab').show();
 $.ajax({
    url    : "{{route('ajaxEditProject')}}",
    method : "GET",
    data   : {
                id : id
            },
    type   : "json",
    success: function (data) {      
      console.log(data);
      var base_url = window.location.origin + '/cms_nps/';
      $('#edit_code_project').text(data.ajax_project.code_project);
      $('#edit_pm_name').text(data.ajax_project.pm_name);
      $('#edit_id').val(data.ajax_project.id);
      $('#edit_name').val(data.ajax_project.name).trigger("change");
      $('#edit_status').selectpicker('val', data.ajax_project.status);
      $('#edit_start_date').val(data.ajax_project.start_date).trigger("change");
      $('#edit_deadline').val(data.ajax_project.deadline).trigger("change");
      
      // $('#edit_liter').val(data.ajax_po.liter)      
    }  
  })
}
</script>

<script type="text/javascript">
    
</script>

