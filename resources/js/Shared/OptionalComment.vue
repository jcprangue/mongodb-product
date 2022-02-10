<template>
  <div class="w-full">
    <div class="table w-full text-xl table-fixed md:px-6 md:text-3xl">
      <div
        v-for="(question,i) in questions"
        :key="question.id"
        class="border-b-2"
        :class="{'bg-gray-200':i%2===0}"
      >
        <label class="flex w-full cursor-pointer select-none">
          <div class="self-center text-lg md:text-4xl">
            <p-check
              name="check"
              color="primary"
              :value="question.id"
              v-model="answers"
              class="ml-2 p-curve p-thick p-smooth p-svg"
              :disabled="answers.length >= maxChecked && answers.indexOf(question.id) == -1"
              :class="{'bg-grey-200':answers.length >= maxChecked && answers.indexOf(question.id) == -1}"
            >
              <svg slot="extra" class="svg svg-icon" viewBox="0 0 20 20">
                <path
                  d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z"
                  style="stroke: white;fill:white"
                />
              </svg>
            </p-check>
          </div>
          <div class="p-1 md:p-2 flex-grow-1">
            <p>{{ question.question }}</p>
          </div>
        </label>
      </div>
    </div>
  </div>
</template>

<script>
import PCheck from "pretty-checkbox-vue/check";

export default {
  components: {
    PCheck,
  },
  props: {
    questions: { type: Array, default: () => {} },
    questionNumber: { type: [Number, Boolean], default: null },
    questionType: { type: String, default: "" },
    maxChecked: { type: [Number, Boolean], default: null },
  },
  data() {
    return {
      answers: [],
    };
  },
 
  mounted() {
    // console.log("questions", this.questions);
  },
  watch: {
    answers() {
      this.$emit(
        "answers-optional",
        this.questionNumber,
        this.questionType,
        this.answers
      );
    },
  },
  methods: {
  },
};
</script>
