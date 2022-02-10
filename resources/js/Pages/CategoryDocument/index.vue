<template>
  <div class="flex justify-between my-4">
    <div class="grid w-full grid-cols-3">
      <div class="col-span-2 mx-4">
        <div class="my-2 font-bold leading-6">
          List of Documents for {{ category.name }}
        </div>
        <div class="overflow-y-auto">
          <draggable
            :list="categoryDocuments"
            group="people"
            @change="updateData"
          >
            <div
              v-for="(row, i) in categoryDocuments"
              :key="row.id"
              class="flex bg-white border-t border-l"
            >
              <div class="w-full p-4 border-b border-r">
                {{ +i + 1 }}. {{ row.name }}
              </div>
            </div>

            <div
              v-if="categoryDocuments.length == 0"
              class="flex bg-white border-t border-l"
            >
              <div class="w-full p-4 border-b border-r text-center">
                -- DRAG HERE --
              </div>
            </div>
          </draggable>
        </div>
      </div>

      <div class="col-span-1">
        <div class="my-2 font-bold leading-6">List of Documents</div>
        <div class="overflow-y-auto">
          <draggable :list="documents" group="people">
            <div
              v-for="(document, i) in documents"
              :key="document.id"
              class="flex bg-white border-t border-l"
            >
              <div class="w-full p-4 border-b border-r">
                {{ +i + 1 }}. {{ document.name }}
              </div>
            </div>

            <div
              v-if="documents.length == 0"
              class="flex bg-white border-t border-l"
            >
              <div class="w-full p-4 border-b border-r text-center">
                -- DRAG HERE --
              </div>
            </div>
          </draggable>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import LineChart from "./LineChart";
import Icon from "@/Shared/Icon";
import LoadingButton from "@/Shared/LoadingButton";
import draggable from "vuedraggable";

export default {
  components: {
    LoadingButton,
    Icon,
    draggable,
  },
  props: {
    category: {
      type: [Object, Array],
      default: () => {},
    },
    documents: {
      type: [Object, Array],
      default: () => {},
    },
    categoryDocuments: {
      type: [Object, Array],
      default: () => {},
    },
    filters: { type: [Object, Array], default: () => {} },
    errors: { type: Object, default: () => {} },
  },
  data() {
    return {};
  },

  methods: {
    updateData() {
      // const vm = this;
      // axios
      //   .post(this.route("field.updateOrder"), vm.fields)
      //   .then((response) => {});

      this.$inertia
        .put(
          this.route("category-document.update", this.category.id),
          this.categoryDocuments
        )
        .then((response) => {});
    },
  },
};
</script>
