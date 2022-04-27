<template>
  <div>
      <tableData :record="record"></tableData>
  </div>
</template>

<script>
import Icon from "@/Shared/Icon";
import tableData from "@/Pages/UserHistory/table";

export default {
  components: {
    Icon,
    tableData,
  },
  props: {
    record: {
      type: [Array, Object],
      default: () => {},
    },
  },
  data() {
    return {
      form: {},
    };
  },

  mounted() {
  },
  methods: {},
};
</script>
