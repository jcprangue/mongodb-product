<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="route('records.index')"
        >
          Procurement Records
        </inertia-link>
        <span class="font-medium">/</span>
        Edit {{ record.project_name }}
      </h2>
    </template>

    <div class="py-4">
      <div class="max-w-3xl m-auto overflow-hidden bg-white rounded shadow-xl">
        <form ref="formCreate" @submit.prevent="submit">
          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <date-input
              type="date"
              format="YYYY-MM-DD"
              v-model="form.bid_opening_date"
              :error="errors.bid_opening_date"
              class="w-full pb-8 pr-6 lg:w-1/2"
              label="Bid Opening Date"
            />

            <text-input
              v-model="form.ib_number"
              :error="errors.ib_number"
              class="w-full pb-8 pr-6 lg:w-1/2"
              label="IB Number"
            />
          </div>

          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <text-input
              v-model="form.project_name"
              :error="errors.project_name"
              class="w-full pb-8 pr-6 lg:w-full"
              label="Project Name"
            />
          </div>

          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <text-input
              v-model="form.contractor"
              :error="errors.contractor"
              class="w-full pb-8 pr-6 lg:w-1/2"
              label="Contractor"
            />

            <text-input
              v-model="form.amount"
              :error="errors.amount"
              class="w-full pb-8 pr-6 lg:w-1/2"
              label="Amount"
            />
          </div>

          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <select-input
              v-model="form.category_id"
              :error="errors.category_id"
              class="w-1/2 pb-8 pr-6"
              label="Category"
            >
              <option :value="null">--Select Category--</option>
              <option
                v-for="(catagory, i) of categories"
                :key="i"
                :value="catagory.id"
              >
                {{ catagory.name }}
              </option>
            </select-input>

            <select-input
              v-model="form.office_id"
              :error="errors.office_id"
              class="w-1/2 pb-8 pr-6"
              label="Office"
            >
              <option :value="null">--Select Office--</option>
              <option
                v-for="(office, i) of offices"
                :key="i"
                :value="office.id"
              >
                {{ office.abbr }}
              </option>
            </select-input>
          </div>

          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <select-input
              v-model="form.lgu_id"
              class="w-full pb-8 pr-6 lg:w-1/2"
              :error="errors.lgu_id"
              label="Municipality"
            >
              <option :value="null">--Select LGU--</option>

              <option v-for="(lgu, i) of LGUs" :key="i" :value="lgu.id">
                {{ lgu.lgus }}
              </option>
            </select-input>

            <select-input
              v-model="form.barangay_id"
              class="w-full pb-8 pr-6 lg:w-1/2"
              :error="errors.barangay_id"
              label="Barangay"
            >
              <option :value="null">--Select Barangay--</option>

              <option
                v-for="(barangay, i) of barangays"
                :key="i"
                :value="barangay.id"
              >
                {{ barangay.brgyDesc }}
              </option>
            </select-input>
          </div>

          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <textarea-input
              v-model="form.status"
              :error="errors.status"
              class="w-full pb-8 pr-6"
              label="Status"
            />
          </div>

          <div class="flex flex-wrap p-8 -mb-8 -mr-6">
            <textarea-input
              v-model="form.remarks"
              :error="errors.remarks"
              class="w-full pb-8 pr-6"
              label="Remarks"
            />
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
              v-if="!record.deleted_at"
              class="btn-red"
              tabindex="-1"
              type="button"
              @click="destroy"
            >
              Delete Procurement
            </button>
            <loading-button :loading="sending" class="btn-indigo" type="submit">
              Update Procurement
            </loading-button>
          </div>
        </form>
      </div>
    </div>
  </app-layout>
</template>


<script>
import AppLayout from "@/Layouts/AppLayout";
import LoadingButton from "@/Shared/LoadingButton";
import SelectInput from "@/Shared/SelectInput";
import TextInput from "@/Shared/TextInput";
import TextareaInput from "@/Shared/TextareaInput";
import DateInput from "@/Shared/DateInput";

export default {
  components: {
    DateInput,
    AppLayout,
    LoadingButton,
    SelectInput,
    TextInput,
    TextareaInput,
  },
  props: {
    errors: { type: Object, default: () => {} },
    categories: { type: [Object, Array], default: () => {} },
    LGUs: { type: [Object, Array], default: () => {} },
    record: { type: [Object, Array], default: () => {} },
    offices: { type: [Object, Array], default: () => {} },
  },
  data() {
    return {
      sending: false,
      form: {
        bid_opening_date: this.record.bid_opening_date,
        ib_number: this.record.ib_number,
        project_name: this.record.project_name,
        contractor: this.record.contractor,
        category_id: this.record.category_id,
        office_id: this.record.office_id,
        amount: this.record.amount,
        lgu_id: this.record.lgu_id,
        barangay_id: this.record.barangay_id,
        status: this.record.status,
        remarks: this.record.remarks,
      },

      barangays: [],
    };
  },
  watch: {
    "form.lgu_id": function (val) {
      this.showBrgy(val);
    },
  },
  mounted() {
    this.showBrgy(this.form.lgu_id);
    this.displayValue(this.form.amount)
  },
  methods: {
    displayValue(value){
      var displayValue = value || ""; //check if this.value is null
      displayValue = String(displayValue).replace(/,/g, ""); //replace ,
      this.form.amount = displayValue

    },
    showBrgy(val) {
      const self = this;
      this.LGUs.forEach((e) => {
        if (e.id == val) {
          self.barangays = e.barangay;
        }
      });
    },
    submit() {
      this.sending = true;
      this.$inertia
        .patch(this.route("records.update", this.record.id), this.form)
        .then(() => (this.sending = false))
        .catch((e) => console.log(e) );
    },
    destroy() {
      if (confirm("Are you sure you want to delete this LGU?")) {
        this.$inertia.delete(this.route("records.destroy", this.record.id));
      }
    },
  },
};
</script>
