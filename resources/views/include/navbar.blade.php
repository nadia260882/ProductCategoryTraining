<!-- Preloader -->

<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ url('public/assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav ">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

      <li>
        <a href="/Project/Laravel-Layout">Home</a> >>              
  <?php $link = "/Project/Laravel-Layout" ?>
@for($i = 1; $i <= count(Request::segments()); $i++)
    @if($i < count(Request::segments()) & $i > 0)
    <?php $link .= "/" . Request::segment($i); ?>
    <a href="<?= $link ?>">{{ ucwords(str_replace('-',' ',Request::segment($i)))}}</a> >>
    @else {{ucwords(str_replace('-',' ',Request::segment($i)))}}
    @endif
@endfor
</li>
  </ul>
</nav>
  <!-- /.navbar -->

