<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/spinner.css') }}">
    <script>
        document.onreadystatechange = function () {
            if (document.readyState === "complete") {
                document.querySelector("#spinner").style.display = "none"
            }
        }
    </script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Firebase UI CSS -->
    <link rel="stylesheet" href="{{ asset('packages/line-awesome/css/line-awesome.min.css') }}">
    <link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/4.6.1/firebase-ui-auth.css" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <title>E-Commerce</title>
</head>
<body>
    <x-spinner></x-spinner>
    <section id="app">
        @yield('content')
    </section>
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('script')
</body>
</html>
