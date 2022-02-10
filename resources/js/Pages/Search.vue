<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link class="text-indigo-400 hover:text-indigo-600" href="/">
          Search Procurement
        </inertia-link>
        <span class="font-medium">/</span>
        {{ keyword }}
      </h2>
    </template>

    <div class="py-12">
      <div class="sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <SearchPanel :keyword="keyword" :record="record" />
        </div>
      </div>
    </div>
  </app-layout>
</template>


<script>
import AppLayout from "@/Layouts/SearchLayout";
import SearchPanel from "@/Pages/Search/index";

export default {
  components: {
    AppLayout,
    SearchPanel,
  },
  props: {
    keyword: {
      type: String,
      default: () => {},
    },
    record: { type: [Object, Array], default: () => {} },
  },
  data() {
    return {
      form: {
        qrcode: "",
      },
    };
  },
  methods: {
    submit() {
      window.location.href = "/search?id=" + this.form.qrcode;
    },
  },
};
</script>

