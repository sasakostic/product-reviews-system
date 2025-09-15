<ul class="nav nav-pills nav-stacked">
    <li>
        <strong>{{ Auth::user()->username }}</strong>
    </li>
    <li class="{{ ($sidebar_highlight == '') ? 'active' : '' }}">
        <a href="{{ url('account') }}"><i class="fa fa-user"></i> My Account</a>
    </li>
    <li class="divider">&nbsp;</li>
    <li class="{{ ($sidebar_highlight == 'favorites') ? 'active' : '' }}">
        <a href="{{ url('account/favorites') }}"><i class="fa fa-star"></i> My Favorites</a>        
    </li>
    <li class="{{ ($sidebar_highlight == 'lists') ? 'active' : '' }}" style="margin-left: 20px;">
        <a href="{{ url('account/lists') }}"><i class="fa fa-list"></i> Product lists</a>        
    </li>
    <li class="{{ ($sidebar_highlight == 'reviews') ? 'active' : '' }}">
        <a href="{{ url('account/reviews') }}"><i class="fa fa-comment"></i> My Reviews</a>
    </li>
    @if($settings->users_list_product_images)
    <li class="{{ ($sidebar_highlight == 'images') ? 'active' : '' }}">
        <a href="{{ url('account/images') }}"><i class="fa fa-photo"></i> My Images</a>
    </li>
    @endif
</ul>