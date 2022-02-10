<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="route('records.index')"
        >
          Procurement Records
        </inertia-link>
        <span class="font-medium">/</span>
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="
            route('records-details.index', { id: record.procurement_record_id })
          "
        >
          {{ record.document.abbr }} Details
        </inertia-link>
        <span class="font-medium">/</span>
        Update
      </h2>
    </template>

    <div class="py-4">
      <div class="max-w-3xl m-auto overflow-hidden bg-white rounded shadow-xl">
        <form ref="formCreate" @submit.prevent="submit">
          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <select-input
              v-model="form.field_id"
              :error="errors.field_id"
              class="w-full pr-6"
              label="Field"
            >
              <option value="" selected disabled>-- Select Field --</option>
              <option v-for="(field, i) of fields" :key="i" :value="field.id">
                {{ field.field_name }}
              </option>
            </select-input>
          </div>
          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <text-input
              v-model="form.data"
              :error="errors.data"
              class="w-full pr-6"
              label="Input Update"
            />
          </div>

          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <textarea-input
              v-model="form.remarks"
              :error="errors.remarks"
              class="w-full pb-8 pr-6"
              label="Remarks"
            />
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
              v-if="!record.deleted_at"
              class="btn-red"
              tabindex="-1"
              type="button"
              @click="destroy"
            >
              Delete Detail
            </button>
            <loading-button :loading="sending" class="btn-indigo" type="submit">
              Update Detail
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
import TextareaInput from "@/Shared/TextareaInput";
import DateInput from "@/Shared/DateInput";

export default {
  components: {
    DateInput,
    AppLayout,
    LoadingButton,
    SelectInput,
    TextInput,
    TextareaInput,
  },
  props: {
    errors: { type: Object, default: () => {} },
    record: { type: [Object, Array], default: () => {} },
    fields: { type: [Object, Array], default: () => {} },
  },
  data() {
    return {
      sending: false,
      form: {
        id: this.record.id,
        procurement_record_id: this.record.procurement_record_id,
        category_id: this.record.category_id,
        document_id: this.record.document_id,
        field_id: this.record.field_id,
        data: this.record.data,
        remarks: this.record.remarks,
      },

      barangays: [],
    };
  },

  mounted() {},
  methods: {
    submit() {
      this.sending = true;
      this.$inertia
        .patch(this.route("records-details.update", this.record.id), this.form)
        .then((response) => {
          this.sending = false;
        });
    },
    destroy() {
      if (confirm("Are you sure you want to delete this LGU?")) {
        this.$inertia.delete(
          this.route("records-details.destroy", this.record.id)
        );
      }
    },
  },
};
</script>
