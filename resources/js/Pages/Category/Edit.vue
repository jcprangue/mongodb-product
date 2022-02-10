<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="route('category.index')"
        >
          Category
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
              v-model="form.name"
              :error="errors.name"
              class="w-full pb-8 pr-6 lg:w-1/2"
              label="Name"
            />
            <text-input
              v-model="form.abbr"
              :error="errors.abbr"
              class="w-full pb-8 pr-6 lg:w-1/2"
              label="Abbreviation"
            />
            <select-input
              v-model="form.parent_id"
              :error="errors.parent_id"
              class="w-full pb-8 pr-6 lg:w-1/2"
              label="Parent Category"
            >
              <option :value="null" />
              <option v-for="row in categories" :key="row.id" :value="row.id">
                {{ row.abbr }}
              </option>
            </select-input>
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
              v-if="!category.deleted_at"
              class="btn-red"
              tabindex="-1"
              type="button"
              @click="destroy"
            >
              Delete Category
            </button>
            <loading-button :loading="sending" class="btn-indigo" type="submit">
              Update Category
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
    category: { type: [Object, Array], default: () => {} },
    categories: { type: [Object, Array], default: () => [] },
  },
  remember: "form",
  data() {
    return {
      sending: false,
      form: {
        name: this.category.name,
        abbr: this.category.abbr,
        parent_id: this.category.parent_id,
      },
    };
  },
  methods: {
    submit() {
      this.sending = true;
      this.$inertia
        .patch(this.route("category.update", this.category.id), this.form)
        .then(() => (this.sending = false));
    },
    destroy() {
      if (confirm("Are you sure you want to delete this category?")) {
        this.$inertia.delete(this.route("category.destroy", this.category.id));
      }
    },
  },
};
</script>
