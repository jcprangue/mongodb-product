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
        Documents for {{ category.name }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <categoryDocument
            :category="category"
            :documents="documents"
            :categoryDocuments="categoryDocuments"
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
import categoryDocument from "@/Pages/CategoryDocument/index.vue";

export default {
  props: {
    documents: { type: [Object, Array], default: () => {} },
    categoryDocuments: { type: [Object, Array], default: () => {} },
    category: { type: [Object, Array], default: () => {} },
    filters: { type: [Object, Array], default: () => {} },
    errors: { type: Object, default: () => {} },
  },

  components: {
    AppLayout,
    categoryDocument,
  },
};
</script>
