<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:url" content="https://help.area51projects.com/login" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Stay Home, Stay Safe - We will back you." />
    <meta property="og:description" content="Search delivery food packs in your area." />
    <meta property="og:image" content="{{ asset('images/share-image.png') }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="fb:app_id" content="895981437519151" />

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('js/app.js') }}">

    </script>
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
    <link href="{{ asset('css/system.css') }}" rel="stylesheet">
</head>

<body>
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
                                data-target="#add-pack-modal"><i class="fa fa-plus" aria-hidden="true"></i> Add Pack
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

        <div class="modal fade" id="about-us-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">About Us</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <p>This was developed for as a support to fight Covid-19 outbreak in Sri Lanka. Stay Home Stay
                            Safe. Feel free to suggest bugs, features and
                            improvements.</p>
                        Developed by <a href="https://www.facebook.com/randika.srimal" target="blank">Randika
                            Srimal</a>.
                        <br />
                        Contact <a href="mailto:email2randika@gmail.com?Subject=About%20Food%20Delivery%20System"
                            target="_top">email2randika@gmail.com</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add-pack-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Pack</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="save-flyer-form" action="{{ route('flyers.add') }}">
                            @csrf
                            <div class="file-loading">
                                <input type="file" accept="image/*" id="file"
                                    data-upload-url="{{route('flyers.tryUpload')}}">
                            </div>
                            <input required type="hidden" id="flyer-file-name" name="flyer_file_name">
                            <br />
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Delivery Areas :</label>
                                <br />
                                <input required type="text" id="delivery-areas" name="areas">
                            </div>
                            <div class="form-group">
                                <label>Details :</label>
                                <textarea class="form-control" name="details"
                                    placeholder="Price, Contact Details, etc"></textarea>
                            </div>
                            <button type="button" id="submit-flyer-btn"
                                class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/themes/fa/theme.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
    <script src="{{ asset('js/tags-input/dist/jquery.tagsinput-revisited.min.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
</body>

</html>
