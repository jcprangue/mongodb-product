<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="route('records.index')"
        >
          Procument Record
        </inertia-link>
        <span class="font-medium">/</span>
        {{ record.project_name }} Status History
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <History :records="histories"></History>
        
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import History from "@/Pages/Records/history.vue";

export default {
  props: {
    record: {
      type: [Array, Object],
      default: () => {},
    },
    histories: {
      type: [Array, Object],
      default: () => {},
    },
  },

  components: {
    AppLayout,
    History,
  },
};
</script>
