<template>
    <div>
        <form @submit.prevent="auth()" class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 max-w-[25rem] mx-auto">
            <h2 class="text-2xl text-center font-normal mb-6 text-90">
                {{ __('Two factor authentication') }}
            </h2>

            <DividerLine />

            <div class="mb-6">
                <label class="block mb-2" for="otp">{{ __('One time password') }}</label>
                <input v-model="otp" @keyup="autoSubmit()" class="form-control form-input form-input-bordered w-full"
                    maxLength="6" id="otp" type="text" name="otp" ref="otp" autofocus="" required />

                <HelpText class="mt-2 text-red-500" v-if="error">
                    {{ error }}
                </HelpText>
            </div>

            <DefaultButton class="w-full flex justify-center" type="submit">
                <span>
                    {{ __('Authenticate') }}
                </span>
            </DefaultButton>

        </form>
    </div>
</template>

<script>
export default {
    props: ['referer'],
    data() {
        return {
            otp: '',
            error: null
        }
    },

    mounted() {
        this.$nextTick(() => this.$refs.otp.focus())
    },

    methods: {
        auth() {
            let self = this
            Nova.request().post('/nova-vendor/nova-two-factor/validatePrompt', {
                one_time_password: this.otp
            })
                .then(res => {
                    window.location.href = self.referer
                })
                .catch(e => {
                    this.error = e.response.data.message
                })
        },

        autoSubmit() {
            if (this.otp.length === 6) {
                this.auth()
            }
        }
    }
}
</script>
