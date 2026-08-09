<template>
    <LoadingView :loading="false">
        <heading class="mb-6">{{ __('Two factor auth (Google 2FA)') }}</heading>

        <Card>
            <div class="p-4">
                <p class="mb-3">{{ __(`By clearing these settings you can re-register Two FA on your device`) }}
                </p>
                <form class="max-w-[25rem]" @submit.prevent="auth()">
                    <div class="mb-6">
                        <label class="block mb-2" for="password">{{ __('Enter your password') }}</label>
                        <input v-model="form.password" class="form-control form-input form-control-bordered w-full"
                            id="password" type="password" name="password" ref="password" autofocus="" required />

                        <HelpText class="mt-2 text-red-700" v-if="form.errors.has('password')">
                            {{ form.errors.first('password') }}
                        </HelpText>
                    </div>

                    <button
                        class="shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm"
                        type="submit">
                        <span>
                            {{ __('Clear') }}
                        </span>
                    </button>

                </form>
            </div>

        </Card>
    </LoadingView>
</template>

<script>
export default {
    data() {
        return {
            form: Nova.form({
                password: null
            }),
        }
    },

    mounted() {
        this.$nextTick(() => this.$refs.password.focus())
    },

    methods: {
        async auth() {

            const { message } = await this.form.post('/nova-vendor/nova-two-factor/clear')

            Nova.success(message)

            Nova.visit('/nova-two-factor')
        },
    }
}
</script>
