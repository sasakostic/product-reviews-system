<script type="text/javascript" src="{{ url('assets/js/admin/unflag.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/js/login.js') }}"></script>

@include('login/modal')

<script type="text/javascript">
  $(function(){

    $(window).on('load', function() {
      if($(':checkbox[name="products[]"]:checked').length > 0) $('#delete_products').prop('disabled', false); 
    });
    
    $(':checkbox[name="products[]"]').change(function(){
      if($(':checkbox[name="products[]"]:checked').length > 0) $('#delete_products').prop('disabled', false); 
      else $('#delete_products').prop('disabled', true);
      if($(this).prop("checked")) $('#product_row'+$(this).val()).addClass('active'); else $('#product_row'+$(this).val()).removeClass('active');
    });

    $(':checkbox[name="select_all_products"]').change(function(){
      $(".products_checkbox").prop('checked', $(this).prop("checked"));
      $("#delete_products").prop('disabled', !$(this).prop("checked"));
      if($(this).prop("checked")) $('.product_row').addClass('active'); else $('.product_row').removeClass('active');
    });

    });//document ready
</script>

<form action="{{ url('admin/products/multiple-delete') }}" method="POST">

  <table class="table table-striped">
    <thead>
      <tr>
        <th style="vertical-align:middle">
         <div class="checkbox">
           <input type="checkbox" name="select_all_products" class="styled" value="" />
           <label></label>
         </div>
       </th>
       <th style="vertical-align:middle">Image</th>
       <th class="hidden-xs" style="vertical-align:middle">Brand</th>
       <th style="vertical-align:middle">Name</th>
       <th class="hidden-xs" style="vertical-align:middle">Category</th>
       <th class="hidden-xs col-md-2 col-lg-2" style="text-align:center; vertical-align:middle">Rating/reviews</th>
       <th class="hidden-xs" style="text-align:center; vertical-align:middle"><span class="glyphicon glyphicon-picture"></span></th>
       <th class="col-md-1 hidden-xs" style="text-align:center; vertical-align:middle"><span class="glyphicon glyphicon-user"></span></th>
       <th class="col-xs-1 hidden-xs" style="text-align:right; vertical-align:middle">

       </th>
     </tr>
   </thead>
   <tbody>

    @foreach($products as $product)
    <tr @if($product->reported == 1)class="warning"@endif @if($product->active == 0)class="danger"@endif id="product_row{{ $product->id }}" class="product_row">
      <td style="vertical-align:middle">
        <div class="checkbox">
          <input type="checkbox" name="products[]" class="styled products_checkbox" value="{{ $product->id }}" />
          <label></label>
        </div>
      </td>
      <td>
        <a href="{{ url('product/'.$product->id.'/'.$product->slug) }}" target="_blank"><img src="@if($product->image_id != FALSE){{ url('images/'.$product->id.'/sm_'.$product->image->file_name) }}@else{{ url('images/no_image.png') }}@endif"></a>
      </td>
      <td class="hidden-xs item-name">{{ $product->brand->name }}</td>
      <td class="col-md-3 item-name">
        <div>
          <a href="{{ url('product/'.$product->id.'/'.$product->slug) }}" target="_blank">{{ $product->name }}</a> @if($product->discontinued == 1)<span class="text-muted">(discontinued)</span>@endif
        </div>
        <div class="visible-xs pull-right">
          <a href="{{ url('admin/products') }}/{{ $product->id }}/edit" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit" style="color:silver"></span></a>          
        </div>
      </td>
      <td class="hidden-xs item-name">{{ $product->category->name }}</td>
      <td class="hidden-xs" align="center">
        @if(!$product->reviews->isEmpty() )
        @include('admin/products/rating')
        @else
        <span class="text-muted">@include('admin/products/rating')</span>
        @endif
      </td>
      <td class="hidden-xs" align="center">
        @if(!$product->images->isEmpty() )
        <a href="{{ url('admin/images?product_id='.$product->id) }}">{{ $product->images->count() }}</a>
        @else
        <span class="text-muted">0</span>
        @endif
      </td>
      <td class="hidden-xs item-name" align="center">
        <a href="{{ url('admin/products') }}?user={{ $product->user->username }}" @include('admin/products/user_hover') >{{ $product->user->username }}</a>
      </td>
      <td class="col-md-1 hidden-xs" align="right" style="vertical-align:middle">
        <a href="{{ url('admin/products/'.$product->id .'/edit') }}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit" style="color:silver"></span></a>                
      </td>
    </tr>
    @if($product->reported == 1)
    <tr>
      <td colspan="10">       
       <a href="javascript:unflag_product({{ $product->id }})" class="btn close" id="cross_{{$product->id}}">&times;</a>
       <div id="reported_{{ $product->id }}" class="alert alert-warning alert-block item-name" style="margin-top:-8px">

        @foreach($product->reports->take(100) as $report)
        <div class="text-muted" style="word-wrap: break-word;">
          <b>Reported by <a href="{{ url('admin/user/'.$report->user_id.'/details') }}">{{ $report->user->username }}</a> </b>
          <br />
          @if($report->reason <> ''){!! nl2br($report->reason) !!} @endif
          <br />
          <small>{{ $report->created_at }} </small>

          <br /><br />                    
        </div>
        @endforeach        
      </div>
    </td>
  </tr>
  @endif
  @endforeach
  <tr>
    <td colspan="10">
     {{ csrf_field() }}
     <button type="submit" name="submit_button" id="delete_products" value="delete_products" class="btn btn-devault btn-xs" onclick="return confirm('Confirm deletion of selected products');" disabled="true">Delete selected</button>
   </td>
 </tr>
</tbody>
</table>

</form>