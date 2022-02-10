<template>
  <div v-if="message">
    <p class="p-4 text-sm font-bold text-center text-white bg-red-600 md:text-4xl">
      {{ message }}
    </p>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      default: "",
    },
  },
};
</script>
