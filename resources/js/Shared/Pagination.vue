<template>
  <div class="flex flex-wrap mt-6 -mb-1">
    <template v-for="(link, key) in links">
      <div
        v-if="link.url === null"
        :key="key"
        class="px-4 py-3 mb-1 mr-1 text-sm text-gray-400 border rounded"
        :class="{ 'ml-auto': link.label === 'Next' }"
      >
        {{ link.label }}
      </div>
      <inertia-link
        v-else
        :key="key"
        class="
          px-4
          py-3
          mb-1
          mr-1
          text-sm
          border
          rounded
          hover:bg-white
          focus:border-indigo-500 focus:text-indigo-500
        "
        :class="{ 'bg-white': link.active, 'ml-auto': link.label === 'Next' }"
        :href="link.url"
      >
        {{ link.label }}
      </inertia-link>
    </template>
  </div>
</template>

<script>
export default {
  props: {
    links: { type: Array, default: () => {} },
  },
};
</script>
