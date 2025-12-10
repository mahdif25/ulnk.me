			<?php 
				$linko =  strval( explode('?', $_SERVER['REQUEST_URI'], 2)[0]) ;
				$pages = array("_clients.php", "_products.php", "_deals.php", "_rewards.php");
				$pages_a = array("", "", "", "");
				$max_ = count($pages);
				
				for ($x = 0; $x <= $max_; $x++) {
					
					if (strpos($linko, $pages[$x]) !== false) {
						$pages_a[$x] = ' active' ;
						break ;
					}
			 	}

				?>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
          <span class="align-middle">Admin0</span>
        </a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Pages
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="#">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            </a>
					</li>

					<li class="sidebar-item<?=$pages_a[0]?>">
						<a class="sidebar-link" href="<?=$pages[0]?>">
              <i class="align-middle" data-feather="users"></i> <span class="align-middle">Clients</span>
            </a>
					</li>

						<li class="sidebar-item<?=$pages_a[1]?>">
						<a class="sidebar-link" href="<?=$pages[1]?>">
              <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">Products</span>
            </a>
					</li>
					
					
					
					<li class="sidebar-item<?=$pages_a[2]?>">
						<a class="sidebar-link" href="<?=$pages[2]?>">
              <i class="align-middle" data-feather="slack"></i> <span class="align-middle">Deals</span>
            </a>
					</li>

					<li class="sidebar-item<?=$pages_a[3]?>">
						<a class="sidebar-link" href="<?=$pages[3]?>">
              <i class="align-middle" data-feather="star"></i> <span class="align-middle">Rewards</span>
            </a>
					</li>



				</ul>


			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						
					
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <img src="img/avatars/avatar.png" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark">User</span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
							
								<div class="dropdown-divider"></div>
								
								
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Log out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>