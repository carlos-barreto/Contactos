<template>
  <v-form v-model="valid" lazy-validation ref="form">
    <v-container>
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="newVal.nombre"
            :rules="[rules.required]"
            :counter="30"
            label="Nombre"
            required
            outlined
          ></v-text-field>
        </v-col>

        <v-col cols="12">
          <v-text-field
            v-model="newVal.telefono"
            :rules="[rules.required]"
            :counter="10"
            label="Teléfono"
            required
            outlined
          ></v-text-field>
        </v-col>

        <v-col cols="12">
          <v-menu
            v-model="menuFecha"
            :close-on-content-click="false"
            :nudge-right="40"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="newVal.fecha_nacimiento"
                label="F. Nacimiento"
                prepend-inner-icon="mdi-calendar"
                :rules="[rules.required]"
                readonly
                outlined
                required
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="newVal.fecha_nacimiento"
              @input="menuFecha = false"
            ></v-date-picker>
          </v-menu>
        </v-col>

        <v-col cols="12">
          <v-text-field
            v-model="newVal.direccion"
            :rules="[rules.required]"
            :counter="40"
            label="Dirección"
            required
            outlined
          ></v-text-field>
        </v-col>

        <v-col cols="12">
          <v-text-field
            v-model="newVal.email"
            :rules="[rules.required, rules.emailMatch]"
            :counter="40"
            label="E-Mail"
            required
            outlined
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-select
            v-model="newVal.sexo"
            :items="itemsSexo"
            item-value="sexo"
            item-text="text"
            label="Sexo"
            outlined
          ></v-select>
        </v-col>

        <v-card-actions class="d-flex justify-center">
          <v-btn color="primary" text @click="Reset"> Limpiar campos </v-btn>
          <v-btn :disabled="disable" color="primary" text @click="EnviarDatos">
            Guardar
          </v-btn>
        </v-card-actions>
      </v-row>
    </v-container>
  </v-form>
</template>
<script>
export default {
  props: ["datos"],
  data: () => ({
    itemsSexo: [
      {
        sexo: "0",
        text: "Masculino",
      },
      {
        sexo: "1",
        text: "Femenino",
      },
    ],
    valid: false,
    menuFecha: false,
    date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
      .toISOString()
      .substr(0, 10),
    rules: {
      required: (value) => !!value || "Requerido.",
      emailMatch: (v) => /.+@.+/.test(v) || "E-mail no valido.",
    },

    newVal: null,
    disable: false,
  }),
  beforeMount() {
    this.newVal = this.datos;
  },
  computed: {
    customUrl() {
      return this.newVal.hasOwnProperty("id")
        ? "/Contacto/" + this.newVal.id
        : "/Contacto/create";
    },
  },
  watch: {},
  methods: {
    EnviarDatos() {
      this.$toast("Un momento por favor...", this.$root.optToast);
      // if (this.$refs.form.validate()) {
      if (this.newVal.hasOwnProperty("id")) {
        let params = { params: this.newVal };
        axios
          .put(this.customUrl, params)
          .then((res) => {
            if (res.data.respuesta.codigo == 200) {
              this.$toast.success(
                "Muy bien contacto actualizado",
                res.data.respuesta.text
              );
              this.$emit("reset", true);
              this.Reset();
            }
          })
          .catch((err) => {
            this.$toast.error(
              `Upss  ${err.response.data.respuesta.text}`,
              err.response.data.respuesta.text
            );
          });
      } else {
        let params = { params: this.newVal };
        axios
          .get(this.customUrl, params)
          .then((res) => {
            if (res.data.respuesta.codigo == 200) {
              this.$toast.success("Muy bien", res.data.respuesta.text);
              this.$emit("reset", true);
              this.Reset();
            }
          })
          .catch((err) => {
            // console.log(err.response.data.respuesta);

            this.$toast.error(
              `Upss  ${err.response.data.respuesta.text}`,
              err.response.data.respuesta.text
            );
          });
      }
      // } else {
      //   this.$refs.form.validate();
      //   this.$toast.error("Valida los campos", this.$root.optToast);
      // }
    },
    Reset() {
      this.$refs.form.reset();
    },
  },
};
</script>