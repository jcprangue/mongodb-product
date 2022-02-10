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
        Update
      </h2>
    </template>

    <div class="py-4">
      <div class="max-w-3xl m-auto overflow-hidden bg-white rounded shadow-xl">
        <form @submit.prevent="submit">
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
              justify-between
              px-8
              py-4
              bg-gray-100
              border-t border-gray-200
            "
          >
            <button
              v-if="!barangay.deleted_at"
              class="btn-red"
              tabindex="-1"
              type="button"
              @click="destroy"
            >
              Delete Barangay
            </button>
            <loading-button :loading="sending" class="btn-indigo" type="submit">
              Update Barangay
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
    barangay: { type: [Object, Array], default: () => {} },
  },
  remember: "form",
  data() {
    return {
      sending: false,
      form: {
        brgyDesc: this.barangay.brgyDesc,
        prov_id: this.municipal.prov_id,
        citymun_id: this.municipal.id,
      },
    };
  },
  methods: {
    submit() {
      this.sending = true;
      this.$inertia
        .patch(this.route("brgy.update", this.barangay.id), this.form)
        .then(() => (this.sending = false));
    },
    destroy() {
      if (confirm("Are you sure you want to delete this Barangay?")) {
        this.$inertia.delete(this.route("brgy.destroy", this.barangay.id));
      }
    },
  },
};
</script>
