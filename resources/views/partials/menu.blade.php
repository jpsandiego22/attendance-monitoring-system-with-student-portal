
@if(Auth::user()->user_type == 0 || Auth::user()->user_type == 1)
    @include('partials.menu-admin')
@elseif(Auth::user()->user_type == 2)

@endif
<div class="az-header-right">
    <a href="https://www.bootstrapdash.com/demo/azia-free/docs/documentation.html" target="_blank" class="az-header-search-link"><i class="far fa-file-alt"></i></a>
    <a href="" class="az-header-search-link"><i class="fas fa-search"></i></a>
    <div class="az-header-message">
    <a href="#"><i class="typcn typcn-messages"></i></a>
    </div><!-- az-header-message -->
    <div class="dropdown az-header-notification">
    <a href="" class="new"><i class="typcn typcn-bell"></i></a>
    <div class="dropdown-menu">
        <div class="az-dropdown-header mg-b-20 d-sm-none">
        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
        </div>
        <h6 class="az-notification-title">Notifications</h6>
        <p class="az-notification-text">You have 2 unread notification</p>
        <div class="az-notification-list">
        <div class="media new">
            <div class="az-img-user"><img src="../img/faces/face2.jpg" alt=""></div>
            <div class="media-body">
            <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
            <span>Mar 15 12:32pm</span>
            </div><!-- media-body -->
        </div><!-- media -->
        <div class="media new">
            <div class="az-img-user online"><img src="../img/faces/face3.jpg" alt=""></div>
            <div class="media-body">
            <p><strong>Joyce Chua</strong> just created a new blog post</p>
            <span>Mar 13 04:16am</span>
            </div><!-- media-body -->
        </div><!-- media -->
        <div class="media">
            <div class="az-img-user"><img src="../img/faces/face4.jpg" alt=""></div> 
            <div class="media-body">
            <p><strong>Althea Cabardo</strong> just created a new blog post</p>
            <span>Mar 13 02:56am</span>
            </div><!-- media-body -->
        </div><!-- media -->
        <div class="media">
            <div class="az-img-user"><img src="../img/faces/face5.jpg" alt=""></div>
            <div class="media-body">
            <p><strong>Adrian Monino</strong> added new comment on your photo</p>
            <span>Mar 12 10:40pm</span>
            </div><!-- media-body -->
        </div><!-- media -->
        </div><!-- az-notification-list -->
        <div class="dropdown-footer"><a href="">View All Notifications</a></div>
    </div><!-- dropdown-menu -->
    </div><!-- az-header-notification -->
    <div class="dropdown az-profile-menu">
           @if(Auth::user()->detail->img == null)
                <a href="" class="az-img-user"><img src="{{ asset('img/faces/face0.jpg') }}" alt=""></a>
            @else
                <a href="" class="az-img-user"><img src="{{asset(Auth::user()->detail->img)}}" alt=""></a>
            @endif
    
    <div class="dropdown-menu">
        <div class="az-dropdown-header d-sm-none">
        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
        </div>
        <div id="app_img" class="az-header-profile">
            <div class="az-img-user position-relative d-inline-block">
                <img src="{{ asset(optional(Auth::user()->detail)->img ?? 'img/faces/face0.jpg') }}" class="img-fluid" alt="User Image">
            </div>
            <h6>{{  strtoupper(explode(' ', Auth::user()->detail->name)[0]); }}</h6>
            <span>{{ Auth::user()->type->description }}</span>
            <form @submit.prevent="img_upload" enctype="multipart/form-data">
                @csrf
                <input type="file" ref="file" name="img" hidden @change="handleFile">
                <button type="button"
                    class="btn btn-outline-dark btn-sm rounded-circle"
                    @click="$refs.file.click()">
                    <i class="typcn typcn-upload"></i>
                </button>
            </form>
           
        </div><!-- az-header-profile -->

        <a href="#" data-toggle="modal" data-target="#myProfileModal" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
        <a href="#" data-toggle="modal" data-target="#changePasswordModal" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account Settings</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf 
            <button type="submit" class="dropdown-item"><i class="typcn typcn-power-outline"></i> Sign Out</button>
        </form>
        
    </div><!-- dropdown-menu -->
    </div>
</div><!-- az-header-right -->
