<template>
  <div class="container mx-auto mt-8">

    <div class="flex justify-between mb-4">
      <input
        class="relative w-4/5 px-6 mr-3 py-3 rounded-r focus:shadow-outline"
        autocomplete="off"
        type="text"
        name="search"
        placeholder="Type keyword here"
        @input="debounceSearch"
      />

      <inertia-link
        class="btn-indigo mr-3"
        :href="route('products.chart')"
        target="_Blank"
      >
        <span>Show&nbsp;Chart</span>
      </inertia-link>
     
      
    </div>

    <table class="w-full my-4 whitespace-no-wrap bg-white text-sm">
      <tr class="font-bold text-left">
        <th class="p-4 text-center w-48">IMAGE</th>
        <th class="p-4 text-left w-48">TITLE</th>
        <th class="p-4 text-left w-48">SKU</th>
        <th class="p-4 text-left w-48">PRICE</th>
        <th class="p-4 text-center w-24">QUANTITY</th>
        <th class="p-4 text-center w-2/6">INGREDIENT</th>
        <th class="p-4 text-center">ACTION</th>
      </tr>

      <tr
        v-for="(row, i) of records.data"
        :key="row._id"
        class="border-t hover:bg-gray-100 focus-within:bg-gray-100"
      >
        <td class="p-3" valign="top">
          <img :src="row.image" class="w-full md:max-w-lg h-auto">
        </td>
        <td class="p-3" valign="top">
          <h2 class="product-title" @mouseover="setHover(true)" @mouseleave="setHover(false)">
            <span v-if="!row.editing">{{ row.title }}</span>
            <input v-else type="text" v-model="row.title" class="form-input" @keyup.enter="saveProduct(row)" />
            <button v-if="hover && !row.editing" class="edit-btn" @click="editProduct(row)">Edit</button>
          </h2>
          
        </td>
        <td class="p-3" valign="top">
          {{ row.sku }}
        </td>
        <td class="p-3" valign="top">
          {{ row.price }}
        </td>
        <td class="p-3 text-center" valign="top">
          <span v-if="!row.editing">{{ row.quantity }}</span>
          <input v-else type="text" v-model="row.quantity" class="form-input" @keyup.enter="saveProduct(row)" />
        </td>
        <td class="p-3" valign="top">
          <p v-if="!row.editing">
            {{ row.ingredient.slice(0, row.show_text ? row.show_text : 200) }}
            <button
              v-if="row.ingredient.length > 200"
              @click="showMore(row, i)"
              class="text-blue-600 font-bold"
            >
              {{ row.is_read_more ? "Read Less" : "Read More" }}
            </button>
          </p>
          <textarea v-else class="form-input" rows="5" v-model="row.ingredient" @keyup.enter="saveProduct(row)" ></textarea>
        </td>
       
        <td class="p-3 text-center" valign="top">
          <div class="flex justify-center items-center">
            
            <inertia-link
              class="focus:text-indigo-500"
              :href="route('products.show', row._id)"
              tabindex="-1"
            >
              <icon
                name="eye"
                class="w-6 h-6 m-auto fill-gray-400"
              />
            </inertia-link>
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
    
    records: {
      type: [Array, Object],
      default: () => {},
    },
    filters: {
      type: [Array, Object],
      default: () => {},
    },
   
    
  },
  data() {
    return {
      filterForm: {
        search: this.filters.search,
      },
      hover: false,
      debounce: null
    };
  },
  watch: {
    filterForm: {
      handler: throttle(function () {
        this.$inertia.replace(this.route("products.index", this.filterForm));
      }, 150),

      deep: true,
    },
  },
  mounted() {
    // this.showBrgy(this.filterForm.lgu_id);
  },
  methods: {
    debounceSearch(event) {
      clearTimeout(this.debounce)
      this.debounce = setTimeout(() => {
        this.filterForm.search = event.target.value
      }, 600)
    },
   
    showMore(row, i) {
      if (!this.records.data[i].is_read_more) {
        this.records.data[i].is_read_more = true;
        this.records.data[i].show_text = row.ingredient.length;
      } else {
        this.records.data[i].is_read_more = false;
        this.records.data[i].show_text = 200;
      }
      this.$forceUpdate();
    },
    setHover(value) {
      this.hover = value;
    },
    editProduct(row) {
      row.editing = true;
    },
    saveProduct(row) {
      axios.put(this.route("products.update",row._id), row).then(response => {
          row.editing = false;
          this.$forceUpdate();
      })
     
      
      
    },
    submit() {
      this.$inertia.get(this.route("records.index"), this.filterForm);
    },
    
  },
};
</script>


<style>
.product-title {
  display: inline-block;
  position: relative;
  color:green;
  font-weight: 700;
}

.product-title:hover::before {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
}

.edit-btn {
  color: blue;
  border: none;
  visibility: hidden;
  transition: all 0.3s ease;
}

.product-title:hover .edit-btn {
  visibility: visible;
  right: 0;
}
</style>
