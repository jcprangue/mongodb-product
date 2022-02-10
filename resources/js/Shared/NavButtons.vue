<template>
  <div class="flex justify-between mt-4 md:mt-8">
    <button
      class="text-xl md:text-5xl btn-gray"
      :class="{'invisible': currentCount===1}"
      @click="changeTo(newCount--)"
    >
      Bumalik
    </button>
    <button
      class="text-xl md:text-5xl btn-green"
      @click="changeTo(newCount++)"
    >
      Susunod
    </button>
  </div>
</template>

<script>
export default {
  props: {
    currentCount: {
      type: [Number, Boolean],
      default: null,
    },
  },
  data() {
    return {
      newCount: this.currentCount,
    };
  },
  methods: {
    changeTo(ctr) {
      console.log(this.currentCount);
      console.log(this.newCount);
      return this.$emit("change-page", this.newCount);
    },
  },
};
</script>
