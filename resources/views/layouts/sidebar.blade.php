<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ Request::segment(2) == 'dashboard' ? 'active':'collapsed' }}" href="{{ url('admin/dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->


      <li class="nav-heading">Categories</li>

      <li class="nav-item">
        <a class="nav-link {{ Request::segment(2) == 'create' ? 'active':'collapsed' }}" href="{{ route('categories.create') }}">
          <i class="bi bi-person"></i>
          <span>Categories</span>
        </a>
      </li><!-- End Profile Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->