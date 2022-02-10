<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Documents
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <document :documents="documents" :filters="filters" />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import document from "@/Pages/Document/index.vue";

export default {
  props: {
    documents: {
      type: [Object, Array],
      default: () => {},
    },
    filters: { type: [Object, Array], default: () => {} },
  },

  components: {
    AppLayout,
    document,
  },
};
</script>
