@extends('admin/layout')
@section('content')

<div>Some of the selected categories contain products. Delete categories and:</div>

<form action="{{ url('admin/categories/delete-non-empty')}}" method="POST">
	<div>
		<input type="hidden" name="categories" value="{{ $categories }}" />
	</div>
	<div>
		<input type="radio" name="type" id="delete_assign" value="delete_assign" checked="checked"/> <label for="delete_assign">move all products from selected categories to Unassigned category</label>
	</div>
	<div>
		<input type="radio" name="type" id="delete_products" value="delete_products" /> <label for="delete_products">delete all products from selected categories</label>
	</div>			
	<div>
		{{ csrf_field() }}
		<button type="submit" class="btn btn-default" onClick="return confirm('Confirm deletion')">Proceed</button>
	</div>
</form>

@stop