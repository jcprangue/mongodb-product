<template>
  <div class="container mx-auto py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="flex justify-center items-center">
        <img :src="records.image" alt="Product Image" class="w-full max-w-lg">
      </div>
      <div>
        <h2 class="text-2xl font-bold mb-4">{{ records.title}}</h2>
        <h5>Product SKU : {{ records.sku }}</h5>
        <span class="flex items-center mb-4">
          <span class="text-lg font-bold mr-2">Price {{ records.price}}</span> <span class="text-lg font-bold ml-2"> Number of Stocks : {{ records.quantity }}</span>
        </span>
        <p class="text-gray-600 mb-4">{{ records.ingredient}}</p>

        
      </div>
    </div>
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
    console.log(this.records);
  },
  methods: {
   
  },
};
</script>
