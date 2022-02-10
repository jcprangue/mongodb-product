<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="route('documents.index')"
        >
          Documents
        </inertia-link>
        <span class="font-medium">/</span>
        {{ document.abbr }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <documentField
            :fields="fields"
            :document="document"
            :filters="filters"
            :errors="errors"
          />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import documentField from "@/Pages/DocumentField/index.vue";

export default {
  props: {
    fields: {
      type: [Object, Array],
      default: () => {},
    },
    document: {
      type: [Object, Array],
      default: () => {},
    },
    filters: { type: [Object, Array], default: () => {} },
    errors: { type: Object, default: () => {} },
  },

  components: {
    AppLayout,
    documentField,
  },
};
</script>
