<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.head')
</head>
<body>
<div id="app">
    <div class="row g-0">
        <div class="col-md-12 col-lg-3 col-xl-2 p-0">
            @include('includes.sidebar')
        </div>
        <div class="col-md-12 col-lg-9 col-xl-10 p-0">
            @include('includes.navigation')
            <main class="main-content">
                @yield('content')
            </main>
        </div>
    </div>
</div>

<script>
    $(document).ready( function () {
        $( ".nav-menu" ).click(function() {
            $(".sidebar").toggleClass( "active" );
        });
        $( ".sidebar-close" ).click(function() {
            $(".sidebar").toggleClass( "active" );
        });
    } );
</script>
</body>
</html>
