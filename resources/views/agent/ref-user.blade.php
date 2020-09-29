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
                <a href="https://localhost/fovent/admin/agent/create" class="btn btn-primary shadow ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fas fa-plus"></i> Add Agent</span></a>
                <div id="datatable_button_stack" class="pull-right text-right"></div>
            </div>

        <div class="card-body">
						
            <form id="bulkActionForm" action="https://localhost/fovent/admin/agent/bulk_delete" method="POST">
                <input type="hidden" name="_token" value="iGWQp2TF3h7xaqDQsnKP4xO0Gq2PEINsFsVxMlv4">
                
                <div id="crudTable_wrapper" class="dataTables_wrapper dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="crudTable_length"><label><select name="crudTable_length" aria-controls="crudTable" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option><option value="250">250</option><option value="500">500</option></select> records per page</label></div></div><div class="col-sm-12 col-md-6"><div id="crudTable_filter" class="dataTables_filter"><label>Search: <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="crudTable"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="crudTable" class="table table-bordered table-striped display dt-responsive nowrap dataTable dtr-inline" width="100%" role="grid" aria-describedby="crudTable_info" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
        
                    <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td>2011/04/25</td>
                            <td>$320,800</td>
                        </tr>
                        <tr>
                            <td>Garrett Winters</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>63</td>
                            <td>2011/07/25</td>
                            <td>$170,750</td>
                        </tr>
                    </tbody>
        
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
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
{{-- @section('after_scripts')
<script src=""></script>
https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css --}}
@endsection

@endsection









