<template>
  <v-container id="login" class="fill-height justify-center">
    <v-row class="align-center justify-center h-100vh">
      <v-col cols="12" sm="8" lg="11">
        <v-card elevation="10">
          <v-row>
            <v-col
              cols="7"
              class="d-none d-md-flex align-center justify-center bg-primary"
            >
              <div class="d-none d-sm-block">
                <div class="d-flex align-center pa-10 v-col-8">
                  <div>
                    <h2 class="text-h4 text-white font-weight-medium">
                      Diseño elegante con funciones ilimitadas, construido con
                      amor
                    </h2>
                    <h6
                      class="
                        text-subtitle-1 text-high-emphasis
                        mt-4
                        text-white
                        font-weight-regular
                      "
                    >
                      Administra dus contactos.
                    </h6>
                  </div>
                </div>
              </div>
            </v-col>
            <v-col cols="5">
              <div class="pa-7 pa-sm-12">
                <img src="/logos/dark-logo-icon.svg" alt="logo" />
                <h2 class="font-weight-bold mt-4 text--darken-2">
                  Iniciar sesión
                </h2>
                <h6 class="text-subtitle-1 mb-7">
                  ¿No tienes una cuenta?
                  <a
                    class="
                      v-btn v-btn--flat
                      v-theme--light
                      text-primary
                      v-btn--density-default
                      rounded-md
                      v-btn--size-default v-btn--variant-plain
                    "
                    href="/register"
                    ><span class="v-btn__content">Inscribirse</span></a
                  >
                </h6>
                <form method="POST" action="/login">
                  <input type="hidden" name="_token" :value="$root.v_crsf" />
                  <v-row>
                    <v-col cols="12">
                      <v-text-field
                        v-model="email"
                        :rules="rules.emailRules"
                        label="E-mail"
                        id="email"
                        type="email"
                        name="email"
                        required
                        outlined
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12">
                      <v-text-field
                        :append-icon="showPw ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.required]"
                        :type="showPw ? 'text' : 'password'"
                        label="Contraseña"
                        id="password"
                        name="password"
                        @click:append="showPw = !showPw"
                        outlined
                      ></v-text-field>
                    </v-col>
                    <v-col>
                      <div class="d-flex justify-center">
                        <v-btn
                          class="ma-2"
                          outlined
                          color="indigo"
                          type="submit"
                        >
                          Ingresar
                        </v-btn>
                      </div>
                    </v-col>
                  </v-row>
                </form>
              </div>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      showPw: false,
      password: "",
      email: "",
      rules: {
        required: (value) => !!value || "Requerido.",
        min: (v) => v.length >= 8 || "Min 8 caracteres",
        emailRules: [
          (v) => !!v || "Este campo es requerido",
          (v) => /.+@.+\..+/.test(v) || "Correo electrónico no válido",
        ],
      },
    };
  },
};
</script>
<style scoped>
.fill-height {
  height: 100% !important;
}
.h-100vh {
  height: 100vh;
}
.bg-primary {
  background: rgb(30, 136, 229) !important;
  color: rgb(255, 255, 255) !important;
}
.text-subtitle-1 {
  font-size: 1rem !important;
  font-weight: 400;
  line-height: 1.75rem;
  letter-spacing: 0.009375em !important;
  font-family: Roboto, sans-serif !important;
  text-transform: none !important;
}
</style>