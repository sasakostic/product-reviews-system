<div style="margin-bottom:10px">
	<ul class="nav nav-tabs" role="tablist">
		<li id="submenu_general" @if(isset($submenu_highlight) && $submenu_highlight=='submenu_general') class="active" @endif>
			<a href="{{ url('admin/settings') }}">General</a>
		</li>
		<li id="submenu_mail" @if(isset($submenu_highlight) && $submenu_highlight=='submenu_mail') class="active" @endif>
			<a href="{{ url('/admin/settings/mail') }}"><i class="fa fa-envelope"></i> Mail</a>
		</li>
		<li id="submenu_products" @if(isset($submenu_highlight) && $submenu_highlight=='submenu_products') class="active" @endif>
			<a href="{{ url('/admin/settings/products') }}"><i class="fa fa-list"></i> Products</a>
		</li>
		<li id="submenu_reviews" @if(isset($submenu_highlight) && $submenu_highlight=='submenu_reviews') class="active" @endif>
			<a href="{{ url('/admin/settings/reviews') }}"><i class="fa fa-comment"></i> Reviews</a>
		</li>
		<li id="submenu_registration" @if(isset($submenu_highlight) && $submenu_highlight=='submenu_registration') class="active" @endif>
			<a href="{{ url('/admin/settings/registration') }}"><span class="glyphicon glyphicon-user"> Registration</a>
		</li>
		<li id="submenu_contact" @if(isset($submenu_highlight) && $submenu_highlight=='submenu_contact') class="active" @endif>
			<a href="{{ url('/admin/settings/contact') }}"><span class="glyphicon glyphicon-comment"> Contact</a>
		</li>
	</ul>
</div>