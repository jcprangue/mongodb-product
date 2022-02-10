<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Category
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <CategoryIndex :categories="categories" :filters="filters" />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import CategoryIndex from "@/Pages/Category/index.vue";

export default {
  props: {
    categories: {
      type: Object,
      default: () => {},
    },
    filters: { type: [Object, Array], default: () => {} },
  },

  components: {
    AppLayout,
    CategoryIndex,
  },
};
</script>
