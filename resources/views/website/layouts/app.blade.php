<!doctype html>
<html lang="en">

  <head>
    @include('website.partials.header')
  </head>

    <body>


        @yield('content')

        @stack('footer')
    </body>
</html>