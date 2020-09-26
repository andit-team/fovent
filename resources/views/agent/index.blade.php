@extends('admin::layouts.master')

@section('header')
	<div class="row page-titles">
		<div class="col-md-6 col-12 align-self-center">
			<h3 class="mb-0">
				<span class="text-capitalize">Agent</span>
				<small>{{ trans('admin.all') }} <span>Agent</span> {{ trans('admin.in_the_database') }}.</small>
			</h3>
		</div>
		<div class="col-md-6 col-12 align-self-center d-none d-md-block">
			<ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
				<li class="breadcrumb-item"><a href="{{ admin_url() }}">{{ trans('admin.dashboard') }}</a></li>
				<li class="breadcrumb-item"><a href="#" class="text-capitalize">Agent</a></li>
				<li class="breadcrumb-item active">{{ trans('admin.list') }}</li>
			</ol>
		</div>
	</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        
                    
        <div class="card rounded">
                
                <div class="card-header with-border">
                    <a href="https://localhost/fovent/public/admin/users/create" class="btn btn-primary shadow ladda-button" data-style="zoom-in">
    <span class="ladda-label">
        <i class="fas fa-plus"></i> Add user
    </span>
</a>
                                                        <button id="bulkDeleteBtn" class="btn btn-danger shadow"><i class="fas fa-times"></i> Delete Selected Items</button>
                                      <div id="datatable_button_stack" class="pull-right text-right"></div>
                </div>
                
                
                                        <div class="card-body">
                        <nav class="navbar navbar-expand-lg navbar-filters mb-0 pb-0 pt-0">
<!-- Brand and toggle get grouped for better mobile display -->
<a class="nav-item d-none d-lg-block">
    <span class="fas fa-filter"></span>
</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle filters">
    <i class="fas fa-filter"></i> Filters
</button>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
        <!-- THE ACTUAL FILTERS -->
                        <li filter-name="id" filter-type="text" class="dropdown ">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ID <span class="caret"></span></a>
<div class="dropdown-menu pt-0 pb-0">
    <div class="form-group backpack-filter mb-0">
        <div class="input-group">
            <input class="form-control pull-right" id="text-filter-id" type="text">
            <div class="input-group-append">
                <span class="input-group-text">
                    <a class="text-filter-id-clear-button" href=""><i class="fa fa-times"></i></a>
                </span>
            </div>
        </div>
    </div>
</div>
</li>









                        <li filter-name="from_to" filter-type="date_range" class="nav-item dropdown ">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    Date range <span class="caret"></span>
</a>
<div class="dropdown-menu p-0">
    <div class="form-group backpack-filter mb-0">
        <div class="input-group date">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
            </div>
            <input class="form-control pull-right" id="daterangepicker-from-to" type="text">
            <div class="input-group-append daterangepicker-from-to-clear-button">
                <a class="input-group-text" href=""><i class="fa fa-times"></i></a>
            </div>
        </div>
    </div>
</div>
</li>













                        <li filter-name="name" filter-type="text" class="dropdown ">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Name <span class="caret"></span></a>
<div class="dropdown-menu pt-0 pb-0">
    <div class="form-group backpack-filter mb-0">
        <div class="input-group">
            <input class="form-control pull-right" id="text-filter-name" type="text">
            <div class="input-group-append">
                <span class="input-group-text">
                    <a class="text-filter-name-clear-button" href=""><i class="fa fa-times"></i></a>
                </span>
            </div>
        </div>
    </div>
</div>
</li>









                        <li filter-name="country" filter-type="select2" class="nav-item dropdown ">
<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    Country <span class="caret"></span>
</a>
<div class="dropdown-menu p-0">
    <div class="form-group backpack-filter mb-0" style="min-width: 200px;">
        <select id="filter_country" name="filter_country" class="form-control input-sm select2 select2-hidden-accessible" data-filter-type="select2" data-filter-name="country" placeholder="" tabindex="-1" aria-hidden="true">
            <option value="">-</option>
                                                        <option value="AR">
                        Argentina
                    </option>
                                        <option value="AT">
                        Austria
                    </option>
                                        <option value="BE">
                        Belgium
                    </option>
                                        <option value="BR">
                        Brazil
                    </option>
                                        <option value="CA">
                        Canada
                    </option>
                                        <option value="CL">
                        Chile
                    </option>
                                        <option value="CR">
                        Costa Rica
                    </option>
                                        <option value="HR">
                        Croatia
                    </option>
                                        <option value="CZ">
                        Czech Republic
                    </option>
                                        <option value="DK">
                        Denmark
                    </option>
                                        <option value="DM">
                        Dominica
                    </option>
                                        <option value="FR">
                        France
                    </option>
                                        <option value="DE">
                        Germany
                    </option>
                                        <option value="GL">
                        Greenland
                    </option>
                                        <option value="HK">
                        Hong Kong SAR China
                    </option>
                                        <option value="IN">
                        India
                    </option>
                                        <option value="IR">
                        Iran
                    </option>
                                        <option value="IT">
                        Italy
                    </option>
                                        <option value="MT">
                        Malta
                    </option>
                                        <option value="MX">
                        Mexico
                    </option>
                                        <option value="NL">
                        Netherlands
                    </option>
                                        <option value="NZ">
                        New Zealand
                    </option>
                                        <option value="PK">
                        Pakistan
                    </option>
                                        <option value="PH">
                        Philippines
                    </option>
                                        <option value="PT">
                        Portugal
                    </option>
                                        <option value="PR">
                        Puerto Rico
                    </option>
                                        <option value="ES">
                        Spain
                    </option>
                                        <option value="SE">
                        Sweden
                    </option>
                                        <option value="CH">
                        Switzerland
                    </option>
                                        <option value="TH">
                        Thailand
                    </option>
                                        <option value="ZW">
                        Zimbabwe
                    </option>
                                            </select><span class="select2 select2-container select2-container--bootstrap" dir="ltr" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-filter_country-container"><span class="select2-selection__rendered" id="select2-filter_country-container" title="-"><span class="select2-selection__clear">×</span>-</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
    </div>
</div>
</li>













                        <li filter-name="status" filter-type="dropdown" class="nav-item dropdown ">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    Status <span class="caret"></span>
</a>
<ul class="dropdown-menu">
    <a class="dropdown-item" parameter="status" dropdownkey="" href="">-</a>
    <div role="separator" class="dropdown-divider"></div>
                                                    <li class="dropdown-item ">
                    <a parameter="status" href="" key="1">Unactivated</a>
                </li>
                                                            <li class="dropdown-item ">
                    <a parameter="status" href="" key="2">Activated</a>
                </li>
                                    </ul>
</li>














                        <li filter-name="type" filter-type="dropdown" class="nav-item dropdown ">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    Permissions/Roles <span class="caret"></span>
</a>
<ul class="dropdown-menu">
    <a class="dropdown-item" parameter="type" dropdownkey="" href="">-</a>
    <div role="separator" class="dropdown-divider"></div>
                                                    <li class="dropdown-item ">
                    <a parameter="type" href="" key="1">Has Admins Permissions</a>
                </li>
                                                            <li class="dropdown-item ">
                    <a parameter="type" href="" key="2">Has Super-Admins Permissions</a>
                </li>
                                                            <li class="dropdown-item ">
                    <a parameter="type" href="" key="3">Has Super-Admins Role</a>
                </li>
                                    </ul>
</li>














                    <li>
            <a href="#" id="remove_filters_button" class="nav-link invisible">
                <i class="fa fa-eraser"></i> Remove filters
            </a>
        </li>
    </ul>
</div>
</nav>



                    </div>
                                    
                <div class="card-body">
                    
                    <form id="bulkActionForm" action="https://localhost/fovent/public/admin/users/bulk_delete" method="POST">
                        <input type="hidden" name="_token" value="Nqn0hMjZPkf6u4PyZgweSp2bnjWwSRRg76jodED6">
                        
                        <div id="crudTable_wrapper" class="dataTables_wrapper dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="crudTable_length"><label><select name="crudTable_length" aria-controls="crudTable" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option><option value="250">250</option><option value="500">500</option></select> records per page</label></div></div><div class="col-sm-12 col-md-6"><div id="crudTable_filter" class="dataTables_filter"><label>Search: <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="crudTable"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="crudTable" class="table table-bordered table-striped display dt-responsive nowrap dataTable dtr-inline" width="100%" role="grid" aria-describedby="crudTable_info" style="width: 100%;">
                            <thead>
                            <tr role="row"><th data-orderable="false" class="dt-checkboxes-cell dt-checkboxes-select-all sorting_disabled" tabindex="0" aria-controls="massSelectAll" rowspan="1" colspan="1" style="width: 22px; text-align: center; padding-right: 10px;" data-col="0" aria-label="
                                        
                                    ">
                                        <input type="checkbox" id="massSelectAll" name="massSelectAll">
                                    </th><th data-orderable="true" class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" style="width: 239px;" aria-label="
                                        Date
                                    : activate to sort column ascending">
                                        Date
                                    </th><th data-orderable="true" class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" style="width: 90px;" aria-label="
                                        Name
                                    : activate to sort column ascending">
                                        Name
                                    </th><th data-orderable="true" class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" style="width: 263px;" aria-label="
                                        Email
                                    : activate to sort column ascending">
                                        Email
                                    </th><th data-orderable="true" class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" style="width: 113px;" aria-label="
                                        Country
                                    : activate to sort column ascending">
                                        Country
                                    </th><th data-orderable="true" class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" style="width: 177px;" aria-label="
                                        Verified Email
                                    : activate to sort column ascending">
                                        Verified Email
                                    </th><th data-orderable="true" class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" style="width: 185px;" aria-label="
                                        Verified Phone
                                    : activate to sort column ascending">
                                        Verified Phone
                                    </th><th data-orderable="false" class="sorting_disabled" rowspan="1" colspan="1" style="width: 123px;" aria-label="Actions">Actions</th></tr>
                            </thead>
    
                            <tbody>
                            <tr role="row" class="odd"><td class="dtr-control">
<input name="entryId[]" type="checkbox" value="11" class="dt-checkboxes" disabled="disabled">

</td><td>
    22 September 2020 06:23
</td><td>Agent</td><td>agent@fovent.com</td><td>
<a href="?d=BD" target="_blank"><img src="https://localhost/fovent/public/images/flags/16/bd.png" data-toggle="tooltip" title="" data-original-title="Bangladesh"></a></td><td>
<a href="" class="ajax-request" data-table="users" data-field="verified_email" data-line-id="verified_email11" data-id="11" data-value="0"><i id="verified_email11" class="admin-single-icon fa fa-toggle-off" aria-hidden="true"></i></a> &nbsp;<a class="btn btn-light btn-xs" href="https://localhost/fovent/public/admin/verify/user/11/resend/email" data-toggle="tooltip" title="" data-original-title="To: agent@fovent.com"><i class="far fa-paper-plane"></i> Re-send link</a></td><td>
<a href="" class="ajax-request" data-table="users" data-field="verified_phone" data-line-id="verified_phone11" data-id="11" data-value="0"><i id="verified_phone11" class="admin-single-icon fa fa-toggle-off" aria-hidden="true"></i></a> &nbsp;<a class="btn btn-light btn-xs" href="https://localhost/fovent/public/admin/verify/user/11/resend/sms" data-toggle="tooltip" title="" data-original-title="To: 01234567891"><i class="fas fa-mobile-alt"></i> Re-send code</a></td><td><a class="btn btn-xs btn-warning" "="" data-toggle="tooltip" title="" data-original-title="Cannot impersonate admin users"><i class="fa fa-lock"></i></a>
                                                    <a href="https://localhost/fovent/public/admin/users/11/edit" class="btn btn-xs btn-primary">
    <i class="far fa-edit"></i> Edit
</a>
                                                        <a href="https://localhost/fovent/public/admin/users/11" class="btn btn-xs btn-danger" data-button-type="delete"><i class="far fa-trash-alt"></i> Delete</a>
              </td></tr><tr role="row" class="even"><td class="dtr-control">
<input name="entryId[]" type="checkbox" value="10" class="dt-checkboxes" disabled="disabled">

</td><td>
    20 September 2020 08:04
</td><td>Andit</td><td>andit.andimpex@gmail.com</td><td>
<a href="?d=BD" target="_blank"><img src="https://localhost/fovent/public/images/flags/16/bd.png" data-toggle="tooltip" title="" data-original-title="Bangladesh"></a></td><td>
<a href="" class="ajax-request" data-table="users" data-field="verified_email" data-line-id="verified_email10" data-id="10" data-value="1"><i id="verified_email10" class="admin-single-icon fa fa-toggle-on" aria-hidden="true"></i></a></td><td>
<i class="admin-single-icon fa fa-toggle-on" aria-hidden="true"></i></td><td><a class="btn btn-xs btn-warning" "="" data-toggle="tooltip" title="" data-original-title="Cannot impersonate yourself"><i class="fa fa-lock"></i></a>
                                                    <a href="https://localhost/fovent/public/admin/users/10/edit" class="btn btn-xs btn-primary">
    <i class="far fa-edit"></i> Edit
</a>
                                                        
              </td></tr><tr role="row" class="odd"><td class="dtr-control">
<input name="entryId[]" type="checkbox" value="8" class="dt-checkboxes" disabled="disabled">

</td><td>
    13 September 2020 21:42
</td><td>Km</td><td>info@olila.de</td><td>
<a href="/de?d=DE" target="_blank"><img src="https://localhost/fovent/public/images/flags/16/de.png" data-toggle="tooltip" title="" data-original-title="Germany"></a></td><td>
<a href="" class="ajax-request" data-table="users" data-field="verified_email" data-line-id="verified_email8" data-id="8" data-value="1"><i id="verified_email8" class="admin-single-icon fa fa-toggle-on" aria-hidden="true"></i></a></td><td>
<i class="admin-single-icon fa fa-toggle-on" aria-hidden="true"></i></td><td><a class="btn btn-xs btn-warning" "="" data-toggle="tooltip" title="" data-original-title="Cannot impersonate admin users"><i class="fa fa-lock"></i></a>
                                                    <a href="https://localhost/fovent/public/admin/users/8/edit" class="btn btn-xs btn-primary">
    <i class="far fa-edit"></i> Edit
</a>
                                                        <a href="https://localhost/fovent/public/admin/users/8" class="btn btn-xs btn-danger" data-button-type="delete"><i class="far fa-trash-alt"></i> Delete</a>
              </td></tr><tr role="row" class="even"><td class="dtr-control">
<input name="entryId[]" type="checkbox" value="4" class="dt-checkboxes" disabled="disabled">

</td><td>
    11 September 2020 19:06
</td><td>Karel</td><td>karel@merbs.eu</td><td>
<a href="/de?d=DE" target="_blank"><img src="https://localhost/fovent/public/images/flags/16/de.png" data-toggle="tooltip" title="" data-original-title="Germany"></a></td><td>
<a href="" class="ajax-request" data-table="users" data-field="verified_email" data-line-id="verified_email4" data-id="4" data-value="1"><i id="verified_email4" class="admin-single-icon fa fa-toggle-on" aria-hidden="true"></i></a></td><td>
<a href="" class="ajax-request" data-table="users" data-field="verified_phone" data-line-id="verified_phone4" data-id="4" data-value="1"><i id="verified_phone4" class="admin-single-icon fa fa-toggle-on" aria-hidden="true"></i></a></td><td><a class="btn btn-xs btn-warning" "="" data-toggle="tooltip" title="" data-original-title="Cannot impersonate admin users"><i class="fa fa-lock"></i></a>
                                                    <a href="https://localhost/fovent/public/admin/users/4/edit" class="btn btn-xs btn-primary">
    <i class="far fa-edit"></i> Edit
</a>
                                                        <a href="https://localhost/fovent/public/admin/users/4" class="btn btn-xs btn-danger" data-button-type="delete"><i class="far fa-trash-alt"></i> Delete</a>
              </td></tr><tr role="row" class="odd"><td class="dtr-control">
<input name="entryId[]" type="checkbox" value="1" class="dt-checkboxes" disabled="disabled">

</td><td>
    23 September 2020 10:56
</td><td>4Not</td><td>info@rawmaniac.com</td><td>
<a href="/de?d=DE" target="_blank"><img src="https://localhost/fovent/public/images/flags/16/de.png" data-toggle="tooltip" title="" data-original-title="Germany"></a></td><td>
<a href="" class="ajax-request" data-table="users" data-field="verified_email" data-line-id="verified_email1" data-id="1" data-value="1"><i id="verified_email1" class="admin-single-icon fa fa-toggle-on" aria-hidden="true"></i></a></td><td>
<a href="" class="ajax-request" data-table="users" data-field="verified_phone" data-line-id="verified_phone1" data-id="1" data-value="1"><i id="verified_phone1" class="admin-single-icon fa fa-toggle-on" aria-hidden="true"></i></a></td><td><a class="btn btn-xs btn-warning" "="" data-toggle="tooltip" title="" data-original-title="Cannot impersonate admin users"><i class="fa fa-lock"></i></a>
                                                    <a href="https://localhost/fovent/public/admin/users/1/edit" class="btn btn-xs btn-primary">
    <i class="far fa-edit"></i> Edit
</a>
                                                        <a href="https://localhost/fovent/public/admin/users/1" class="btn btn-xs btn-danger" data-button-type="delete"><i class="far fa-trash-alt"></i> Delete</a>
              </td></tr></tbody>
    
                            <tfoot>
                            <tr><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1">Date</th><th rowspan="1" colspan="1">Name</th><th rowspan="1" colspan="1">Email</th><th rowspan="1" colspan="1">Country</th><th rowspan="1" colspan="1">Verified Email</th><th rowspan="1" colspan="1">Verified Phone</th><th rowspan="1" colspan="1">Actions</th></tr>
                            </tfoot>
                        </table><div id="crudTable_processing" class="dataTables_processing card" style="display: none;">Processing...</div></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="crudTable_info" role="status" aria-live="polite">Showing 1 to 5 of 5 entries.</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="crudTable_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="crudTable_previous"><a href="#" aria-controls="crudTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="crudTable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item next disabled" id="crudTable_next"><a href="#" aria-controls="crudTable" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                        
                    </form>

                </div>

                                    
        </div>
    </div>
</div>
@endsection

@section('after_styles')
  <!-- DATA TABLES -->
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">

  <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css') }}">
  <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/list.css') }}">

  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')
@endsection

@section('after_scripts')
  {{-- @include('crud::inc.datatables_logic') --}}
  <script src="{{ asset('packages/backpack/crud/js/crud.js') }}"></script>
  <script src="{{ asset('packages/backpack/crud/js/form.js') }}"></script>
  <script src="{{ asset('packages/backpack/crud/js/list.js') }}"></script>

  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection