@extends('dev/layout')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<script type="text/javascript">
    $(function(){

        $(':checkbox[name="reviews[]"]').change(function(){
            if($(':checkbox[name="reviews[]"]:checked').length > 0) $('#delete_reviews').prop('disabled', false); 
            else $('#delete_reviews').prop('disabled', true);
            if($(this).prop("checked")) $('#review_row'+$(this).val()).addClass('active'); else $('#review_row'+$(this).val()).removeClass('active');
        });
        $(':checkbox[name="select_all_boxes"]').change(function(){
            $(".reviews_checkbox").prop('checked', $(this).prop("checked"));
            $("#delete_reviews").prop('disabled', !$(this).prop("checked"));
            if($(this).prop("checked")) $('.review_row').addClass('active'); else $('.review_row').removeClass('active');
        });
    });//document ready
</script>

<div>  
	<form action="dev/process" method="post">

		<div class="checkbox">
			<a href="dev/reset-installation" class="btn btn-xs btn-default">Reset installation</a>
		</div>

		<div>
			<div class="checkbox">
				<input type="checkbox" name="select_all_boxes" id="select_all_boxes" class="styled" value="" />
				<label for="select_all_boxes">Select all</label>
			</div>
		</div>

		<div class="checkbox">
			<input type="checkbox" name="empty_db_tables" id="empty_db_tables" name="" checked value="1" />
			<label for="empty_db_tables">Empty db tables</label>
			<a href="dev/empty-db-tables" class="btn btn-xs btn-default">Go</a>
		</div>

		<div class="checkbox">
			<input type="checkbox" name="remove_db_tables" id="remove_db_tables" name="" checked value="1" />
			<label for="remove_db_tables">Remove db tables</label>
			<a href="dev/remove-db-tables" class="btn btn-xs btn-default">Go</a>
		</div>

		<div class="checkbox">
			<input type="checkbox" name="db_migration" id="db_migration" checked value="1" />
			<label for="db_migration">Db migration</label>
			<a href="dev/db-migration" class="btn btn-xs btn-default">Go</a>
		</div>

		<div class="checkbox">
			<input type="checkbox" name="db_seed" id="db_seed" checked value="1" />
			<label for="db_seed">Db seed</label>
		</div>

		<div class="checkbox">
			<input type="checkbox" name="random_users_data" id="random_users_data" checked value="1" />
			<label for="random_users_data">Enter random user data</label>
		</div>

		<div class="checkbox">
			<input type="checkbox" name="random_categories_data" id="random_categories_data" checked value="1" />
			<label for="random_categories_data">Enter random categories data</label>
		</div>

		<div class="checkbox">
			<input type="checkbox" name="random_brands_data" id="random_brands_data" checked value="1" />
			<label for="random_brands_data">Enter random brands data</label>
		</div>

		<div class="checkbox">
			<input type="checkbox" name="random_products_data" id="random_products_data" checked value="1" />
			<label for="random_products_data">Enter random products data</label>
		</div>

		<div class="checkbox">
			<input type="checkbox" name="random_reviews_data" id="random_reviews_data" checked value="1" />
			<label for="random_reviews_data">Enter random reviews data</label>
		</div>

		<div class="checkbox">
			<button type="submit" class="btn btn-primary" />Process</button>
		</div>


		<div class="checkbox">
			<a href="dev/report-all-reviews" class="btn btn-xs btn-default">Report All Reviews</a>
		</div>

		<div class="checkbox">
			<a href="dev/responsive-design" class="btn btn-xs btn-default">Responsive design</a>
		</div>

		<input type="hidden" name="_token" value="{{ csrf_token() }}">

	</form>
</div>

@stop