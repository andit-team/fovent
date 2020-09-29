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

<div class="jumbotron text-center">
    <h1>Fovent care for your earth and your food</h1>
  <h3>  Hi Dear, {{Auth::user()->name}} !</h3>
    <h4 class ="p-2">Thank you for your cooperation at Fovent .</h4> 
    <input type="text" value="{{url('/')}}?ref={{Auth::user()->id}}" id="myInput">
    <button onclick="myFunction()">Copy text</button>
    <p class="text-danger p-4">Copy this link  to use it on Social Media or to Invite Friends to Friends.</p>
  </div>

@endsection

<script>
function myFunction() {
    /* Get the text field */
    var copyText = document.getElementById("myInput");
  
    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/
  
    /* Copy the text inside the text field */
    document.execCommand("copy");
  
    /* Alert the copied text */
    alert("Copied the text: " + copyText.value);
  }
 </script>