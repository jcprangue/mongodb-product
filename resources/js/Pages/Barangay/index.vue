<template>
  <div>
    <div class="flex justify-between">
      <search-filter
        v-model="filterForm.search"
        class="w-full max-w-md mr-4"
        @reset="reset"
      >
      </search-filter>

      <inertia-link
        class="btn-indigo"
        :href="route('brgy.create', municipal.id)"
      >
        <span>Create</span>
        <span class="hidden md:inline">Barangay</span>
      </inertia-link>
    </div>

    <table class="w-full my-4 whitespace-no-wrap bg-white">
      <tr class="font-bold text-left">
        <th class="p-4">#</th>
        <th class="p-4">Barangay</th>
        <th class="p-4 text-center">Action</th>
      </tr>

      <tr
        v-for="(row, i) of barangays"
        :key="row.id"
        class="border-t hover:bg-gray-100 focus-within:bg-gray-100"
      >
        <td class="p-3">
          {{ +i + 1 }}
        </td>
        <td class="p-3">
          {{ row.brgyDesc }}
        </td>
        <td class="p-3 w-64">
          <div class="flex place-content-center">
            <div class="grid mr-4">
              <inertia-link
                class="focus:text-indigo-500"
                :href="route('brgy.edit', row.id)"
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
// import LineChart from "./LineChart";
import DateInput from "@/Shared/DateInput";
import SelectInput from "@/Shared/SelectInput";
import SearchFilter from "@/Shared/SearchFilter";
import Icon from "@/Shared/Icon";
import mapValues from "lodash/mapValues";
import throttle from "lodash/throttle";

export default {
  components: {
    DateInput,
    SelectInput,
    SearchFilter,
    Icon,
  },
  props: {
    barangays: {
      type: [Object, Array],
      default: () => {},
    },
    filters: { type: [Object, Array], default: () => {} },
    municipal: { type: [Object, Array], default: () => {} },
  },
  data() {
    return {
      filterForm: {
        id: this.municipal.id,
        search: this.filters.search,
      },
    };
  },
  watch: {
    filterForm: {
      handler: throttle(function () {
        this.$inertia.replace(this.route("brgy.index", this.filterForm));
      }, 150),
      deep: true,
    },
  },
  methods: {
    submit() {
      this.$inertia.get(this.route("brgy.index"), {
        data: this.filterForm,
      });
    },
    reset() {
      this.filterForm = mapValues(this.filterForm, () => null);
      this.submit();
    },
  },
};
</script>
