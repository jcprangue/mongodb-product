<template>
  <div>
    <!-- <div class="flex justify-end mb-4">
      <inertia-link class="btn-indigo mr-3" href="">
        <span>Create Procurement</span>
      </inertia-link>

      <inertia-link class="btn-green" href="">
        <span>Export</span>
      </inertia-link>
    </div> -->

    <div class="flex justify-between mb-4">
      <input
        class="relative w-4/5 px-6 mr-3 py-3 rounded-r focus:shadow-outline"
        autocomplete="off"
        type="text"
        name="search"
        placeholder="Type keyword here"
        v-model="filterForm.search"
      />

      <inertia-link
        class="btn-indigo mr-3"
        :href="route('records.create')"
        target="_Blank"
      >
        <span>Create Procurement</span>
      </inertia-link>

      <a
        class="btn-green mr-3"
        :href="route('records.export', this.filterForm)"
      >
        <span>Export</span>
      </a>

      <a class="btn-green" :href="route('records.pdf', this.filterForm)">
        <span>Print</span>
      </a>
      <div></div>
    </div>

    <div class="flex justify-between">
      <form @submit.prevent="submit">
        <div class="grid grid-cols-8">
          <select-input
            v-model="filterForm.category"
            class="pr-6"
            label="Category"
          >
            <!-- <option :value="null">All</option> -->
            <option
              v-for="(category, i) of categories"
              :key="i"
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </select-input>
          <select-input
            v-model="filterForm.office_id"
            class="pr-6"
            label="Office"
          >
            <option :value="null">All</option>
            <option v-for="(office, i) of offices" :key="i" :value="office.id">
              {{ office.abbr }}
            </option>
          </select-input>
          <select-input
            v-model="filterForm.lgu_id"
            class="pr-6"
            label="Municipality"
          >
            <option :value="null">All</option>
            <option v-for="(lgu, i) of LGUs" :key="i" :value="lgu.id">
              {{ lgu.lgus }}
            </option>
          </select-input>
          <select-input
            v-model="filterForm.barangay_id"
            class="pr-6"
            label="Barangay"
          >
            <option :value="null">All</option>
            <option
              v-for="(barangay, i) of barangays"
              :key="i"
              :value="barangay.id"
            >
              {{ barangay.brgyDesc }}
            </option>
          </select-input>
          <date-input
            type="month"
            format="YYYY-MM"
            v-model="filterForm.month_from"
            class="pr-6"
            label="Month From"
          />

          <date-input
            type="month"
            format="YYYY-MM"
            v-model="filterForm.month_to"
            class="pr-6"
            label="Month To"
          />

          <div class="flex items-end">
            <button type="submit" class="btn-green">Filter</button>
            <button
              class="
                p-3
                text-sm text-gray-500
                hover:text-gray-700
                focus:text-indigo-500
              "
              type="button"
              @click="reset"
            >
              Reset
            </button>
          </div>
        </div>
      </form>
    </div>

    <table class="w-full my-4 whitespace-no-wrap bg-white text-sm">
      <tr class="font-bold text-left">
        <th class="p-4 text-center">#</th>
        <th class="p-4 text-center" width="150">Bid Date</th>
        <th class="p-4 text-center" width="150">IB Number</th>
        <th class="p-4 text-center" width="350">Project Name</th>
        <th class="p-4 text-center" width="250">Contractor</th>
        <th class="p-4 text-center">Amount</th>
        <th class="p-4 text-center" width="150">Status</th>
        <th class="p-4 text-center">Remarks</th>
        <th class="p-4 text-center">Action</th>
      </tr>

      <tr
        v-for="(row, i) of records.data"
        :key="row.id"
        class="border-t hover:bg-gray-100 focus-within:bg-gray-100"
      >
        <td class="p-3">
          {{ +i + 1 }}
        </td>
        <td class="p-3">
          {{ row.bid_opening_date }}
        </td>
        <td class="p-3">
          <inertia-link
            class="focus:text-indigo-500"
            :href="route('records-link.edit', row.id)"
            tabindex="-1"
          >
            <span class="text-blue-600 font-bold">{{ row.ib_number }}</span>
          </inertia-link>
        </td>
        <td class="p-3">
          {{ row.project_name }}
        </td>
        <td class="p-3">
          {{ row.contractor }}
        </td>
        <td class="p-3">
          {{ row.amount.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
        </td>
        <td class="p-3">
          {{ row.status }}
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
                :href="route('records.edit', row.id)"
                tabindex="-1"
              >
                <icon
                  name="cheveron-right"
                  class="w-6 h-6 m-auto fill-gray-400"
                />
              </inertia-link>
            </div>
            <div class="grid">
              <inertia-link
                class="focus:text-indigo-500"
                :href="route('records-details.index', { id: row.id })"
                tabindex="-1"
              >
                <icon name="list-clock" class="w-6 h-6 m-auto fill-gray-400" />
              </inertia-link>
            </div>
          </div>
        </td>
      </tr>
    </table>
    <pagination :links="records.links" />
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
import Pagination from "@/Shared/Pagination";

export default {
  components: {
    DateInput,
    SelectInput,
    SearchFilter,
    Icon,
    Pagination,
  },
  props: {
    categories: {
      type: Array,
      default: () => {},
    },
    LGUs: {
      type: [Array, Object],
      default: () => {},
    },
    records: {
      type: [Array, Object],
      default: () => {},
    },
    filters: {
      type: [Array, Object],
      default: () => {},
    },
    offices: {
      type: [Array, Object],
      default: () => {},
    },
  },
  data() {
    return {
      filterForm: {
        search: this.filters.search,
        category: this.filters.category,
        lgu_id: this.filters.lgu_id,
        office_id: this.filters.office_id,
        barangay_id: this.filters.barangay_id,
        month_from: this.filters.month_from,
        month_to: this.filters.month_to,
      },
      barangays: [],
    };
  },
  watch: {
    "filterForm.lgu_id": function (val) {
      this.showBrgy(val);
    },
    filterForm: {
      handler: throttle(function () {
        this.$inertia.replace(this.route("records.index", this.filterForm));
      }, 150),

      deep: true,
    },
  },
  mounted() {
    this.showBrgy(this.filterForm.lgu_id);
  },
  methods: {
    showBrgy(val) {
      const self = this;
      this.LGUs.forEach((e) => {
        if (e.id == val) {
          self.barangays = e.barangay;
        }
      });
    },
    showMore(row, i) {
      if (!this.records.data[i].is_read_more) {
        this.records.data[i].is_read_more = true;
        this.records.data[i].show_text = row.remarks.length;
      } else {
        this.records.data[i].is_read_more = false;
        this.records.data[i].show_text = 100;
      }
      this.$forceUpdate();
    },
    submit() {
      this.$inertia.get(this.route("records.index"), this.filterForm);
    },
    reset() {
      this.filterForm = mapValues(this.filterForm, () => null);
      this.submit();
    },
  },
};
</script>
