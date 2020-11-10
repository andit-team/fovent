<!-- Modal Change Country -->
<div class="modal fade modalHasList" id="categoriesModal" tabindex="-1" role="dialog" aria-labelledby="selectCountryLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title uppercase font-weight-bold" id="selectCountryLabel">
					<i class="icon-map"></i> Select a Category
				</h4>
				
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">{{ t('Close') }}</span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row">
					@foreach (App\Models\Category::where('parent_id',0)->limit(12)->get() as $item)
					<div class="col-lg-2 col-md-3 col-sm-3 col-xs-4 f-category">
						<a href="{{url('category/'.$item->name)}}">
							<img src="{{url('/storage/app/public/'.$item->picture)}}" class="img-fluid" alt="{{$item->name}}">
							<h6>{{$item->name}}</h6>
						</a>
					</div>
					@endforeach
					{{-- @if (isset($countryCols))
						@foreach ($countryCols as $key => $col)
							<ul class="cat-list col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-6">
								@foreach ($col as $k => $country)
								<li>
									<img src="{{ url('images/blank.gif') . getPictureVersion() }}" class="flag flag-{{ ($country->get('icode')=='uk') ? 'gb' : $country->get('icode') }}" style="margin-bottom: 4px; margin-right: 5px;">
									<a href="{{ localUrl($country, '', true) }}" class="tooltip-test" title="{{ $country->get('name') }}">
										{{ \Illuminate\Support\Str::limit($country->get('name'), 28) }}
									</a>
								</li>
								@endforeach
							</ul>
						@endforeach
					@endif --}}
					
				</div>
			</div>
			
		</div>
	</div>
</div>
<!-- /.modal -->
