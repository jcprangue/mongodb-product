<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <dashboard :categories="categories" :date="date" />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import dashboard from "@/Pages/Dashboard/index.vue";

export default {
  props: {
    categories: {
      type: Array,
      default: () => {},
    },
    date: {
      type: Object,
      default: () => {},
    },
  },

  components: {
    AppLayout,
    dashboard,
  },
};
</script>
