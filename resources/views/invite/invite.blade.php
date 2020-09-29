@extends('admin::layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-6 col-12 align-self-center">
        <h3 class="mb-0">          
            <small><span>Agent</span> Invitation</small>
        </h3>
    </div>
    <div class="col-md-6 col-12 align-self-center d-none d-md-block">
        <ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
            <li class="breadcrumb-item"><a href="https://localhost/fovent/admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="https://localhost/fovent/admin/agent" class="text-capitalize">Agent</a></li>
            <li class="breadcrumb-item active">Invitation</li>
        </ol>
    </div>
</div>
<style type="text/css">
	
	html {
		height: 100%;
		overflow: hidden;
	}

	body {
		height:100%;
		overflow: auto;
		-webkit-overflow-scrolling: touch;
	}
	
	html{
		height:100%;
		background: #ffffff url(https://images.unsplash.com/photo-1449168013943-3a15804bb41c?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&w=1080&fit=max&s=1958d4bfb59a246c6092ff0daabd284b); no-repeat center bottom fixed;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}

	#cspio-page{
		background-color: rgba(0,0,0,0);
	}
	
	.flexbox #cspio-page{
		align-items: center;
		justify-content: center;
	}

	.cspio body{
		background: transparent;
	}

	.cspio body, .cspio body p{
        font-family: Helvetica, Arial, sans-serif;
		font-weight: 400;
		font-style: ;
        font-size: 20px;
        line-height: 1.50em;
        color:black;
    }

	::-webkit-input-placeholder {
		font-family:Helvetica, Arial, sans-serif;
		font-weight: 400;
		font-style: ;
	}

	::-moz-placeholder {
		font-family:Helvetica, Arial, sans-serif;
		font-weight: 400;
		font-style: ;
	} 

	:-ms-input-placeholder {
		font-family:Helvetica, Arial, sans-serif;
		font-weight: 400;
		font-style: ;
	} 

	:-moz-placeholder {
		font-family:Helvetica, Arial, sans-serif;
		font-weight: 400;
		font-style: ;
	}

    .cspio h1, .cspio h2, .cspio h3, .cspio h4, .cspio h5, .cspio h6{
        font-family: 'Pacifico';
        color:#ffffff;
    }

	#cspio-headline{
		font-family: 'Pacifico';
		font-weight: 400;
		font-style: ;
				font-size: 48px;
		color:#ffffff;
		line-height: 1.00em;
	}

	.cspio button{
        font-family: Helvetica, Arial, sans-serif;
		font-weight: 400;
		font-style: ;
    }
	
    .cspio a, .cspio a:visited, .cspio a:hover, .cspio a:active{
		color: #ffffff;
	}

	#cspio-socialprofiles a {
	  color: #ffffff;
	}
	.cspio .btn-primary,
	.cspio .btn-primary:focus,
	.gform_button,
	#mc-embedded-subscribe, .submit-button {
		color: black;
		text-shadow: 0 -1px 0 rgba(255,255,255,0.3);
		background-color: #ffffff;
		background-image: -moz-linear-gradient(top,#ffffff,#d9d9d9);
		background-image: -ms-linear-gradient(top,#ffffff,#d9d9d9);
		background-image: -webkit-gradient(linear,0 0,0 100%,from(#ffffff),to(#d9d9d9));
		background-image: -webkit-linear-gradient(top,#ffffff,#d9d9d9);
		background-image: -o-linear-gradient(top,#ffffff,#d9d9d9);
		background-image: linear-gradient(top,#ffffff,#d9d9d9);
		background-repeat: repeat-x;
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#d9d9d9', GradientType=0);
		border-color: #d9d9d9 #d9d9d9 #b3b3b3;
		border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
		*background-color: #d9d9d9;
		filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
	}

	.cspio .btn-primary:hover,
	.cspio .btn-primary:active,
	.cspio .btn-primary.active,
	.cspio .btn-primary.disabled,
	.cspio .btn-primary[disabled],
	.cspio .btn-primary:focus:hover,
	.cspio .btn-primary:focus:active,
	.cspio .btn-primary:focus.active,
	.cspio .btn-primary:focus.disabled,
	.cspio .btn-primary:focus[disabled],
	#mc-embedded-subscribe:hover,
	#mc-embedded-subscribe:active,
	#mc-embedded-subscribe.active,
	#mc-embedded-subscribe.disabled,
	#mc-embedded-subscribe[disabled] {
		background-color: #d9d9d9;
		*background-color: #cccccc;
	}

	.cspio .btn-primary:active,
	.cspio .btn-primary.active,
	.cspio .btn-primary:focus:active,
	.cspio .btn-primary:focus.active,
	.gform_button:active,
	.gform_button.active,
	#mc-embedded-subscribe:active,
	#mc-embedded-subscribe.active {
		background-color: #bfbfbf;
	}

	.form-control,
	.progress {
		background-color: rgba(255, 255, 255, 0.85);
	}

	#cspio-progressbar span,
	.countdown_section {
		color: black;
		text-shadow: 0 -1px 0 rgba(255,255,255,0.3);
	}

	.cspio .btn-primary:hover,
	.cspio .btn-primary:active {
		color: black;
		text-shadow: 0 -1px 0 rgba(255,255,255,0.3);
		border-color: #e6e6e6;
	}

	.cspio input[type='text']:focus {
		webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075), 0 0 8px rgba(217,217,217,0.6);
		-moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075), 0 0 8px rgba(217,217,217,0.6);
		box-shadow: inset 0 1px 1px rgba(0,0,0,0.075), 0 0 8px rgba(217,217,217,0.6);
	}
    
    #cspio-content {
		display: none;
		max-width: 600px;
		background-color: #000000;
		-webkit-border-radius: 2px;
		border-radius: 2px;
		-moz-background-clip: padding;
		-webkit-background-clip: padding-box;
		background-clip: padding-box;
		background-color:transparent;
	}
    
	.cspio .progress-bar,
	.countdown_section,
	.cspio .btn-primary,
	.cspio .btn-primary:focus,
	.gform_button {
		background-image: none;
		text-shadow: none;
	}

	.cspio input,
	.cspio input:focus {
		-webkit-box-shadow: none !important;
		box-shadow: none !important;
	}
							
	#cspio-page{
	    background: -moz-radial-gradient(ellipse at center, rgba(0, 0, 0, 0.3) 0%,rgba(0, 0, 0, 0.2) 37%,rgba(0,0,0,0) 68%,rgba(0,0,0,0) 100%);
	    background: -webkit-radial-gradient(ellipse at center, rgba(0, 0, 0, 0.3) 0%,rgba(0, 0, 0, 0.2) 37%,rgba(0,0,0,0) 68%,rgba(0,0,0,0) 100%);
	    background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.3) 0%,rgba(0, 0, 0, 0.2) 37%,rgba(0,0,0,0) 68%,rgba(0,0,0,0) 100%);
	}

	.cspio body{
		background: -moz-radial-gradient(center, ellipse cover,  rgba(0,0,0,0) 7%, rgba(0,0,0,0) 80%, rgba(0,0,0,0.23) 100%); 
		background: -webkit-radial-gradient(center, ellipse cover,  rgba(0,0,0,0) 7%,rgba(0,0,0,0) 80%,rgba(0,0,0,0.23) 100%); 
		background: radial-gradient(ellipse at center,  rgba(0,0,0,0) 7%,rgba(0,0,0,0) 80%,rgba(0,0,0,0.23) 100%); 
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#3b000000',GradientType=1 ); 
	}

	#cspio-subscribe-btn{
	    background:transparent;
	    border: 1px solid #fff !important;
	    color: #fff;
	}

	#cspio-subscribe-btn:hover{
	    background: rgba(255,255,255,0.2);
	    color: #fff;
	}

	#cspio-credit img{
		margin-left:auto;
		margin-right:auto;
		width:125px;
		    margin-top: -4px;
	}

	#cspio-credit {
		font-size:11px;
	}

	</style>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- Modernizr -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
	
	<!-- Google Analytics Code Goes Here-->
    </head>
    <body><div class=""><div class="aHl"></div><div id=":mq" tabindex="-1"></div><div id=":lj" class="ii gt"><div id=":lk" class="a3s aXjCH "><u></u>

	<div style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#ffffff;color:#718096;height:100%;line-height:1.4;margin:0;padding:0;width:100%!important">
	
	
	<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%">
	<tbody><tr>
	<td align="center" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
	<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';margin:0;padding:0;width:100%">
	<tbody><tr>
	<td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';padding:25px 0;text-align:center">
	<a href="https://projects.andit.co/laravel/fovent/" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:19px;font-weight:bold;text-decoration:none;display:inline-block" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://projects.andit.co/laravel/fovent/&amp;source=gmail&amp;ust=1601286972513000&amp;usg=AFQjCNGQ2qwNz_OxX83yUsuF_FHNXQqyZQ">
	Fovent care for your earth and your food
	</a>
	</td>
	</tr>
	
	
	<tr>
	<td width="100%" cellpadding="0" cellspacing="0" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;border-bottom:1px solid #edf2f7;border-top:1px solid #edf2f7;margin:0;padding:0;width:100%">
	<table align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#ffffff;border-color:#e8e5ef;border-radius:2px;border-width:1px;margin:0 auto;padding:0;width:570px">
	
	<tbody><tr>
	<td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';max-width:100vw;padding:32px">
	<h1 style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left"> Hi Dear, {{Auth::user()->name}} !</h1>
    <h3 style="box-sizing:border-box;padding:30px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; color:rgb(31, 15, 15); font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Thank you for your cooperation at Fovent.</h3>
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
        <tbody><tr>
        <td align="center" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
        <tbody><tr>
        <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
        <a href="{{url('https://projects.andit.co/laravel/fovent/'. '?'.'ref'.'='.Auth::user()->id)}}" rel="noopener" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;background-color:#2d3748;border-bottom:8px solid #2d3748;border-left:18px solid #2d3748;border-right:18px solid #2d3748;border-top:8px solid #2d3748" target="_blank" data-saferedirecturl="https://www.google.com/url?q=href="{{url('https://projects.andit.co/laravel/fovent/admin/login')}}">Click For Copy</a>
        </td>
        </tr>
        </tbody></table>
        </td>
        </tr>
        </tbody></table>

	<p style="box-sizing:border-box; padding:15px; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><p>Copy this link  to use it on Social Media or to Invite Friends to Friends.</p>
	<table align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';margin:30px auto;padding:0;text-align:center;width:100%">
	<tbody><tr>
	<td align="center" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">	
	</td>
	</tr>
	</tbody></table>
	</td>
	</tr>
	</tbody></table>
	</td>
	</tr>
	</tbody></table>
	</td>
	</tr>
	
	<tr>
	<td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
	<table align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';margin:0 auto;padding:0;text-align:center;width:570px">
	<tbody><tr>
	<td align="center" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';max-width:100vw;padding:32px">
	<p style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';line-height:1.5em;margin-top:0;color:#b0adc5;font-size:12px;text-align:center">© 2020 Fovent care for your earth and your food. All rights reserved.</p>
	
	</td>
	</tr>
	</tbody></table>
	</td>
	</tr>
	</tbody></table>
	</td>
	</tr>
	</tbody></table><div class="yj6qo"></div><div class="adL">
	</div></div><div class="adL">
	
	</div></div></div><div id=":mm" class="ii gt" style="display:none"><div id=":ml" class="a3s aXjCH undefined"></div></div><div class="hi"></div></div>
@endsection