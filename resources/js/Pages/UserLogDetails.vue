<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="route('records.index')"
        >
          Procurement User Logs 
        </inertia-link>
        <span class="font-medium">/</span>
        {{ record[0].procurement.project_name}} 
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <UserDetails :record="record" />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UserDetails from "@/Pages/UserHistory/index.vue";

export default {
  props: {
    record: {
      type: [Array, Object],
      default: () => {},
    },
  },

  components: {
    AppLayout,
    UserDetails,
  },
};
</script>
