<template>
  <div>
    <div class="flex justify-between">
      <p class="md:text-2xl">
        <b>{{ keyword }} - {{ record.project_name }}</b>
      </p>
    </div>

    <table class="w-full my-4 whitespace-no-wrap bg-white border border-black">
      <thead class="bg-gray-200 border border-black">
        <tr class="border">
          <th class="w-1/12 p-2 border border-black">Bid Opening Date</th>
          <th class="w-1/12 p-2 border border-black">IB Number</th>
          <th class="w-3/12 p-2 text-sm whitespace-normal border border-black">
            Project Name
          </th>
          <th class="w-1/5 p-2 border border-black">Winning Contractor</th>
          <th class="w-1/12 p-2 border border-black">Amount</th>
          <th class="w-1/6 p-2 border border-black">Status</th>
          <th class="w-1/6 p-2 border border-black">Remarks</th>
        </tr>
      </thead>

      <tbody class="border border-black">
        <tr>
          <td
            valign="top"
            class="
              px-2
              whitespace-normal
              align-top
              border-b-0 border-r border-black
            "
          >
            {{ record.bid_opening_date }}
          </td>
          <td valign="top" class="px-2 border-b-0 border-r border-black">
            {{ record.ib_number }}
          </td>
          <td valign="top" class="px-2 border-b-0 border-r border-black">
            {{ record.project_name }}
          </td>
          <td valign="top" class="px-2 border-b-0 border-r border-black">
            {{ record.contractor }}
          </td>
          <td valign="top" class="px-2 border-b-0 border-r border-black">
            {{ record.amount }}
          </td>
          <td valign="top" class="px-2 border-b-0 border-r border-black">
            {{ record.status }}
          </td>
          <td valign="top" class="px-2 border-b-0 border-r border-black">
            {{ record.remarks }}
          </td>
        </tr>
      </tbody>
    </table>

    <div v-for="(row, i) in record.category.documents" :key="i" class="mb-20">
      <div class="flex justify-between">
        <h2>
          <b>{{ row.document.name }} ( {{ row.document.abbr }} )</b>
        </h2>
      </div>

      <tableData :record="record" :document="row"></tableData>
    </div>
  </div>
</template>

<script>
import Icon from "@/Shared/Icon";
import tableData from "@/Pages/Search/table";

export default {
  components: {
    Icon,
    tableData,
  },
  props: {
    keyword: {
      type: String,
      default: () => {},
    },
    record: { type: [Object, Array], default: () => {} },
  },
  data() {
    return {};
  },

  methods: {},
};
</script>
