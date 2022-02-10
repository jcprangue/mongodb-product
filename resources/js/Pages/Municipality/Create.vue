<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="route('LGUs.index')"
        >
          Municipalities
        </inertia-link>
        <span class="font-medium">/</span>
        Create New
      </h2>
    </template>

    <div class="py-4">
      <div class="max-w-3xl m-auto overflow-hidden bg-white rounded shadow-xl">
        <form ref="formCreate" @submit.prevent="submit">
          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <text-input
              v-model="form.lgus"
              :error="errors.lgus"
              class="w-full pb-8 pr-6 lg:w-1/2"
              label="LGU Name"
            />
            <text-input
              v-model="form.province_name"
              :error="errors.province_name"
              class="w-full pb-8 pr-6 lg:w-1/2"
              label="Province"
            />
          </div>
          <div
            class="
              flex
              items-center
              justify-end
              px-8
              py-4
              bg-gray-100
              border-t border-gray-200
            "
          >
            <loading-button :loading="sending" class="btn-indigo" type="submit">
              Create Municipality
            </loading-button>
          </div>
        </form>
      </div>
    </div>
  </app-layout>
</template>


<script>
import AppLayout from "@/Layouts/AppLayout";
import LoadingButton from "@/Shared/LoadingButton";
import SelectInput from "@/Shared/SelectInput";
import TextInput from "@/Shared/TextInput";

export default {
  components: {
    AppLayout,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  props: {
    errors: { type: Object, default: () => {} },
    municipalities: { type: [Object, Array], default: () => {} },
  },
  data() {
    return {
      sending: false,
      form: {
        lgus: null,
        prov_id: this.municipalities.id,
        province_name: this.municipalities.province_description,
      },
    };
  },
  mounted() {},
  methods: {
    submit() {
      this.sending = true;
      this.form.prov_id = 1;

      this.$inertia
        .post(this.route("LGUs.store"), this.form)
        .then((response) => {
          this.sending = false;
        });
    },
  },
};
</script>
