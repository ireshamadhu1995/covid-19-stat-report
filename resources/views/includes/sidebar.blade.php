<div class="sidebar">
    <div class="sidebar-inner">
        <div
            class="sidebar-close d-block d-lg-none">
            <i class="far fa-times-circle"></i>
        </div>
        <div class="logo-wrap">
            <img src="{{asset('images/dashboard_image.png')}}" alt="logo" />
        </div>
        <div class="link-item-wrap">
            <a href="{{route('help-guide.index')}}" class="item-link {{(request()->is('page')) ? 'active' : ''}}">
                <i class="fas fa-home"></i>
                <span>Pages</span>
            </a>


{{--            <a href="{{route('content.index')}}" class="item-link {{(request()->is('content')) ? 'active' : ''}}">--}}
{{--                <i class="fas fa-umbrella-beach"></i>--}}
{{--                <span>Contents</span>--}}
{{--            </a>--}}


        </div>
    </div>
</div>
