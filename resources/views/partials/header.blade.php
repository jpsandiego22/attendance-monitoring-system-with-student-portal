<div class="az-header">
      <div class="container">
        <div class="az-header-left">
          <h2 class="az-logo"><a href="{{ Auth::user()->details == 2 ? route('student.home'): route('admin.home')}}">PO<span>R</span> TAL</a></h2>
          <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
        </div><!-- az-header-left -->
        @include('partials.menu')
      </div><!-- container -->
    </div><!-- az-header -->