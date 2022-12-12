<template>
  <v-container>
    <v-tour
      :callbacks="callbacksInicio"
      name="myTourInicio"
      :steps="stepsInicio"
      :options="myOptions"
    ></v-tour>
    <v-row>
      <v-col cols="3">
        <v-card elevation="0" rounded="lg" data-v-step="0">
          <v-list color="transparent" rounded>
            <v-list-item-group color="primary">
              <v-list-item
                v-for="(item, i) in itemsBar"
                :key="i"
                @click="AccionBar(item.value, item.text)"
              >
                <v-list-item-icon>
                  <v-icon v-text="item.icon"></v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title v-text="item.text"></v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>

            <v-divider class="my-2"></v-divider>

            <v-list-item
              link
              color="grey lighten-4"
              @click="GetListContacts"
              data-v-step="2"
            >
              <v-list-item-icon>
                <v-icon>mdi-refresh-auto</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title> Refrescar </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item
              link
              color="grey lighten-4"
              @click="GoTur"
              data-v-step="2"
            >
              <v-list-item-icon>
                <v-icon>mdi-google-assistant</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title> Iniciar tur </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>

      <v-col>
        <v-card elevation="0" rounded="lg">
          <v-card-title>
            <v-text-field
              v-model="search"
              dense
              flat
              hide-details
              rounded
              solo-inverted
              label="Búsqueda"
              append-icon="mdi-magnify"
              data-v-step="3"
            ></v-text-field>
          </v-card-title>

          <v-data-table
            v-model="selected"
            :headers="headers"
            :items="datosContacto"
            :single-select="singleSelect"
            item-key="id"
            show-select
            class="elevation-1"
            :search="search"
            :footer-props="{
              'items-per-page-text': 'Registros por página:',
            }"
            data-v-step="1"
          >
            <template v-slot:[`item.nombre`]="{ item }">
              <v-chip dark>
                {{ item.nombre }}
              </v-chip>
            </template>
            <template v-slot:no-data>
              <v-btn color="primary" @click="GetListContacts">
                Refrescar
              </v-btn>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
    <v-dialog v-model="dialogAcction" max-width="490">
      <v-card>
        <v-card-title class="text-h5">
          <v-spacer></v-spacer>
          {{ titleCard }}
          <v-spacer></v-spacer>
          <v-btn icon @click="ResetItem()">
            <v-icon>mdi-close-circle-outline</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <form-component
            v-if="dialogAcction"
            :datos="formDatos"
            @reset="updateTable = $event"
          ></form-component>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>
<script>
import Cookies from "js-cookie";
import formComponent from "./includes/FormComponent.vue";
export default {
  components: {
    "form-component": formComponent,
  },
  data() {
    return {
      /**
       * Data table
       */
      singleSelect: true,
      selected: [],
      headers: [
        {
          text: "nombre",
          align: "start",
          sortable: false,
          value: "nombre",
        },
        { text: "telefono", value: "telefono" },
        { text: "fecha_nacimiento", value: "fecha_nacimiento" },
        { text: "direccion", value: "direccion" },
        { text: "email", value: "email" },
      ],
      datosContacto: [],
      /**
       * Items bar
       */
      itemsBar: [
        { text: "Agregar contacto", icon: "mdi-archive-plus", value: 1 },
        { text: "Editar contacto", icon: "mdi-archive-edit", value: 2 },
        { text: "Eliminar contacto", icon: "mdi-archive-minus", value: 3 },
      ],
      /**
       * Modal acciones
       */
      dialogAcction: false,
      titleCard: "",

      /**
       * Data form
       */
      formDatos: {
        nombre: null,
        telefono: null,
        fecha_nacimiento: null,
        direccion: null,
        email: null,
        sexo: null,
      },
      search: "",
      updateTable: false,
      itemDelete: null,
      /**
       * tur inicio
       */
      myOptions: {
        useKeyboardNavigation: false,
        labels: {
          buttonSkip: "Omitir recorrido",
          buttonPrevious: "Anterior",
          buttonNext: "Siguiente",
          buttonStop: "Terminar",
        },
      },
      callbacksInicio: {
        onNextStep: this.nextStepInicio,
        onFinish: this.finishStepInicio,
        onSkip: this.finishStepInicio,
      },
      stepsInicio: [
        {
          target: '[data-v-step="0"]',
          content:
            "Funciones para crear, editar, eliminar la información de los contactos.",
        },
        {
          target: '[data-v-step="1"]',
          content:
            "En esta sección puede visualizar los registros de usuarios realizados.",
        },
        {
          target: '[data-v-step="2"]',
          content: "Al hacer clic en este botón, refescar los datos.",
        },
        {
          target: '[data-v-step="3"]',
          content: "Filtro para búsqueda de contactos.",
        },
      ],
    };
  },
  created() {
    this.GetListContacts();
  },
  mounted() {
    this.validarTur();
  },
  watch: {
    updateTable() {
      if (this.updateTable) {
        console.log("entra updata");
        this.GetListContacts();
        this.updateTable = false;
      }
    },
  },
  methods: {
    AccionBar(key, title) {
      switch (key) {
        case 1:
          this.dialogAcction = true;
          this.titleCard = title;
          break;
        case 2:
          if (this.selected.length > 0) {
            this.EditItem();
            this.titleCard = title;
          } else {
            this.$toast.error("Para editar selecciona un contacto.");
          }
          break;
        case 3:
          if (this.selected.length > 0) {
            this.DeleteItem();
            this.titleCard = title;
          } else {
            this.$toast.error("Para eliminar selecciona un contacto.");
          }
          break;
        default:
          this.dialogAcction = false;
          this.titleCard = "";
          break;
      }
    },
    GetListContacts() {
      this.$toast("Un momento por favor...", this.$root.optToast);
      axios
        .get("/Contacto")
        .then((res) => {
          this.$toast.success("Muy bien");
          this.datosContacto = res.data;
        })
        .catch((err) => {
          this.$toast.error("Upss", err.response.data);
        });
    },
    EditItem() {
      this.formDatos = Object.assign({}, this.selected[0]);
      this.dialogAcction = true;
    },
    DeleteItem() {
      this.$toast("Un momento por favor...", this.$root.optToast);
      this.itemDelete = Object.assign({}, this.selected[0]);
      axios
        .delete(`Contacto/${this.itemDelete.id}`)
        .then((res) => {
          if (res) {
            this.$toast.success("Muy bien, contacto eliminado");
            this.GetListContacts();
            this.ResetItem();
          }
        })
        .catch((err) => {
          console.error(err);
          this.$toast.error("Upss", err.response.data);
        });
    },
    ResetItem() {
      this.$nextTick(() => {
        this.formDatos = {
          nombre: null,
          telefono: null,
          fecha_nacimiento: null,
          direccion: null,
          email: null,
        };
        this.dialogAcction = false;
        this.itemDelete = null;
      });
    },
    nextStepInicio(currentStep) {
      if (currentStep === 1) {
        // console.log("entra");
      }
    },
    finishStepInicio() {
      Cookies.set("tourInicio", true, {
        expires: 2,
      });
    },
    validarTur() {
      if (!Cookies.get("tourInicio")) {
        this.$tours["myTourInicio"].start();
      }
    },
    GoTur() {
      Cookies.remove("tourInicio");
      window.location.reload();
    },
  },
};
</script>