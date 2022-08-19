<template>
  <LoadingView :loading="loading">
  <heading class="mb-6">Two factor auth (Google 2FA)</heading>
    <LoadingCard :loading="loading" class="tw-p-4">

      <div class="tw-grid tw-grid-cols-2 tw-gap-4">
        <div class="">

          <div class="" v-if="status.confirmed == 1">
            <p class="mb-4">
              Update your two factor security settings
            </p>

            <div class="tw-flex tw-items-center tw-mb-4">
              <input v-model="status.enabled" :value="1" id="op-enable" type="radio"  class="tw-w-4 tw-h-4 tw-border-gray-300 tw-focus:ring-2 tw-focus:ring-blue-300">
              <label for="op-enable" class="tw-block tw-ml-2 tw-text-sm tw-font-medium tw-text-gray-900">
                Enable
              </label>
            </div>

            <div class="tw-flex tw-items-center tw-mb-4">
              <input v-model="status.enabled" :value="0" id="op-disable" type="radio" class="tw-w-4 tw-h-4 tw-border-gray-300 tw-focus:ring-2 tw-focus:ring-blue-300">
              <label for="op-disable" class="tw-block tw-ml-2 tw-text-sm tw-font-medium tw-text-gray-900">
                Disable
              </label>
            </div>


            <br>

            <LoadingButton @click="toggle" >Update Settings</LoadingButton>

          </div>

          <div v-else class="">
            <p>
              Two factor authentication (2FA) strengthens access security by requiring two methods (also
              referred
              to as factors) to verify your identity. Two factor authentication protects against phishing, social
              engineering and password brute force attacks and secures your logins from attackers exploiting weak
              or stolen credentials.
            </p>

            <h3 class="tw-my-2 tw-text-xl">Recovery codes</h3>

            <p class="tw-mb-3">
              Recovery code are used to access your account in the event you cannot recive two-factor
              authentication codes.
            </p>
            <span class="tw-bg-gray-100 tw-text-gray-800 tw-text-xs tw-font-semibold tw-mr-2 tw-px-2.5 tw-py-0.5 tw-rounded ">Step 01</span>
            <p class="no-print tw-my-4 tw-text-md">
                Download, print or copy your recovery code before continuing two-factor authentication setup.
            </p>

            <div class="tw-mb-4 tw-border-dashed tw-border-2 tw-border-light-blue tw-p-4 tw-rounded-lg tw-text-center tw-bg-gray-50">
              <h2 class="tw-text-xl tw-text-black">{{ twofa.recovery }}</h2>
              <a class="tw-text-blue-700" @click.prevent="downloadAsText('recover_code.txt', twofa.recovery)" href="#">Download</a>
            </div>


            <span class="tw-bg-gray-100 tw-text-gray-800 tw-text-xs tw-font-semibold tw-mr-2 tw-px-2.5 tw-py-0.5 tw-rounded ">Step 02</span>

            <div class="tw-my-4 tw-text-md">
                Scan this QR code using Google authenticator to setup & enter OTP to activate 2FA

              <input v-model="form.otp" @keyup="autoSubmit()" placeholder="Enter OTP here" type="text"
                     class="form-control form-input form-input-bordered tw-my-4">
              <br>
              <LoadingButton :loading="loading" :disabled="loading" @click="confirmOtp" class="btn btn-default btn-primary">Activate 2FA</LoadingButton>
            </div>

          </div>

        </div>
        <div class="tw-h-full">
          <div v-if="!status.confirmed" class="tw-flex tw-justify-center tw-content-center tw-w-full tw-p-8">
            <img width="300" :src="twofa.google2fa_url" alt="qr_code">
          </div>
        </div>
      </div>


    </LoadingCard>
  </LoadingView>
</template>

<script>
export default {
  data() {
    return {
      twofa: [],
      form: {},
      status: null,
      loading: true
    }
  },

  mounted() {
    this.getStatus()
    this.getRecoveryCodes()
  },

  methods: {
    getStatus() {
      Nova.request().get('/nova-vendor/nova-two-factor/status')
          .then(res => {
            this.status = res.data
            this.loading = false
          })
    },

    getRecoveryCodes() {
      Nova.request().get('/nova-vendor/nova-two-factor/register')
          .then(res => {
            this.twofa = res.data
          })
    },

    toggle() {
      Nova.request().post('/nova-vendor/nova-two-factor/toggle', {
        status: this.status.enabled
      })
          .then(res => {
            Nova.success(res.data.message)
          })
    },

    confirmOtp() {
      Nova.request().post('/nova-vendor/nova-two-factor/confirm', this.form)
          .then(res => {

           Nova.success(res.data.message)
            this.getStatus()
          })
          .catch(err => {
            Nova.error(err.response.data.message)
          })
    },

    autoSubmit() {
      if (this.form.otp.length === 6) {
        this.confirmOtp()
      }
    },

    downloadAsText(filename, text) {
      var element = document.createElement('a');
      element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
      element.setAttribute('download', filename);

      element.style.display = 'none';
      document.body.appendChild(element);

      element.click();

      document.body.removeChild(element);
    }
  },

  computed: {
    //
  }
}
</script>
