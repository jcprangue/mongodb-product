<template>
  <div>
    <span v-for="n in 5" :key="n" class="px-1">
      <span v-if="n <= rating">★</span>
      <span v-else>☆</span>
    </span>
  </div>
</template>

<script>
export default {
  props: {
    rating: {
      type: Number, default: 0
    }
  }
}
</script>
