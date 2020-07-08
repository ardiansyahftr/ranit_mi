<!-- First you need to extend the CB layout -->
@extends('master')

@section('title-navbar','Management Ticket')

@section('title','Management Ticket')

@section('active-ticket','active')

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
            List Ticket
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#link2" role="tablist" aria-expanded="false">
            New Ticket
        </a>
    </li>
    <li class="nav-item" id="id_Ticket_tab">
        <a class="nav-link" data-toggle="tab" href="#link4" role="tablist" aria-expanded="false">
            Edit Ticket
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
        <form autocomplete='off' action="{{ route('saveAddTicket') }}" enctype="multipart/form-data" method="post" id="form-input">
        {{ csrf_field() }}
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-icon card-header-info">
                  <div class="card-icon">
                    <i class="material-icons">perm_identity</i>
                  </div>
                  <h4 class="card-title">Add Ticket
                  </h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <select name="project" id="project" class="selectpicker col-md-12" data-style="select-with-transition">
                                  <option value="">-- Project --</option>
                                  @foreach ($project as $item)
                                      <option value="{{$item->id}}">{{$item->code_project}} - {{$item->name}}</option>
                                  @endforeach
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <select name="priority" id="priority" class="selectpicker col-md-12" data-style="select-with-transition">
                                  <option value="">-- Priority --</option>
                                  @foreach ($priority as $item)
                                      <option value="{{$item->id}}"><span class='badge badge-{{$item->type}}'>{{$item->name}}</span></option>
                                  @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="inputState">Deadline</label>
                            <input type="text" class="form-control datepicker" value="{{date('Y-m-d')}}" name="deadline" id="deadline">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="material-datatables">
                        <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead class="text-center">
                                <tr>
                                    <th>Image/Video</th>
                                    <th>Bug Description</th>
                                    <th>Priority</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="bug_row">

                            </tbody>
                              <tr>
                                <td colspan="4">
                                  <div id="btn-paket" class="btn btn-success btn-block" onclick="addBug()">
                                    Tambah
                                  </div>
                                </td>
                              </tr>
                        </table>
                        <input type="hidden" name="typeBug" id="countTypeBug" value="0">
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
        <form autocomplete='off' action="{{ route('editTicket') }}" enctype="multipart/form-data" method="post">
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
                        Ticket Code : <label for="" class="label label-primary" id="edit_code_ticket" style="font-size: 1em; font-weight: bolder"></label>
                      </div>
                      <div class="col-6" style="padding: 0; text-align: right;">
                        Reported By : <label for="" class="label label-primary" id="edit_tester_name" style="font-size: 1em; font-weight: bolder">Nama</label>
                      </div>
                    </div>

                  </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <input type="hidden" class="form-control" name="id" value="" id="edit_id">
                              <input type="hidden" class="form-control" name="code_ticket" value="" id="edit_code_ticket_h">
                              <select name="project" id="edit_project" class="selectpicker col-md-12" data-style="select-with-transition" required="">
                                    <option value="">-- Project --</option>
                                    @foreach ($project as $item)
                                        <option value="{{$item->id}}">{{$item->code_project}} - {{$item->name}}</option>
                                    @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <select name="priority" id="edit_priority" class="selectpicker col-md-12" data-style="select-with-transition" required="">
                                    <option value="">-- Priority --</option>
                                    @foreach ($priority as $item)
                                        <option value="{{$item->id}}"><span class='badge badge-{{$item->type}}'>{{$item->name}}</span></option>
                                    @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="inputState">Deadline</label>
                              <input type="text" class="form-control datepicker" value="" name="deadline" id="edit_deadline" required="">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="material-datatables">
                          <table id="" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                              <thead class="text-center">
                                  <tr>
                                      <th>Image/Video</th>
                                      <th>Bug Description</th>
                                      <th>Priority</th>
                                      <th width="10%">Action</th>
                                  </tr>
                              </thead>
                              <tbody id="edit_bug_row">

                              </tbody>
                                <tr>
                                  <td colspan="4">
                                    <div id="btn-paket" class="btn btn-success btn-block" onclick="edit_addBug()">
                                      Tambah
                                    </div>
                                  </td>
                                </tr>
                          </table>
                          <input type="hidden" name="typeBug" id="edit_countTypeBug" value="0">
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
      <h4 class="card-title">List Ticket <!-- 
        <a href="{{asset('admin/master/user/add')}}" id='btnAdd' class="btn btn-sm btn-primary pull-right" title="Add Order" >
            <i class="fa fa-plus-circle"></i> Add Ticket
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
                    <th>Ticket Code</th>
                    <th>Project Code</th>
                    <th>Project Name</th>
                    <th>Reported at</th>
                    <th>Deadline</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th width="15%" align="right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($result as $row)
                
                <tr>
                    <td align="center"><?php echo $no; $no++; ?></td>
                    <td align="">{{$row->code_ticket}}</td>
                    <td>{{$row->code_project}}</td>
                    <td>{{$row->project_name}}</td>
                    <td>{{$row->created_at}}</td>
                    <td>{{($row->deadline)}}</td>
                    <th><label class="btn btn-{{$row->priority_type}} btn-link">{{$row->priority_name}}</label></th>
                    <th>{{($row->status_name)}}</th>
                    <td align="right"><!-- 
                        <a class="btn btn-link btn-just-icon btn-info btn-detail" title="View Data" href="{{asset('admin/master/user/edit/'.$row->id)}}"><i class="fa fa-eye"></i></a> --><!-- 
                        <a class="btn btn-link btn-just-icon btn-success btn-detail" title="Edit Data" href="{{asset('admin/master/user/edit/'.$row->id)}}"><i class="fa fa-pencil"></i></a> -->
                        <button onclick="get_data({{$row->id}})" type="button" class="btn btn-link btn-just-icon btn-primary btn-edit" data-original-title="Edit Data" title="Edit Data">
                            <i class="material-icons">edit</i>
                        </button>
                        <a class="btn btn-link btn-just-icon btn-danger btn-delete" title="Delete" href="javascript:void(0);" onclick="swal({   
                        title: 'Are you sure to delete this Ticket ?',   
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
                          location.href='{{asset('admin/ticket/delete/'.$row->id)}}'
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
    .sp-primary{
      color: blue;
    }
    .sp-success{
      color: green;
    }
    .sp-warning{
      color: orange;
    }
    .sp-danger{
      color: red;
    }
    
</style>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>
$(document).ready(function() {
  $(function () {
    $('.selectpicker').selectpicker();
});

$('#id_Ticket_tab').hide();
    $('#table').DataTable({
        responsive: true,
        info: false
    });
} );
function get_data(id) {
$('#myTab li:nth-child(3) a').tab('show') // Select third tab
$('#id_Ticket_tab').show();
 $.ajax({
    url    : "{{route('ajaxEditTicket')}}",
    method : "GET",
    data   : {
                id : id
            },
    type   : "json",
    success: function (data) {      
      console.log(data);
      var base_url = window.location.origin + '/cms_nps/';
      $('#edit_code_ticket').text(data.ajax_ticket.code_ticket);
      $('#edit_tester_name').text(data.ajax_ticket.tester_name);
      $('#edit_id').val(data.ajax_ticket.id);
      $('#edit_code_ticket_h').val(data.ajax_ticket.code_ticket);
      // $('#edit_status').selectpicker('val', data.ajax_ticket.status);
      $('#edit_project').selectpicker('val', data.ajax_ticket.id_project);
      $('#edit_priority').selectpicker('val', data.ajax_ticket.priority);
      $('#edit_deadline').val(data.ajax_ticket.deadline).trigger("change");
      $('.selectpicker').selectpicker();
      
        var bug_row = ``
        $.each(data.detail,function(index,lkObj){
          // alert(lkObj.bug_desc);
          bug_row += `
            <tr id="edit_cell${lkObj.id}"><td class="text-center"><img onclick="$('#edit_product-image-file${lkObj.id}').click()" id="edit_product-image${lkObj.id}" onmouseover="" src="{{asset('${lkObj.bug_img}')}}" onerror="this.src = {{asset('assets/img/add_image.png')}}" style="cursor:pointer; top: 2em; height: 100px;">
                <input type="file" id="edit_product-image-file${lkObj.id}" onchange="readURL(this, 'edit_product-image${lkObj.id}');" name="edit_photo${lkObj.id}" style="display:none"></td>
                <td>
                <input type="hidden" name="edit_detail_id[]" id="edit_detail_id${lkObj.id}" value="${lkObj.id}"/>
                    <textarea class="form-control" id="edit_bug_desc${lkObj.id}" rows="3" name="edit_bug_desc[]" value="">${lkObj.bug_desc}</textarea>
                </td>
                <td>
                    <select name="edit_priority_d[]" id="edit_priority_d${lkObj.id}" class="selectpicker col-md-12" data-style="select-with-transition">
                        <option value="">-- Priority --</option>`;
                        @foreach ($priority as $item)
                            bug_row += '<option value="{{$item->id}}"><span class="badge badge-{{$item->type}}">{{$item->name}}</span></option>';
                        @endforeach
                bug_row += `
                    </select>
                </td>
                <td>
                    <button id="edit_close${lkObj.id}" type="button" class="btn btn-link btn-just-icon btn-danger btn-delete" onclick="hapusBug(${lkObj.id})"><i class="fa fa-close"></i></button>
                </td>
            </tr>`;

        $('#edit_countTypeBug').val(lkObj.id).trigger("change");
        // $('#edit_priority_d'+lkObj.id).selectpicker('val', lkObj.priority);
        });
        $('#edit_bug_row').html(bug_row);

        $.each(data.detail,function(index,lkObj){
          $('#edit_priority_d'+lkObj.id).selectpicker('val', lkObj.priority);
        });
        $('.selectpicker').selectpicker();
      // $('#edit_liter').val(data.ajax_po.liter)      
    }  
  })
}
  function addBug(){
    var next = parseInt($("#countTypeBug").val())+1;
    $.ajax({
      type: "GET",
      url  : "{{ route('ajaxGetNewBug') }}",
      data: {next: next},
      success: function(data) {
        $('.selectpicker').selectpicker();
        $("#bug_row").append(data);
        $("#countTypeBug").val(next);
        $('.selectpicker').selectpicker();
      }
    });
  }
  function edit_addBug(){
    var next = parseInt($("#edit_countTypeBug").val())+1;
    $.ajax({
      type: "GET",
      url  : "{{ route('ajaxGetEditNewBug') }}",
      data: {next: next},
      success: function(data) {
        $("#edit_bug_row").append(data);
        $("#edit_countTypeBug").val(next);
        $('.selectpicker').selectpicker();
      }
    });
  }
  function removeCell(id) {
    var to = parseInt($("#countTypeBug").val())-1;
    //$("#countTypeBug").val(to);
    $("#cell"+id).remove();
  }
  function editNewremoveCell(id) {
    var to = parseInt($("#edit_countTypeBug").val())-1;
    //$("#edit_countTypeBug").val(to);
    $("#edit_cell"+id).remove();
  }
  function hapusBug(id){
    $.ajax({
      type: "GET",
      url  : "{{ route('ajaxHapusBug') }}",
      data: {id: id},
      success: function(data) {
       if (data == 'sukses') {
        editremoveCell(id);
       } 
      }
    });
  }
  function editremoveCell(id) {
    var to = parseInt($("#edit_countTypeLokasi").val())-1;
    //$("#edit_countTypeLokasi").val(to);
    $("#edit_cell"+id).remove();
  }
  $("#product-image-file").change(function() {
    readURL(this, "product-image");
  });
  function changeImg(input,next){
    readURL(input, "product-image-file".next);
    // alert($(input).attr(`id`));
  }
  function readURL(input, target_image) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#'+target_image).attr('src', e.target.result).show();
        $('#'+target_image).css('opacity','1');
      }

      reader.readAsDataURL(input.files[0]);
    }else{
      $('#'+target_image).css('opacity','0.5');
    }
  } 
</script>

<script type="text/javascript">
    
</script>

