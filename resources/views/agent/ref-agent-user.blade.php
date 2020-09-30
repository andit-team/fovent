@extends('admin::layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-6 col-12 align-self-center">
        <h3 class="mb-0">
            <span class="text-capitalize">Agent</span>
            <small>All  <span>Agent</span> in the database.</small>
        </h3>
    </div>
    <div class="col-md-6 col-12 align-self-center d-none d-md-block">
        <ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
            <li class="breadcrumb-item"><a href="https://localhost/fovent/admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="https://localhost/fovent/admin/agent" class="text-capitalize">Agent</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card rounded">
					
            <div class="card-header with-border">
                {{-- <a href="https://localhost/fovent/admin/agent/create" class="btn btn-primary shadow ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fas fa-plus"></i> Add Agent</span></a> --}}
                <div id="datatable_button_stack" class="pull-right text-right"></div>
            </div>

        <div class="card-body">
						
            <form id="bulkActionForm" action="https://localhost/fovent/admin/agent/bulk_delete" method="POST">
                <input type="hidden" name="_token" value="iGWQp2TF3h7xaqDQsnKP4xO0Gq2PEINsFsVxMlv4">
                
                <div id="crudTable_wrapper" class="dataTables_wrapper dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="crudTable_length"><label><select name="crudTable_length" aria-controls="crudTable" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option><option value="250">250</option><option value="500">500</option></select> records per page</label></div></div><div class="col-sm-12 col-md-6"><div id="crudTable_filter" class="dataTables_filter"><label>Search: <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="crudTable"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="crudTable" class="table table-bordered table-striped display dt-responsive nowrap dataTable dtr-inline" width="100%" role="grid" aria-describedby="crudTable_info" style="width: 100%;">
                    <thead>
                        <tr>
                            <th >Date</th>
                            <th>Name</th>
                            <th >Agent Name</th>                           
                            <th>IP</th>
                            <th>Active</th>
                            <th width="100px;" >Action</th>
                        </tr>
                    </thead>
        
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{date('d F Y',strtotime($user->created_at))}} / {{date('h:i',strtotime($user->created_at))}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->ref->name}}</td>                            
                            <td>{{$user->ip_addr}}</td>
                            <td></td>
                            <td>
            
                                <a href="{{ url('impersonate/take/'.$user->id) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" title="" data-original-title="Cannot impersonate admin users"><i class="fas fa-sign-in-alt"></i></a>
                                <a href="{{ url('admin/users/'.$user->id.'/edit') }}" class="btn btn-xs btn-primary"><i class="far fa-edit"></i> Edit </a>

                                {{-- <form action="{{url('admin/users/delete/', $user->id)}}" method="post" style="margin-top:-2px" id="deleteButton{{$user->id}}">
                                    @csrf
                                    @method('delete')
                                    <a class="btn btn-danger" onclick="return myFunction();" ><i class="far fa-trash-alt"></i> Delete</a>
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-trash-o"></i></button>
                                </form> --}}

                                {{-- <a class="btn btn-danger btn-sm" onclick="return myFunction();"  href="{{url('admin/users/delete/'.$user->id)}}"><i class="far fa-trash-alt"></i> Delete</a> --}}

                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

                                <a href="{{ route('user.destroy',$user->id) }}" class="btn btn-xs btn-danger again" style="font-size: 0.8em;" id="deleteCompany" data-id="{{ $user->id }}">
                                    <i class="far fa-trash-alt"></i> Delete
                                </a>
                               

                                {{-- <a href="https://localhost/fovent/admin/users/23" class="btn btn-xs btn-danger" onclick="register_delete_button_actionss()"><i class="far fa-trash-alt"></i> Delete</a> --}}
                            </td>
                            {{-- https://localhost/fovent/admin/users/23/edit --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5"> No User Found</td>
                        </tr>
                        @endforelse
                    </tbody>
        
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Agent Name</th>
                            <th>IP</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table><div id="crudTable_processing" class="dataTables_processing card" style="display: none;">Processing...</div></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="crudTable_info" role="status" aria-live="polite">Showing 1 to 2 of 2 entries.</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="crudTable_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="crudTable_previous"><a href="#" aria-controls="crudTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="crudTable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item next disabled" id="crudTable_next"><a href="#" aria-controls="crudTable" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                
            </form>
        
        </div>
        </div>
</div>
</div>

@section('after_styles')
    {{-- DATA TABLES --}}
    <link href="{{ asset('vendor/admin-theme/plugins/datatables/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('vendor/admin-theme/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/admin-theme/plugins/datatables/extensions/Responsive/2.2.5/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('after_scripts')
    {{-- DATA TABLES SCRIPT --}}
    <script src="{{ asset('vendor/admin-theme/plugins/datatables/js/jquery.dataTables.js') }}" type="text/javascript"></script>
	<script src="{{ asset('vendor/admin-theme/plugins/datatables.net-bs4/js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>
	<script src="{{ asset('vendor/admin-theme/plugins/datatables/extensions/Responsive/2.2.5/dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/admin-theme/plugins/datatables/extensions/Responsive/2.2.5/responsive.bootstrap4.min.js') }}" type="text/javascript"></script>
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );   

    </script>

{{-- <script>
    function myFunction() {
        if(!confirm("Are You Sure to delete this"))
        event.preventDefault();
    }
 </script> --}}
 
<script>
    $(document).ready(function () {

$("body").on("click","#deleteCompany",function(e){

   if(!confirm("Do you really want to do this?")) {
      return false;
    }

   e.preventDefault();
   var id = $(this).data("id");
   // var id = $(this).attr('data-id');
   var token = $("meta[name='csrf-token']").attr("content");
   var url = e.target;

   $.ajax(
       {
         url: url.href, //or you can use url: "company/"+id,
         type: 'DELETE',
         data: {
           _token: token,
               id: id
       },
       success: function (response){

           $("#success").html(response.message)

        //    Swal.fire(
        //      'Remind!',
        //      'User deleted successfully!',
        //      'success'
        //    )
        
        window.location.href = 'user-agent';
                        
       }
    });
     return false;
  });
   

});
</script>
 
{{-- @section('after_scripts')
<script src=""></script>
https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css --}}
@endsection

@endsection









