<template>
  <div
    class="
      relative
      flex
      items-top
      justify-center
      min-h-screen
      bg-gray-100
      dark:bg-gray-900
      sm:items-center sm:pt-0
    "
  >
    <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
      <inertia-link
        v-if="$page.props.user"
        href="/dashboard"
        class="text-sm text-gray-700 underline"
      >
        Dashboard
      </inertia-link>

      <template v-else>
        <inertia-link
          :href="route('login')"
          class="text-sm text-gray-700 underline"
        >
          Login
        </inertia-link>

        <inertia-link
          v-if="canRegister"
          :href="route('register')"
          class="ml-4 text-sm text-gray-700 underline"
        >
          Register
        </inertia-link>
      </template>
    </div>

    <div class="h-full">
      <form @submit.prevent="submit">
        <div class="p-8 text-xl font-bold text-left md:text-8xl sm:text-3xl">
          <input
            type="text"
            v-model="form.qrcode"
            class="w-full pr-6"
            style="height: 150px; font-size: 64px; text-align: center"
          />

          <div class="flex flex-no-wrap justify-center p-12">
            <inertia-link href="#">
              <button
                class="
                  text-xl
                  sm:text-3xl
                  btn-green
                  md:btn-9xl md:text-8xl
                  pb-8
                "
                @click="submit"
              >
                Look for Procurement Record
              </button>
            </inertia-link>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import TextInput from "@/Shared/TextInput";

export default {
  components: {
    TextInput,
  },
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
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
