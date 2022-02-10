<template>
  <div>
    <table class="w-full my-4 whitespace-no-wrap bg-white">
      <tr class="font-bold text-left">
        <th class="p-4" width="50">#</th>
        <th class="p-4" width="250">Field</th>
        <th class="p-4" width="250">Date</th>
        <th class="p-4" width="350">Remarks</th>
        <th class="p-4 text-center">Action</th>
      </tr>

      <tr
        v-for="(row, i) of listDetails"
        :key="row.id"
        class="border-t hover:bg-gray-100 focus-within:bg-gray-100"
      >
        <td class="p-3">
          {{ +i + 1 }}
        </td>
        <td class="p-3">
          {{ row.field.field_name }}
        </td>
        <td class="p-3">
          {{ row.data }}
        </td>
        <td class="p-3">
          <p v-if="row.remarks">
            {{ row.remarks.slice(0, row.show_text ? row.show_text : 100) }}
            <button
              v-if="row.remarks.length > 100"
              @click="showMore(row, i)"
              class="text-blue-600 font-bold"
            >
              {{ row.is_read_more ? "Read Less" : "Read More" }}
            </button>
          </p>
        </td>
        <td class="p-3 w-64">
          <div class="flex place-content-center">
            <div class="grid mr-4">
              <inertia-link
                class="focus:text-indigo-500"
                :href="route('records-details.edit', row.id)"
                tabindex="-1"
              >
                <icon
                  name="cheveron-right"
                  class="w-6 h-6 m-auto fill-gray-400"
                />
              </inertia-link>
            </div>
          </div>
        </td>
      </tr>
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
    };
  },

  mounted() {
    this.getDetails();
  },
  methods: {
    getDetails() {
      axios
        .post(this.route("records-details.listUpdate"), this.form)
        .then((response) => {
          this.listDetails = response.data;
        });
    },
  },
};
</script>
