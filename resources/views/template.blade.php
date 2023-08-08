<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Invoice Generator</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            .navbar-nav > li > a:hover {
                color: red;
            }
        </style>

        @yield('css')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.min.js" integrity="sha512-RNRN2BvL+sAzL+g0TJjCCfPzzpIg+UOIMcUxG6zF1J+Dy9L7QO54Oy6JjR6ckZ/n5DF7Q5x5PzV7+dRlsqbXgw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Invoice Generator</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="navbar-item">
                                <a class="nav-link" aria-current="page" href="/all-invoices">All Invoices</a>
                            </li>
                            <li class="navbar-item">
                                <a class="nav-link" href="/form">Create</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <div class="container-fluid">
            <div class="row">
                @yield('content')
            </div>
        </div>

        <script type="text/javascript">
            document.querySelector("a[href='/{{Request::segment(1)}}']")?.classList.add('active');    
            window.jsPDF = window.jspdf.jsPDF
        </script>
        @yield("javascript")
    </body>
</html>
