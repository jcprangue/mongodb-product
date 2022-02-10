<script>
export default {
  name: "ErrorBoundary",
  data: () => ({ error: null }),
  errorCaptured(err, vm, info) {
    this.error = `${err.stack}\n\nfound in ${info} of component`;
    return false;
  },
  render(h) {
    if (this.error) {
      return h("pre", { style: { color: "red" } }, this.error);
    }
    return this.$slots.default[0]; //default slot
  },
};
</script>
