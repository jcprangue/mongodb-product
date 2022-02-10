<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="route('brgy.index', { id: municipal.id })"
        >
          {{ municipal.lgus }}
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
              v-model="form.brgyDesc"
              :error="errors.brgyDesc"
              class="w-full pb-8 pr-6 lg:w-1/2"
              label="Barangay"
            />
            <small
              >This will be added to city/municipality of
              {{ municipal.lgus }}</small
            >
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
              Create Barangay
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
    municipal: { type: [Object, Array], default: () => {} },
  },
  data() {
    return {
      sending: false,
      form: {
        brgyDesc: null,
        prov_id: this.municipal.prov_id,
        citymun_id: this.municipal.id,
      },
    };
  },
  mounted() {},
  methods: {
    submit() {
      this.sending = true;
      this.$inertia
        .post(this.route("brgy.store"), this.form)
        .then((response) => {
          this.sending = false;
        });
    },
  },
};
</script>
