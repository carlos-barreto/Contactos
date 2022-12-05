<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="/logos/dark-logo-icon.svg">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/web-kid.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <v-app>
            <!-- Ajusta el tamaño de su contenido en función de los componentes de la aplicación -->


            @auth
            @include('layouts.nav')
            @endauth

            <!-- Proporciona a la aplicación la canaleta adecuada -->
            <v-container fluid class="grey lighten-3">
                <main class="py-4">
                    @yield('content')
                </main>
                <v-overlay fixed v-if="loadOverlay" z-index="9" opacity="1" color="white" :value="loadOverlay">
                    <v-card light elevation="0" tile>
                        <v-progress-circular :size="70" :width="7" color="secondary" class="d-block mx-auto"
                            indeterminate></v-progress-circular>
                        <v-card-text class="
                                secondary--text
                                text-center
                                pa-0
                                text-h4
                                ml-0
                                mr-0
                                mb-0
                                mt-5
                                font-weight-bold
                                ">
                            Procesando
                        </v-card-text>
                        <v-card-text class="secondary--text text-center pa-0 text-h6 ml-0 mr-0 mt-0 mb-5">
                            Esto podría tardar unos segundos
                        </v-card-text>
                    </v-card>
                </v-overlay>
            </v-container>

        </v-app>
    </div>
</body>

</html>