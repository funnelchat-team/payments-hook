<template>
  <default-field :field="field" :errors="errors">
    <template slot="field">
      <!-- Select con las plataformas disponibles-->
      <div class="inline-block relative w-full" style="padding-bottom: 1rem">
        <select class="w-full form-control form-select" v-model="value">
          <option
            :value="platformUrl(platform.name_hook)"
            v-for="platform of app_params.platforms"
            :key="platform"
          >{{platform.name}}</option>
        </select>
      </div>
      <!-- Sección con el input con el botón para copiar -->
      <div class="flex content-center items-center">
        <!-- Input para visualizar -->
        <input
          type="text"
          v-model="value"
          :placeholder="__('choose a provider from those available')"
          readonly="readonly"
          class="flex-1 form-input form-input-bordered form-control"
        />
        <div class="flex content-center w-4 mx-3">
          <!-- Botón copiado -->
          <copy-to-clipboard :text="value" @copy="handleCopy">
            <a-button
              type="button"
              :title="__('copy!')"
              class="text-70 appearance-none outline-none focus:outline-none cursor-pointer"
            >
              <!-- Icono de portapapeles -->
              <svg
                v-if="show_clipboard"
                height="100%"
                width="100%"
                viewBox="0 0 20 20"
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                class="pointer-events-none"
              >
                <g
                  id="Page-1"
                  stroke="currentcolor"
                  stroke-width="1"
                  fill="none"
                  fill-rule="evenodd"
                >
                  <g id="icon-shape">
                    <path
                      d="M12.9728369,2.59456737 C12.7749064,1.12946324 11.5193533,0 10,0 C8.48064666,0 7.2250936,1.12946324 7.02716314,2.59456737 L5,3 L5,4 L3.99406028,4 C2.89451376,4 2,4.8927712 2,5.99406028 L2,18.0059397 C2,19.1054862 2.8927712,20 3.99406028,20 L16.0059397,20 C17.1054862,20 18,19.1072288 18,18.0059397 L18,5.99406028 C18,4.89451376 17.1072288,4 16.0059397,4 L15,4 L15,3 L12.9728369,2.59456737 Z M5,6 L4,6 L4,18 L16,18 L16,6 L15,6 L15,7 L5,7 L5,6 Z M10,4 C10.5522847,4 11,3.55228475 11,3 C11,2.44771525 10.5522847,2 10,2 C9.44771525,2 9,2.44771525 9,3 C9,3.55228475 9.44771525,4 10,4 Z"
                      id="Combined-Shape"
                    />
                  </g>
                </g>
              </svg>
              <!-- Icono de check -->
              <svg
                v-else
                viewBox="0 0 20 20"
                height="100%"
                width="100%"
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                class="text-success pointer-events-none"
              >
                <g
                  id="Page-1"
                  stroke="none"
                  stroke-width="1"
                  fill="currentcolor"
                  fill-rule="evenodd"
                >
                  <g id="icon-shape">
                    <polygon id="Path-126" points="0 11 2 9 7 14 18 3 20 5 7 18" />
                  </g>
                </g>
              </svg>
            </a-button>
          </copy-to-clipboard>
        </div>
      </div>
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";
import CopyToClipboard from "vue-copy-to-clipboard";

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ["resourceName", "resourceId", "field"],
  components: {
    CopyToClipboard,
  },
  data() {
    return {
      app_params: {
        token_user: "",
        app_url: "",
        platforms: [],
      },
      show_clipboard: true,
    };
  },

  mounted() {
    console.log(this.field);
    this.getAppParams();
  },
  methods: {
    async getAppParams() {
      /**
       * Obtención de los datos necesarios para la ejecución
       */
      this.loading = true;
      const { data: datos } = await Nova.request().get(
        "/nova-vendor/PaymentsHook/app-params"
      );
      this.app_params = datos;
      this.loading = false;
    },

    platformUrl(platform) {
      /**
       * Seteo de la url para la plataforma
       */
      return (
        this.app_params.app_url +
        "/payments/" +
        this.app_params.token_user +
        "/" +
        platform
      );
    },

    handleCopy(result) {
      /**
       * Manejador de evento post copiado
       */
      this.show_clipboard = false;
      console.log("onCopy", result);
      setTimeout(() => {
        //esperamos un segundo para poner la variable a su estado original
        this.show_clipboard = true;
      }, 1000);
    },

    setInitialValue() {
      this.value = this.field.value || "";
    },
  },
};
</script>
