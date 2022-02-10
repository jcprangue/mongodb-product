<template>
  <div class="flex justify-between my-4">
    <div class="grid w-full grid-cols-3">
      <div class="col-span-1">
        <form ref="formCreate" @submit.prevent="submit">
          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <text-input
              class="w-full pr-6"
              label="Field Name"
              v-model="form.field_name"
              :error="errors.field_name"
            />
          </div>
          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <select-input
              v-model="form.field_type"
              class="w-full pb-8 pr-6"
              label="Field Type"
              :error="errors.field_type"
            >
              <option :value="null">--Select Field--</option>
              <option
                v-for="(fieldType, i) of fieldTypes"
                :key="i"
                :value="fieldType"
              >
                {{ fieldType }}
              </option>
            </select-input>
          </div>

          <div
            class="
              flex
              items-center
              justify-between
              px-8
              py-4
              bg-gray-100
              border-t border-gray-200
            "
          >
            <button
              v-if="form.id != null"
              class="btn-red"
              tabindex="-1"
              type="button"
              @click="destroy"
            >
              Delete Field
            </button>
            <loading-button
              v-if="form.id != null"
              :loading="sendingUpdate"
              class="btn-indigo"
              type="submit"
            >
              Update Field
            </loading-button>
            <loading-button
              v-if="form.id == null"
              :loading="sending"
              class="btn-indigo"
              type="submit"
            >
              Add Field
            </loading-button>
          </div>
        </form>
      </div>
      <div class="col-span-2 mx-4">
        <div class="my-2 font-bold leading-6">
          List of Field for {{ document.name }}
        </div>
        <div class="overflow-y-auto" style="height: calc(100vh - 300px)">
          <div class="flex bg-white border-t border-b border-l">
            <div class="w-1/12 px-2 py-1 border-b border-r">#</div>
            <div class="w-4/12 px-2 py-1 border-b border-r">Field Name</div>
            <div class="w-1/4 px-2 py-1 border-b border-r">Field Type</div>
            <div class="w-2/12 px-2 py-1 border-b border-r">Precedence</div>
            <div class="w-2/12 px-2 py-1 border-b border-r text-center">
              Action
            </div>
          </div>

          <draggable :list="fields" group="people" @change="updateData">
            <div
              v-for="(row, i) in fields"
              :key="row.id"
              class="flex bg-white border-t border-l"
            >
              <div class="w-1/12 px-2 py-1 border-b border-r">
                {{ +i + 1 }}
              </div>
              <div class="w-4/12 px-2 py-1 border-b border-r">
                {{ row.field_name }}
              </div>
              <div class="w-1/4 px-2 py-1 border-b border-r">
                {{ row.field_type }}
              </div>
              <div class="w-2/12 px-2 py-1 text-right border-b border-r">
                {{ row.precedence }}
              </div>
              <div class="w-2/12 px-2 py-1 text-right border-b border-r">
                <div class="flex place-content-center">
                  <div class="grid mr-4">
                    <button
                      class="focus:text-indigo-500"
                      tabindex="-1"
                      @click="editField(row)"
                    >
                      <icon
                        name="cheveron-right"
                        class="w-6 h-6 m-auto fill-gray-400"
                      />
                    </button>
                  </div>
                </div>
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
import DateInput from "@/Shared/DateInput";
import SelectInput from "@/Shared/SelectInput";
import SearchFilter from "@/Shared/SearchFilter";
import Icon from "@/Shared/Icon";
import TextInput from "@/Shared/TextInput";
import LoadingButton from "@/Shared/LoadingButton";
import draggable from "vuedraggable";

export default {
  components: {
    DateInput,
    SelectInput,
    SearchFilter,
    LoadingButton,
    TextInput,
    Icon,
    draggable,
  },
  props: {
    document: {
      type: [Object, Array],
      default: () => {},
    },
    fields: {
      type: [Object, Array],
      default: () => {},
    },
    filters: { type: [Object, Array], default: () => {} },
    errors: { type: Object, default: () => {} },
  },
  data() {
    return {
      form: {
        id: null,
        document_id: this.document.id,
        field_name: null,
        field_type: null,
        precedence: null,
      },
      sending: false,
      sendingUpdate: false,
      fieldTypes: ["Text Input", "Date Input"],
    };
  },

  methods: {
    submit() {
      this.sending = true;
      this.sendingUpdate = true;
      this.$inertia
        .post(this.route("field.store"), this.form)
        .then((response) => {
          this.sending = false;
          this.sendingUpdate = false;
          this.clearForm();
        });
    },
    clearForm() {
      this.form.id = null;
      this.form.field_name = "";
      this.form.field_type = "";
    },
    editField(data) {
      this.form = data;
    },
    destroy() {
      if (confirm("Are you sure you want to delete this LGU?")) {
        this.$inertia.delete(this.route("field.destroy", this.form.id));
        this.clearForm();
      }
    },
    updateData() {
      // const vm = this;
      // axios
      //   .post(this.route("field.updateOrder"), vm.fields)
      //   .then((response) => {});

      this.$inertia
        .post(this.route("field.updateOrder"), this.fields)
        .then((response) => {});
    },
  },
};
</script>
