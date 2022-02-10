<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ municipal.lgus }}'s Barangays
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <brgy
            :barangays="barangays"
            :filters="filters"
            :municipal="municipal"
          />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import brgy from "@/Pages/Barangay/index.vue";

export default {
  props: {
    municipal: {
      type: [Object, Array],
      default: () => {},
    },
    filters: { type: [Object, Array], default: () => {} },
    barangays: { type: [Object, Array], default: () => {} },
  },

  components: {
    AppLayout,
    brgy,
  },
};
</script>
