<template>
  <div>
    <table class="w-full my-4 whitespace-no-wrap bg-white border border-black">
      <thead class="bg-gray-200 border border-black">
        <tr>
          <th
            class="p-2 border border-black"
            v-for="(row, i) in headerList"
            :key="i"
          >
            {{ row.field_name }}
          </th>
        </tr>
      </thead>
      <tbody class="border border-black">
        <tr>
          <td
            valign="top"
            v-for="(row, i) in headerList"
            :key="i"
            class="
              px-2
              whitespace-normal
              align-top
              border-b-0 border-r border-black
            "
          >
            <div v-if="listDetails.length > 0">
              <label v-for="(data, count) in listDetails" :key="count">
                <span v-if="row.id == data.field_id">{{ data.data }}</span>
                <span v-else>&nbsp;</span>
              </label>
            </div>
            <div v-else>&nbsp;</div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import Icon from "@/Shared/Icon";

export default {
  components: {
    Icon,
  },
  props: {
    record: {
      type: [Array, Object],
      default: () => {},
    },
    document: {
      type: [Array, Object],
      default: () => {},
    },
  },
  data() {
    return {
      form: {
        procurement_record_id: this.record.id,
        category_id: this.record.category_id,
        document_id: this.document.document.id,
      },
      listDetails: [],
      headerList: [],
    };
  },

  mounted() {
    this.getDetails();
    this.getHeader();
  },
  methods: {
    getDetails() {
      axios
        .post(this.route("records-details.listUpdate"), this.form)
        .then((response) => {
          this.listDetails = response.data;
        });
    },
    getHeader() {
      axios
        .post(this.route("records-details.headerList"), this.form)
        .then((response) => {
          this.headerList = response.data;
          console.log(this.headerList);
        });
    },
  },
};
</script>
