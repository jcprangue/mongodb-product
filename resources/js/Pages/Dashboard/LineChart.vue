<script>
import { Line, mixins } from "vue-chartjs";

export default {
  extends: Line,
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
