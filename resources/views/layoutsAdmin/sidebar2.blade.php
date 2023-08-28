<nav id="mainnav-container">
	<div id="mainnav">


		<!--OPTIONAL : ADD YOUR LOGO TO THE NAVIGATION-->
		<!--It will only appear on small screen devices.-->
		<!--================================
		<div class="mainnav-brand">
			<a href="index.html" class="brand">
				<img src="img/logo.png" alt="Nifty Logo" class="brand-icon">
				<span class="brand-text">Nifty</span>
			</a>
			<a href="#" class="mainnav-toggle"><i class="pci-cross pci-circle icon-lg"></i></a>
		</div>
		-->



		<!--Menu-->
		<!--================================-->
		<div id="mainnav-menu-wrap">
			<div class="nano">
				<div class="nano-content">

					<!--Profile Widget-->
					<!--================================-->
					<div id="mainnav-profile" class="mainnav-profile">
						<div class="profile-wrap text-center">
							<div class="pad-btm">
								@auth
									@if(Auth::user()->user_photo)
										<img style="width: 50px; height: 50px; margin-bottom: 5px;" src="{{ asset('storage/photos/'.basename(Auth::user()->user_photo)) }}" alt="User Photo">
									@else
										<!-- Jika user tidak memiliki foto profil, tampilkan foto default atau placeholder -->
										<img style="width: 50px; height: 50px; margin-bottom: 5px;" src="{{ asset('assets/img/profile-photos/1.png') }}" alt="User Photo">
									@endif
								@endauth
								{{-- <img class="img-circle img-md" src="{{ asset('assets/img/profile-photos/1.png') }}" alt="Profile Picture"> --}}
							</div>
							<a href="#profile-nav" class="box-block" data-toggle="collapse" aria-expanded="false">
								{{-- <span class="pull-right dropdown-toggle">
									<i class="dropdown-caret"></i>
								</span> --}}
								@auth
									<p class="mnp-name">{{ Auth::user()->user_name }}</p>
									<span class="mnp-desc">{{ Auth::user()->user_email }}</span>
								@endauth
								{{-- <p class="mnp-name">Aaron Chavez</p>
								<span class="mnp-desc">aaron.cha@themeon.net</span> --}}
							</a>
						</div>
						{{-- <div id="profile-nav" class="collapse list-group bg-trans">
							<a href="#" class="list-group-item">
								<i class="demo-pli-male icon-lg icon-fw"></i> View Profile
							</a>
							<a href="#" class="list-group-item">
								<i class="demo-pli-gear icon-lg icon-fw"></i> Settings
							</a>
							<a href="#" class="list-group-item">
								<i class="demo-pli-information icon-lg icon-fw"></i> Help
							</a>
							<a href="#" class="list-group-item">
								<i class="demo-pli-unlock icon-lg icon-fw"></i> Logout
							</a>
						</div> --}}
					</div>


					<!--Shortcut buttons-->
					<!--================================-->
					{{-- <div id="mainnav-shortcut" class="hidden">
						<ul class="list-unstyled shortcut-wrap">
							<li class="col-xs-3" data-content="My Profile">
								<a class="shortcut-grid" href="#">
									<div class="icon-wrap icon-wrap-sm icon-circle bg-mint">
									<i class="demo-pli-male"></i>
									</div>
								</a>
							</li>
							<li class="col-xs-3" data-content="Messages">
								<a class="shortcut-grid" href="#">
									<div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
									<i class="demo-pli-speech-bubble-3"></i>
									</div>
								</a>
							</li>
							<li class="col-xs-3" data-content="Activity">
								<a class="shortcut-grid" href="#">
									<div class="icon-wrap icon-wrap-sm icon-circle bg-success">
									<i class="demo-pli-thunder"></i>
									</div>
								</a>
							</li>
							<li class="col-xs-3" data-content="Lock Screen">
								<a class="shortcut-grid" href="#">
									<div class="icon-wrap icon-wrap-sm icon-circle bg-purple">
									<i class="demo-pli-lock-2"></i>
									</div>
								</a>
							</li>
						</ul>
					</div> --}}
					<!--================================-->
					<!--End shortcut buttons-->


					<ul id="mainnav-menu" class="list-group">
			
						<!--Category name-->
						<li class="list-header">Navigation</li>
			
						
						{{-- <li class="{{ request()->is('admin/home*') ? 'active-sub' : '' }}">
							<a href="#">
								<i class="demo-pli-home"></i>
								<span class="menu-title">Home</span>
								<i class="arrow"></i>
							</a>

								<ul class="collapse {{ request()->is('admin/home*') ? 'in' : '' }}">
									<li class="{{ request()->is('admin/home*') ? 'active-link' : '' }}"><a href="{{ route('admin.home') }}">Home</a></li>
								</ul>
						</li>

						<li class="{{ request()->is('admin/role*','admin/user*') ? 'active-sub' : '' }}">
							<a href="#">
								<i class="fas fa-user"></i>
								<span class="menu-title">Master User</span>
								<i class="arrow"></i>
							</a>

								
								<ul class="collapse {{ request()->is('admin/role*', 'admin/user*') ? 'in' : '' }}">
									<li class="{{ request()->is('admin/role*') ? 'active-link' : '' }}"><a href="{{ route('role.index') }}">Role</a></li>
									<li class="{{ request()->is('admin/user*') ? 'active-link' : '' }}"><a href="{{ route('user.index') }}">User</a></li>
								</ul>
						</li>

						
							<li class="{{ request()->is('admin/menu*') ? 'active-sub' : '' }}">
								<a href="#">
									<i class="demo-pli-folder"></i>
									<span class="menu-title">Master Menu</span>
									<i class="arrow"></i>
								</a>
							
								
								<ul class="collapse {{ request()->is('admin/menu*') ? 'in' : '' }}">
									<li class="{{ request()->is('admin/menu') ? 'active-link' : '' }}"><a href="{{ route('menu.index') }}">Menu</a></li>
								</ul>
							</li>

							<li class="{{ request()->is('admin/transaksi*','admin/produk*','admin/kategori*','admin/aditional*','admin/toko*') ? 'active-sub' : '' }}">
								<a href="#">
									<i class="fas fa-utensils"></i>
									<span class="menu-title">Restoran</span>
									<i class="arrow"></i>
								</a>

								

								<ul class="collapse {{ request()->is('admin/transaksi*', 'admin/produk*', 'admin/kategori*', 'admin/aditional*', 'admin/toko*') ? 'in' : '' }}">
									<li class="{{ request()->is('admin/transaksi*') ? 'active-link' : '' }}"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
									<li class="{{ request()->is('admin/produk*') ? 'active-link' : '' }}"><a href="{{ route('produk.index') }}">Produk</a></li>
									<li class="{{ request()->is('admin/kategori*') ? 'active-link' : '' }}"><a href="{{ route('kategori.index') }}">Kategori</a></li>
									<li class="{{ request()->is('admin/aditional*') ? 'active-link' : '' }}"><a href="{{ route('aditional.index') }}">Aditional</a></li>
									<li class="{{ request()->is('admin/toko*') ? 'active-link' : '' }}"><a href="{{ route('toko.index') }}">Toko</a></li>
								</ul>
							</li>

							<li class="{{ request()->is('admin/laporan/produk*','admin/laporan/transaksi*') ? 'active-sub' : '' }}">
								<a href="#">
									<i class="fas fa-file"></i>
									<span class="menu-title">Laporan</span>
									<i class="arrow"></i>
								</a>
	
									
									<ul class="collapse {{ request()->is('admin/laporan/produk*', 'admin/laporan/transaksi*') ? 'in' : '' }}">
										<li class="{{ request()->is('admin/laporan/produk*') ? 'active-link' : '' }}"><a href="{{ route('laporan.laporanProduk') }}">Produk</a></li>
										<li class="{{ request()->is('admin/laporan/transaksi*') ? 'active-link' : '' }}"><a href="{{ route('laporan.laporanTransaksi') }}">Transaksi</a></li>
									</ul>
							</li> --}}

							@php
								$iconsByMenuName = [
									'Home' => 'fas fa-home',
									'Master User' => 'fas fa-user',
									'Master Menu' => 'fas fa-folder',
									'Restoran' => 'fas fa-utensils',
									'Laporan' => 'fas fa-file',
									

									// Tambahkan asosiasi lain di sini sesuai dengan nama dan ikon yang sesuai
								];

							@endphp

							@foreach ($menuItemsWithSubmenus as $menuItem)
							@php
								$isSubMenuActive = false;

								foreach ($menuItem['subMenus'] as $subMenu) {
									if (request()->is($subMenu->menu_link) || request()->routeIs($subMenu->menu_link)) {
										$isSubMenuActive = true;
										break;
									}
								}
							@endphp

							<li class="{{ $isSubMenuActive ? 'active-sub' : '' }}">
								<a href="#">
									@if (isset($iconsByMenuName[$menuItem['mainMenu']->menu_name]))
										<i class="{{ $iconsByMenuName[$menuItem['mainMenu']->menu_name] }}"></i>
									@else
										<i class="fas fa-home"></i> <!-- Ini adalah contoh ikon default -->
									@endif
									<span class="menu-title">{{ $menuItem['mainMenu']->menu_name }}</span>
									<i class="arrow"></i>
								</a>
								@if ($menuItem['subMenus']->count() > 0)
									<ul class="collapse {{ $isSubMenuActive ? 'in' : '' }}">
										@foreach ($menuItem['subMenus'] as $subMenu)
											<li class="{{ request()->is($subMenu->menu_link) || request()->routeIs($subMenu->menu_link) ? 'active-link' : '' }}">
												<a href="{{ route($subMenu->menu_link) }}">
													{{ $subMenu->menu_name }}
												</a>
												{{-- <a href="{{ route($subMenu->menu_link, ['menu_id' => $subMenu->menu_id]) }}">
													{{ $subMenu->menu_name }}
												</a> --}}
												
											</li>
										@endforeach
									</ul>
								@endif
							</li>
							@endforeach
						</ul>
				</div>
			</div>
		</div>
		<!--================================-->
		<!--End menu-->
		
	</div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
	document.addEventListener("DOMContentLoaded", function() {
	  const masterMenuCollapse = document.getElementById("masterMenuCollapse");
	  const masterMenuLink = document.querySelector(".nav-item[data-toggle='collapse'] .nav-link");
  
	  // Cek apakah dropdown Master Menu harus ditampilkan saat halaman dimuat
	  if (masterMenuLink.classList.contains("active")) {
		masterMenuCollapse.classList.add("show");
	  }
  
	  masterMenuLink.addEventListener("click", function(event) {
		event.preventDefault();
  
		// Toggle collapse secara manual
		masterMenuCollapse.classList.toggle("show");
	  });
  
	  // Tambahkan event listener untuk menutup dropdown saat klik di area lain
	  document.addEventListener("click", function(event) {
		const target = event.target;
  
		// Cek apakah target adalah area di luar dropdown dan tidak ada elemen masterMenuLink yang diklik
		if (!target.closest("#masterMenuCollapse") && !target.classList.contains("nav-link")) {
		  masterMenuCollapse.classList.remove("show");
		}
	  });
	});
  </script>
