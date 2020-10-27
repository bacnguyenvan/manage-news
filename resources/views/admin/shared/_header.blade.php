<section class="content-header">
	<div class="row mb-2">
		<div class="col-sm-6">
			<h1>{{$title}}</h1>
		</div>
		@if(isset($breadcrumb) && $breadcrumb == false)
		
		@else
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					{{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Simple Tables</li> --}}
				</ol>
			</div>
		@endif
	</div>
</section>