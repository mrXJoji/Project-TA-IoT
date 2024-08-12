<div class="sidebar">
  <!-- Sidebar user panel (optional) -->

  <!-- Sidebar Menu -->
  <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
          <li class="nav-item">
              <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                  <i class="fas fa-home nav-icon"></i>
                  <p>DASHBOARD</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ url('datasensor') }}" class="nav-link {{ request()->is('datasensor') ? 'active' : '' }}">
                  <i class="fas fa-thermometer-half nav-icon"></i>
                  <p> DATA SENSOR</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ url('rekap') }}" class="nav-link {{ request()->is('rekap') ? 'active' : '' }}">
                  <i class="fas fa-file-alt nav-icon"></i>
                  <p>HASIL KEPUTUSAN</p>
              </a>
          </li>
      </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
