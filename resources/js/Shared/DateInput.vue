<template>
  <div>
    <label
      v-if="label"
      class="form-label"
      :for="id"
    >{{ label }}:</label>
    <date-picker
      :id="id"
      ref="input"
      v-bind="$attrs"
      class="w-full"
      inputClass="form-input"
      valueType="format"
      :class="{ error: error }"
      :type="type"
      :inputAttr="{ required: isRequired}"
      v-model="chosen"
    />
    <div
      v-if="error"
      class="form-error"
    >
      {{ error }}
    </div>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
export default {
  components: {
    DatePicker,
  },
  props: {
    id: {
      type: String,
      default() {
        return `date-${this._uid}`;
      },
    },
    type: {
      type: String,
      default: "date",
    },
    value: {
      type: [String, Boolean],
      default: null,
    },
    label: {
      type: [String, Boolean],
      default: null,
    },
    error: {
      type: [String, Boolean],
      default: null,
    },
  },
  data() {
    return {
      chosen: this.value,
      isRequired: this.$attrs.hasOwnProperty("required") ? true : false,
    };
  },
  watch: {
    chosen(chosen) {
      this.$emit("input", chosen);
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus();
    },
  },
};
</script>
