<v-app-bar app color="white" flat>

    <v-container class="py-0 fill-height">

        <v-btn href="/" text rounded color="grey darken-1">
            <v-icon left>mdi-home</v-icon>
            {{ config('app.name', 'Laravel') }}
        </v-btn>

        <v-spacer></v-spacer>
        <v-menu bottom min-width="200px" rounded offset-y>
            <template v-slot:activator="{ on }">
                <v-btn icon x-large v-on="on">
                    <v-avatar color="primary" size="48">
                        <v-icon>mdi-account</v-icon>
                    </v-avatar>
                </v-btn>
            </template>
            <v-card>

                <v-list-item-content class="justify-center">
                    <div class="mx-auto text-center">
                        <v-avatar color="primary">
                            <v-icon>mdi-account</v-icon>
                        </v-avatar>
                        <h3>{{ Auth::user()->name }}</h3>
                        <p class="text-caption mt-1">
                            {{ Auth::user()->email }}
                        </p>
                        <v-divider class="my-3"></v-divider>
                        <v-divider class="my-3"></v-divider>
                        <v-btn depressed rounded text href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                            Salir
                        </v-btn>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </v-list-item-content>

            </v-card>
        </v-menu>

    </v-container>

</v-app-bar>