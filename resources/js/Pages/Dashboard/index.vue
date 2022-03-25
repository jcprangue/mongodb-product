<template>
  <div>
    <div class="flex justify-between">
      <form @submit.prevent="filter">
        <div class="grid grid-cols-5">
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
            <button type="submit" class="btn-indigo">Filter</button>
          </div>
        </div>
      </form>
    </div>

    <div class="flex justify-between my-4">
      <div class="grid w-full grid-cols-3">
        <div class="col-span-1">
          <div class="my-2 font-bold leading-6">
            Number of Procurement each Category
          </div>
          <div class="overflow-y-auto" style="height: calc(100vh - 300px)">
            <div class="flex bg-white border-t border-b border-l">
              <div class="w-1/12 px-2 py-1 border-b border-r">#</div>
              <div class="w-9/12 px-2 py-1 border-b border-r">Category</div>
              <div class="w-2/12 px-2 py-1 border-b border-r">Count</div>
            </div>
            <div
              class="flex bg-white border-t border-l cursor-pointer"
              :class="{
                'text-white bg-indigo-600': chartForm.category === row.id,
              }"
              v-for="(row, i) in categories"
              :key="i"
              @click="selectCategory(row.id)"
            >
              <div class="w-1/12 px-2 py-1 border-b border-r">
                {{ +i + 1 }}
              </div>
              <div class="w-9/12 px-2 py-1 border-b border-r">
                {{ row.abbr }}
              </div>
              <div class="w-2/12 px-2 py-1 text-right border-b border-r">
                {{ row.procurement_records.length }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-span-2 mx-4">
          <line-chart
            v-show="chartLoaded"
            :chartData="chartData"
            :options="chartOptions"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import LineChart from "./LineChart";
import DateInput from "@/Shared/DateInput";
import LineChart from "./LineChart";
import axios from "axios";

export default {
  components: {
    DateInput,
    LineChart,
  },
  props: {
    categories: {
      type: Array,
      default: () => {},
    },
    date: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      filterForm: {
        month_from: this.date.from,
        month_to: this.date.to,
        category_id: "",
      },
      chartForm: {
        month: null,
        category: null,
      },
      chartLoaded: false,
      chartData: null,
      chartOptions: null,
      chartGradient: null,
      chartGradient2: null,
    };
  },
  methods: {
    filter() {
      this.$inertia.get(this.route("dashboard.index"), {
        data: this.filterForm,
      });
    },
    selectCategory(id) {
      this.filterForm.category_id = id;
      axios
        .post(`/dashboard/status/category`, this.filterForm, {
          headers: {
            "X-CSRF-TOKEN": document.head.querySelector(
              'meta[name="csrf-token"]'
            ).content,
            "X-Requested-With": "XMLHttpRequest",
          },
          // responseType: "blob", // important
        })
        .then((response) => {
          this.sending = false;
          this.chartLoaded = true;
          if (!this.chartGradient) {
            this.applyGradient();
          }
          console.log(response.data);
          (this.chartData = {
            // labels: response.data.labels,
            labels: response.data.months,
            datasets: [
              {
                label: "Number of Procurement",
                // data: response.data.data,
                data: response.data.count,
                backgroundColor: this.chartGradient,
                borderColor: "#05CBE1",
                pointBackgroundColor: "white",
              },
            ],
          }),
            (this.chartOptions = {
              responsive: true,
              maintainAspectRatio: false,
            });
        })
        .catch((e) => {
          this.sending = false;
          console.log("error", e);
          console.log("error.response", e.response);
        });
    },
    applyGradient() {
      this.chartGradient = document
        .querySelector("canvas")
        .getContext("2d")
        .createLinearGradient(0, 0, 0, 450);
      this.chartGradient2 = document
        .querySelector("canvas")
        .getContext("2d")
        .createLinearGradient(0, 0, 0, 450);

      this.chartGradient.addColorStop(0, "rgba(0, 231, 255, 0.9)");
      this.chartGradient.addColorStop(0.5, "rgba(0, 231, 255, 0.25)");
      this.chartGradient.addColorStop(1, "rgba(0, 231, 255, 0)");

      this.chartGradient2.addColorStop(0, "rgba(255, 0,0, 0.5)");
      this.chartGradient2.addColorStop(0.5, "rgba(255, 0, 0, 0.25)");
      this.chartGradient2.addColorStop(1, "rgba(255, 0, 0, 0)");
    },
  },
};
</script>
