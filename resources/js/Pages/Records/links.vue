<template>
  <div class="flex justify-between my-4">
    <div class="grid w-full grid-cols-3">
      <div class="col-span-1">
        <div class="my-2 font-bold leading-6">List of Links</div>
        <div class="overflow-y-auto" style="height: calc(100vh - 300px)">
          <div class="flex bg-white border-t border-b border-l">
            <div class="w-1/12 px-2 py-1 border-b border-r">#</div>
            <div class="w-full px-2 py-1 border-b border-r">Links</div>
          </div>

          <div
            v-for="(row, i) in links"
            :key="row.id"
            class="flex bg-white border-t border-l"
          >
            <div class="w-1/12 px-2 py-1 border-b border-r">
              {{ +i + 1 }}
            </div>
            <div
              class="w-full px-2 py-1 border-b border-r"
              @click="getURL(row.url)"
              style="cursor: pointer"
            >
              {{ row.url }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-2 mx-4">
        <iframe
          :src="url"
          frameborder="1"
          class="w-full"
          style="height: calc(100vh)"
        ></iframe>
      </div>
    </div>
  </div>
</template>

<script>
// import LineChart from "./LineChart";

export default {
  props: {
    links: {
      type: [Object, Array],
      default: () => {},
    },
    record: {
      type: [Object, Array],
      default: () => {},
    },
  },
  data() {
    return {
      url: "",
    };
  },

  methods: {
    getURL(url) {
      this.url = url;
    },
  },
};
</script>
