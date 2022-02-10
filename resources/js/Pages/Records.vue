<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Procurement Records
      </h2>
    </template>

    <div class="py-12">
      <div class="sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <Records
            :categories="categories"
            :LGUs="LGUs"
            :records="records"
            :filters="filters"
            :offices="offices"
          />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Records from "@/Pages/Records/index.vue";

export default {
  props: {
    categories: {
      type: Array,
      default: () => {},
    },
    LGUs: {
      type: [Array, Object],
      default: () => {},
    },
    records: {
      type: [Array, Object],
      default: () => {},
    },
    filters: {
      type: [Array, Object],
      default: () => {},
    },
    offices: {
      type: [Array, Object],
      default: () => {},
    },
  },

  components: {
    AppLayout,
    Records,
  },
};
</script>
