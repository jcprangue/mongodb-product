<template>
  <div class="flex items-center">
    <div class="flex w-full bg-white rounded shadow">
      <dropdown
        :auto-close="false"
        class="
          px-4
          border-r
          rounded-l
          md:px-6
          hover:bg-gray-100
          focus:border-white focus:shadow-outline focus:z-10
        "
        placement="bottom-start"
      >
        <div class="flex items-baseline">
          <span class="hidden text-gray-700 md:inline">Search</span>
        </div>

        <div
          slot="dropdown"
          class="w-screen px-4 py-6 mt-2 bg-white rounded shadow-xl"
          :style="{ maxWidth: `${maxWidth}px` }"
        >
          <slot />
        </div>
      </dropdown>
      <input
        class="relative w-full px-6 py-3 rounded-r focus:shadow-outline"
        autocomplete="off"
        type="text"
        name="search"
        placeholder="Type keyword here"
        :value="value"
        @input="$emit('input', $event.target.value)"
      />
    </div>
    <button
      class="
        ml-3
        text-sm text-gray-500
        hover:text-gray-700
        focus:text-indigo-500
      "
      type="button"
      @click="$emit('reset')"
    >
      Reset
    </button>
  </div>
</template>

<script>
import Dropdown from "@/Shared/Dropdown";

export default {
  components: {
    Dropdown,
  },
  props: {
    value: { type: String, default: "" },
    maxWidth: {
      type: Number,
      default: 300,
    },
  },
};
</script>
