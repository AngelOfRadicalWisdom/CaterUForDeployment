<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title_text')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            @yield('js_code')
        });
    </script>
</head>
<body>
    <section class="row">
        <section class="col-md-12">
                <header>
                    <h1>
                        <span style="font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif">
                            &emsp; ABCCO HRIS (Human Resource Information System)
                        </span>
                    </h1>
                </header>
        </section>
    </section>
    <section class="row">
        <section class="col-md-2">
            @include('nav')
        </section>
        <section class="col-md-10">
            @yield('content_output')
        </section>
    </section>
</body>
</html>
