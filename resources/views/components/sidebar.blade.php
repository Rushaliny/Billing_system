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
                                    <span class="user-level">
                                        {{-- {{ auth()->user()->name }} --}}
                                    </span>
								</span>
							</a>

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
						<li class="nav-item {{ request()->routeIs('paybill.index') ? 'active' : '' }}">
							<a href="{{ route('paybill.index') }}">
								<i class="la la-paypal"></i>
								<p>Pay Bills</p>
								{{-- <span class="badge badge-count">50</span> --}}
							</a>
						</li>

                        <li class="nav-item {{ request()->routeIs('show.index') ? 'active' : '' }}">
							<a href="{{ route('show') }}">
                                <i class="la la-file-text"></i>
								<p>Bills Details</p>
								{{-- <span class="badge badge-count">6</span> --}}
							</a>
						</li>

						<li class="nav-item {{ request()->routeIs('reports.index') ? 'active' : '' }}">
							<a href="{{ route('reports.index') }}">
								<i class="la la-hourglass-1"></i>
								<p>Reports</p>
								{{-- <span class="badge badge-count">6</span> --}}
							</a>
						</li>

					</ul>
				</div>
			</div>
