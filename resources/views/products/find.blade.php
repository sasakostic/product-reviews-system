@extends('layout')
@section('title', 'Find Product And Write Review')
@section('content')

<h3><i class="fa fa-comment"></i> Write a review</h3>
<div>

	<div class="col-lg-6 col-md-6 col-sm-6 row">
		<form action="{{ url('products/search') }}" method="GET">
			
			<div class="input-group">
				<input type="text" name="name" class="form-control" placeholder="Product name" required autofocus/> 
				<span class="input-group-btn">
					<button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
				</span>
			</div>
			
		</form>
	</div>

</div>
@stop