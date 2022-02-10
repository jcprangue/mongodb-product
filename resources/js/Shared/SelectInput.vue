<template>
  <div>
    <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
    <select :id="id" ref="input" v-model="selectedOption" v-bind="$attrs" class="form-select" :class="{ error: error }">
      <slot />
    </select>
    <div v-if="error" class="form-error">
      {{ error }}
    </div>
  </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `select-input-${this._uid}`
      },
    },
    value: {
      type: [String, Number, Boolean],
      default: () => {} 
    },
    label: {
      type: [String, Boolean], default: null
    },
    error: {
      type: [String, Boolean], default: null
    },
  },
  data() {
    return {
      selected: this.value,
    }
  },
  computed: {
    selectedOption: {
      get() { return this.value},
      set(selectedOption) { this.$emit('input', selectedOption)}
    }
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
  },
}
</script>
