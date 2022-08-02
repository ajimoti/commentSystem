<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>A Comment system</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    screens: {
                    sm: '480px',
                    md: '768px',
                    lg: '976px',
                    xl: '1440px'
                    },
                    extend: {
                    colors: {
                        darkGrayishBlue: 'hsl(227, 12%, 61%)',
                        veryDarkBlue: 'hsl(243, 87%, 12%)',
                        desaturatedBlue: 'hsl(238, 22%, 44%)',
                        lightGrayishBlue: 'hsl(239, 57%, 85%)',
                        lightGray: 'hsl(223, 19%, 93%)',
                        brightBlue: 'hsl(224, 93%, 58%)',
                        moderateCyan: 'hsl(170, 45%, 43%)',

                    },
                    },
                },
            }
          </script>
    </head>

    <body class="bg-slate-50">
        <nav class="fixed w-full px-5 py-3 md:px-14 bg-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl text-veryDarkBlue">LOREM</h2>
                </div>
            </div>
        </nav>

        <div id="app">
            <post></post>
        </div>

        <script>
           window.Laravel = <?php echo json_encode([
               'csrfToken' => csrf_token(),
            ]); ?>
            
          </script>

        </div> <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>