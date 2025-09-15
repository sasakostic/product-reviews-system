@extends('admin/layout')
@section('title', 'Dashboard')
@section('content')

<div class="row">
  <ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Admin</a></li>
    <li class="active">Overview</li>        
</ol>
</div>

<div class="search-box form-group visible-xs row">
    <form method="GET" action="{{ url('admin/search') }}">
        <div class="input-group">
            <input type="text" name="search_terms_all" class="form-control" value="{{ Input::get('search_terms_all') }}" placeholder="Search..." required>

            <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </form>
</div>

<div class="row">

 <div class="col-lg-3 col-md-6">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-comment fa-3x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="pull-left">
                        @if($reported_reviews_count > 0)
                        <div>
                            <a href="{{ url('admin/reviews?reported=1') }}" class="label label-warning">{{ $reported_reviews_count }} reported</a>
                        </div>
                        @endif  
                        @if($unpublished_reviews_count > 0)
                        <div>
                            <a href="{{ url('admin/reviews?published=0') }}" class="label label-warning">{{ $unpublished_reviews_count }} inactive</a>
                        </div>
                        @endif  
                        @if($new_reviews_count > 0)
                        <div>
                            <a href="{{ url('admin/reviews') }}" class="label label-info">{{ $new_reviews_count }} new</a>
                        </div>
                        @endif
                    </div>
                    <a href="{{ url('admin/reviews') }}" class="white">
                        <div class="overview-cnt">{{ $reviews_count }}</div>
                        <div>Reviews</div>
                    </a>
                </div>                        
            </div>
        </div>
    </div>    


</div>


<div class="col-lg-3 col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-camera fa-3x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="pull-left">
                        @if($new_images_count > 0)
                        <div>
                            <a href="{{ url('admin/images') }}" class="label label-info">{{ $new_images_count }} new</a>
                        </div>
                        @endif
                    </div>
                    <a href="{{ url('admin/images') }}" class="white">
                        <div class="overview-cnt">{{ $images_count }}</div>
                        <div>Images</div>
                    </a>
                </div>                        
            </div>
        </div>
    </div>           
</div>

<div class="col-lg-3 col-md-6">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-list fa-3x"></i>
                    <div>
                     <a href="{{ url('admin/products/create') }}" class="btn btn-success btn-xs">Add new</a>
                 </div>
             </div>
             <div class="col-xs-9 text-right">
                <div class="pull-left">
                    @if($reported_products_count > 0)
                    <div>
                        <a href="{{ url('admin/products?reported=1') }}" class="label label-warning">{{ $reported_products_count }} reported</a>
                    </div>
                    @endif    
                    @if($inactive_products_count > 0)
                    <div>
                        <a href="{{ url('admin/products?published=0') }}" class="label label-warning">{{ $inactive_products_count }} inactive</a>
                    </div>
                    @endif        
                    @if($new_products_count > 0)
                    <div>
                        <a href="{{ url('admin/products') }}" class="label label-info">{{ $new_products_count }} new</a>
                    </div>   
                    @endif
                </div>
                <a href="{{ url('admin/products') }}" class="white">
                    <div class="overview-cnt">{{ $products_count }}</div>
                    <div>Products</div>                            
                </a>
            </div>                        
        </div>
    </div>
</div>

</div>

</div>

<div class="row">

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="pull-left">
                            @if($new_users_count > 0)
                            <div>
                                <a href="{{ url('admin/users') }}" class="label label-info">{{ $new_users_count }} new</a>
                            </div>   
                            @endif
                        </div>
                        <a href="{{ url('admin/users') }}">
                            <div class="overview-cnt">{{ $users_count }}</div>
                            <div>Users</div>
                        </a>
                    </div>                        
                </div>
            </div>
        </div>    
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-th fa-3x"></i>
                        <div>
                         <a href="{{ url('admin/categories/create') }}" class="btn btn-success btn-xs">Add new</a>
                     </div>
                 </div>
                 <div class="col-xs-9 text-right">
                     <a href="{{ url('admin/categories') }}" >
                         <div class="overview-cnt">{{ $categories_count }}</div>
                         <div>Categories</div>
                     </a>
                 </div>                        
             </div>
         </div>
     </div>        
 </div>

 <div class="col-lg-3 col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-gift fa-3x"></i>
                    <div>
                     <a href="{{ url('admin/brands/create') }}" class="btn btn-success btn-xs">Add new</a>
                 </div>
             </div>
             <div class="col-xs-9 text-right">
                <a href="{{ url('admin/brands') }}">
                 <div class="overview-cnt">{{ $brands_count }}</div>
                 <div>Brands</div>
             </a>
         </div>                        
     </div>
 </div>
</div>
</div>

<div class="visible-xs col-lg-3 col-md-6">
    <a href="{{ url('admin/widgets') }}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-cogs fa-2x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div>Widgets</div>
                    </div>                        
                </div>
            </div>
        </div>
    </a>
</div>

<div class="visible-xs col-lg-3 col-md-6">
    <a href="{{ url('admin/pages') }}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-2x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div>Pages</div>
                    </div>                        
                </div>
            </div>
        </div>
    </a>
</div>

<div class="visible-xs col-lg-3 col-md-6">
    <a href="{{ url('admin/settings') }}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-cog fa-2x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div>Settings</div>
                    </div>                        
                </div>
            </div>
        </div>
    </a>
</div>

</div>
<div class="row">
    <div class="col-md-3">
        <div>Last 7 days:</div>    
        <div>Products: {{ $last_7_days_products }}</div>
        <div>Reviews: {{ $last_7_days_reviews }}</div>
        <div>Images: {{ $last_7_days_images }}</div>
        <div>Users: {{ $last_7_days_users }}</div>
    </div>
    <div class="col-md-3">
        <div>Last 30 days:</div>    
        <div>Products: {{ $last_30_days_products }}</div>
        <div>Reviews: {{ $last_30_days_reviews }}</div>
        <div>Images: {{ $last_30_days_images }}</div>
        <div>Users: {{ $last_30_days_users }}</div>
    </div>
    <div class="col-md-3">
        <div>Last 365 days:</div>    
        <div>Products: {{ $last_365_days_products }}</div>
        <div>Reviews: {{ $last_365_days_reviews }}</div>
        <div>Images: {{ $last_365_days_images }}</div>
        <div>Users: {{ $last_365_days_users }}</div>
    </div>
</div>
@stop