<!--★共通レイアウト-->


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <script src="{{mix('js/app.js')}}" defer></script>
        
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        
        <link href="{{mix('css/app.css')}}" rel="stylesheet">
        
    </head>
    <body>
        <!--app.jsでvueとつなげるためにel: '#app'と紐づいている-->
        <div id="app">
            @component('components.header')
            @endcomponent
            
            @component('components.flash')
            @endcomponent
            
            <main>
                <div class="container-fruid h-100 p-2 d-flex flex-column">
                    @yield('content')
                </div>
            </main>
            
            @component('components.footer')
            @endcomponent
            
        </div>
    </body>
    

    
</html>