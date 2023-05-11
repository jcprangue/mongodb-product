<template>
  <div>
   

    <div class="flex justify-between my-4">
      <div class="grid w-full grid-cols-3">
        <div class="col-span-4 mx-4">
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
import LineChart from "./LineChart";
import axios from "axios";

export default {
  components: {
    LineChart,
  },
  props: {
    product: {
      type: Array,
      default: () => {},
    },
    quantity: {
      type: Array,
      default: () => {},
    },
    
  },
  data() {
    return {
      chartLoaded: true,
      chartData: null,
      chartOptions: null,
      chartGradient: null,
      chartGradient2: null,
    };
  },
  mounted() {
    this.loadData();
  },
  methods: {
    loadData() {
      this.chartData = {
        labels: this.product,
        datasets: [
          {
            label: "Quantity of Products",
            // data: response.data.data,
            data: this.quantity,
            backgroundColor: this.chartGradient,
            borderColor: "#05CBE1",
            pointBackgroundColor: "white",
          },
        ],
      }

      this.chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
      }
          
      
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
