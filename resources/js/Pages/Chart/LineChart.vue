<script>
import { Bar, mixins } from "vue-chartjs";

export default {
  extends: Bar,
  mixins: [mixins.reactiveProp],
  props: ["chartData", "options"],
  data() {
    return {};
  },
  watch: {
    chartData() {
      this.$data._chart.update();
    },
  },
  mounted() {
    this.renderChart(this.chartData, this.options);
  },
};
</script>
