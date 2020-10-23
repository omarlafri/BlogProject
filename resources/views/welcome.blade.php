<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <script>
    ( function(){
        window.Laravel={
            csrfToken : '{{csrf_token()}}'
        };
    })();
    
    </script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="/css/all.css">

       
    </head>
    <body>
        
            <div id="app">
            <mainapp></mainapp>
            </div>
    </body>
    
    <script src="{{mix('/js/app.js')}} "></script>
</html>
