<div class="sidebar">
				<div class="scrollbar-inner sidebar-wrapper">
					<div class="user">
						<div class="photo">
							<img src="assets/img/profile.jpg">
						</div>
						<div class="info">
							<a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									Administrator
									{{-- <span class="user-level">Administrator</span> --}}
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample" aria-expanded="true" style="">
								<ul class="nav">
									<li>
										<a href="#profile">
											<span class="link-collapse">My Profile</span>
										</a>
									</li>
									<li>
										<a href="#edit">
											<span class="link-collapse">Edit Profile</span>
										</a>
									</li>
									<li>
										<a href="#settings">
											<span class="link-collapse">Settings</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav">
						<li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
							<a href="{{ route('dashboard.index') }}">
								<i class="la la-dashboard"></i>
								<p>Dashboard</p>
								{{-- <span class="badge badge-count">5</span> --}}
							</a>
						</li>
						<li class="nav-item {{ request()->routeIs('chargers.index') ? 'active' : '' }}">
							<a href="{{ route('chargers.index') }}">
								<i class="la la-money"></i>
								<p>Chargers of Bills</p>
								{{-- <span class="badge badge-count">14</span> --}}
							</a>
						</li>
						<li class="nav-item {{ request()->routeIs('forms') ? 'active' : '' }}">
							<a href="forms.html">
								<i class="la la-paypal"></i>
								<p>Pay Bills</p>
								{{-- <span class="badge badge-count">50</span> --}}
							</a>
						</li>
						<li class="nav-item {{ request()->routeIs('tables') ? 'active' : '' }}">
							<a href="tables.html">
								<i class="la la-hourglass-1"></i>
								<p>Reports</p>
								{{-- <span class="badge badge-count">6</span> --}}
							</a>
						</li>

					</ul>
				</div>
			</div>
