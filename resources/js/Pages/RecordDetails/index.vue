<template>
  <div>
    <div v-for="(row, i) in record.category.documents" :key="i" class="mb-20">
      <div class="flex justify-between">
        <h2>
          <b>{{ row.document.name }} ( {{ row.document.abbr }} )</b>
        </h2>

        <inertia-link
          class="btn-indigo"
          :href="route('records-details.show', `${record.id}-${row.id}`)"
        >
          <span>Add</span>
          <span class="hidden md:inline">{{ row.document.abbr }} Update</span>
        </inertia-link>
      </div>

      <tableData :record="record" :document="row"></tableData>
    </div>
  </div>
</template>

<script>
import Icon from "@/Shared/Icon";
import tableData from "@/Pages/RecordDetails/table";

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

  mounted() {},
  methods: {},
};
</script>
