{{--
 * Laravel Classified
 *  All Rights Reserved
 *
 * 
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice
 * 
--}}
@extends('errors.layouts.master')

@section('search')
	@parent
	@include('errors/layouts/inc/search')
@endsection

@section('content')
	@if (!(isset($paddingTopExists) and $paddingTopExists))
		<div class="h-spacer"></div>
	@endif
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">

					<div class="col-md-12 page-content">

						<div class="error-page" style="margin: 100px 0;">
							<h2 class="headline text-center" style="font-size: 180px; float: none;"> 429</h2>
							<div class="text-center m-l-0" style="margin-top: 60px;">
								<h3 class="m-t-0"><i class="fa fa-warning"></i> Too many requests.</h3>
								<p>
									<?php
									$defaultErrorMessage = "Meanwhile, you may <a href='" . lurl('/') . "'>return to homepage</a>";
									?>
									{!! isset($exception) ? ($exception->getMessage() ? $exception->getMessage() : $defaultErrorMessage) : $defaultErrorMessage !!}
								</p>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
