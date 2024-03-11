<template>
  <LoadingView :loading="loading">
    <heading class="mb-6">{{ __("Two factor auth (Google 2FA)") }}</heading>
    <LoadingCard :loading="loading">
      <div class="tw-grid tw-grid-cols-2 tw-gap-4 p-4">
        <div class="">
          <p>
            {{
              __(
                `Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.`
              )
            }}
          </p>

          <h3 class="tw-my-2 tw-text-xl">{{ __("Recovery codes") }}</h3>

          <p class="tw-mb-3">
            {{
              __(
                `Recovery code are used to access your account in the event you cannot receive two-factor authentication codes.`
              )
            }}
          </p>
          <span
            class="tw-bg-gray-100 tw-text-gray-800 tw-text-xs tw-font-semibold tw-mr-2 tw-px-2.5 tw-py-0.5 tw-rounded"
            >{{ __("Step 01") }}</span
          >
          <p class="no-print tw-my-4 tw-text-md">
            {{
              __(
                `Download, print or copy your recovery code before continuing two-factor authentication setup.`
              )
            }}
          </p>

          <div
            class="tw-mb-4 tw-border-dashed tw-border-2 tw-border-light-blue dark:border-gray-500 tw-p-4 tw-rounded-lg tw-text-center tw-bg-gray-50 dark:bg-gray-700"
          >
            <h2 class="tw-text-xl tw-text-black">{{ recovery }}</h2>
            <a
              class="tw-text-blue-700"
              @click.prevent="downloadAsText('recover_code.txt', recovery)"
              href="#"
              >{{ __("Download") }}</a
            >
          </div>

          <span
            class="tw-bg-gray-100 tw-text-gray-800 tw-text-xs tw-font-semibold tw-mr-2 tw-px-2.5 tw-py-0.5 tw-rounded"
            >{{ __("Step 02") }}</span
          >

          <div class="tw-my-4 tw-text-md">
            {{
              __(
                "Scan this QR code using Google authenticator to setup & enter OTP to activate 2FA"
              )
            }}
            <br />
            <input
              v-model="form.otp"
              @keyup="autoSubmit()"
              :placeholder="__('Enter OTP here')"
              type="text"
              class="form-control form-input form-input-bordered tw-my-4"
            />
            <br />
            <DefaultButton
              :disabled="loading"
              @click="confirmOtp"
              class="btn btn-default btn-primary"
              >{{ __("Activate 2FA") }}</DefaultButton
            >
          </div>
        </div>
        <div class="tw-flex tw-justify-center tw-items-center">
          <div>
            <img
              v-if="!svg"
              width="250"
              height="250"
              :src="qr_url"
              alt="qr_code"
              class="tw-shadow-md tw-p-5 tw-rounded-lg"
            />
            <div v-else v-html="qr_url"></div>
          </div>
        </div>
      </div>
    </LoadingCard>
  </LoadingView>
</template>

<script>
export default {
  props: ["status", "qr_url", "recovery", "svg"],
  data() {
    return {
      form: {},
      loading: false,
    };
  },
  methods: {
    confirmOtp() {
      Nova.request()
        .post("/nova-vendor/nova-two-factor/confirm", this.form)
        .then((res) => {
          Nova.success(res.data.message);
          Nova.visit(res.data.url);
        })
        .catch((err) => {
          Nova.error(err.response.data.message);
        });
    },

    autoSubmit() {
      if (this.form.otp.length === 6) {
        this.confirmOtp();
      }
    },

    downloadAsText(filename, text) {
      var element = document.createElement("a");
      element.setAttribute(
        "href",
        "data:text/plain;charset=utf-8," + encodeURIComponent(text)
      );
      element.setAttribute("download", filename);

      element.style.display = "none";
      document.body.appendChild(element);

      element.click();

      document.body.removeChild(element);
    },
  },

  computed: {
    //
  },
};
</script>
