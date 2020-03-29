<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <meta property="og:type" content="website" />
    @if($city)
    <meta property="og:url" content="{{Request::url().'?city='.$city->name_en}}" />
    <meta property="og:title" content="{{$city->name_si.' ප්‍රදේශයේ ඔබට නිවසටම ගෙන්වා ගත හැකි භාණ්ඩ හා සේවා.'}}" />
    <meta property="og:description"
        content="{{$city->name_si.' ප්‍රදේශයේ ඔබට නිවසටම ගෙන්වා ගත හැකි භාණ්ඩ හා සේවා.'}}" />
    <meta property="og:image" content="{{ asset('images/city-shares/city-share-'.$city->id.'.png') }}" />
    @else
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:title" content="{{'ඔබට නිවසටම ගෙන්වා ගත හැකි භාණ්ඩ හා සේවා.'}}" />
    <meta property="og:description" content="{{'ඔබට නිවසටම ගෙන්වා ගත හැකි භාණ්ඩ හා සේවා.'}}" />
    <meta property="og:image" content="{{ asset('images/share-image.png') }}" />
    @endif
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="fb:app_id" content="895981437519151" />

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/css/fileinput.min.css"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/themes/explorer/theme.min.css"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css" rel="stylesheet">
    <link href="{{ asset('js/tags-input/dist/jquery.tagsinput-revisited.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/system.css?version=1') }}" rel="stylesheet">
</head>

<body>
    <div id="fb-root"></div>
    <script src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script>
        FB.init({
          appId   : 895981437519151,
          status  : true,
          xfbml   : true,
          version : 'v2.9'
        });
        FB.AppEvents.logPageView();
    </script>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{route('search')}}">
                    <i class="fa fa-search" aria-hidden="true"></i> Search
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="btn btn-success" href="javascript:void(0)" data-toggle="modal"
                                data-target="#add-pack-modal"><i class="fa fa-plus" aria-hidden="true"></i> Add Offer
                                <span class="sr-only">(current)</span></a>
                        </li>

                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0)" data-toggle="modal"
                                data-target="#about-us-modal">About Us <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        @include('components.aboutUsModal')
        @include('components.addOfferModal')
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/themes/fa/theme.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
    <script src="{{ asset('js/tags-input/dist/jquery.tagsinput-revisited.min.js') }}"></script>
    <script src="{{ asset('js/search.js?version=1') }}"></script>
</body>

</html>
