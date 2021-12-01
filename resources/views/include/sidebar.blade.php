<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
	<a href="{{ route('dashboard') }}" class="brand-link">
		<img src="{{ url('public/assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">LaravelPRODUCT 3</span>
	</a>
	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ url('public/assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
			</div>				
			<div class="info">
				@if(isset(Auth::user()->email))
					<a href="#" class="d-block">{{ Auth::user()->name }}</a>
				@else
					<script>window.location = "{{ url('/') }}";</script>
				@endif
			</div>
		</div>
		<!-- SidebarSearch Form -->
		<div class="form-inline">
			<div class="input-group" data-widget="sidebar-search">
				<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
				<div class="input-group-append">
					<button class="btn btn-sidebar">
						<i class="fas fa-search fa-fw"></i>
					</button>
				</div>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
            		<a href="{{ route('categories') }}" class="nav-link {{ Route::currentRouteNamed('categories') || Route::currentRouteNamed('catadd') || Route::currentRouteNamed('catstore') || Route::currentRouteNamed('catstore') || Route::currentRouteNamed('catedit') || Route::currentRouteNamed('catdelete') ? 'active' : '' }}">
              			<i class="nav-icon fa fa-list-alt"></i>
              			<p>
                			Category
              			</p>
            		</a>
          		</li>
				<li class="nav-item">
            		<a href="{{ route('products') }}" class="nav-link {{ Route::currentRouteNamed('products') || Route::currentRouteNamed('productadd') || Route::currentRouteNamed('productstore') ||Route::currentRouteNamed('productedit') ||Route::currentRouteNamed('productdelete') ? 'active' : '' }} ">
              			<i class="nav-icon fa fa-list-alt"></i>
              			<p>
                			Products
              			</p>
            		</a>
          		</li>
				  <li class="nav-item">
            		<a href="{{ route('logout') }}" class="nav-link">
					<i class="fas fa-sign-out-alt"></i>
              			<p>
							Logout
              			</p>
            		</a>
          		</li>

			</ul>
		</nav>
	</div>
</aside>
