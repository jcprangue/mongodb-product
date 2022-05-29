<template>
  <div>
    <table class="w-full my-4 whitespace-no-wrap bg-white text-sm">
      <tr class="font-bold text-left">
        <th class="p-2 ">#</th>
        <th class="p-4 r">Status</th>
        <th class="p-4 ">Remarks</th>
        <th class="p-4 ">Action</th>
        <th class="p-4">User</th>
      </tr>
      <tr
        v-for="(row, i) of records"
        :key="row.id"
        class="border-t hover:bg-gray-100 focus-within:bg-gray-100"
      >
        <td class="p-3">
          {{ i + 1 }}
        </td>
        <td class="p-3">
          {{ row.status }}
        </td>
        <td class="p-3">
          {{ row.remarks }}
        </td>
        <td class="p-3">
          {{ row.action }}
        </td>
        <td class="p-3">
          {{ row.users.name }}
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
// import LineChart from "./LineChart";
import mapValues from "lodash/mapValues";
import throttle from "lodash/throttle";
import Pagination from "@/Shared/Pagination";

export default {
  components: {
    Pagination,
  },
  props: {
    
    records: {
      type: [Array, Object],
      default: () => {},
    },
  },
  data() {
    return {
     
     
    };
  },
  
  mounted() {
  },
  methods: {
   
  },
};
</script>
