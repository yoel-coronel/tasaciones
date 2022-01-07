<template>
    <Head title="Two-factor Confirmation" />

    <x-authentication-card>
        <template #logo>
            <x-authentication-card-logo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            <template v-if="! recovery">
                Confirme el acceso a su cuenta ingresando el código de autenticación proporcionado por su aplicación de autenticación.
            </template>

            <template v-else>
                Confirme el acceso a su cuenta ingresando uno de sus códigos de recuperación de emergencia.
            </template>
        </div>

        <x-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div v-if="! recovery">
                <x-label for="code" value="Code" />
                <x-input ref="code" id="code" type="text" inputmode="numeric" class="mt-1 block w-full" v-model="form.code" autofocus autocomplete="one-time-code" />
            </div>

            <div v-else>
                <x-label for="recovery_code" value="Recovery Code" />
                <x-input ref="recovery_code" id="recovery_code" type="text" class="mt-1 block w-full" v-model="form.recovery_code" autocomplete="one-time-code" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer" @click.prevent="toggleRecovery">
                    <template v-if="! recovery">
                        Utilice un código de recuperación
                    </template>

                    <template v-else>
                        Utilice un código de autenticación
                    </template>
                </button>

                <x-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Iniciar sesión
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</template>

<script>
    import { defineComponent } from 'vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import XAuthenticationCard from '@/Components/AuthenticationCard.vue'
    import XAuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue'
    import XButton from '@/Components/Button.vue'
    import XInput from '@/Components/Input.vue'
    import XLabel from '@/Components/Label.vue'
    import XValidationErrors from '@/Components/ValidationErrors.vue'

    export default defineComponent({
        components: {
            Head,
            XAuthenticationCard,
            XAuthenticationCardLogo,
            XButton,
            XInput,
            XLabel,
            XValidationErrors,
        },

        data() {
            return {
                recovery: false,
                form: this.$inertia.form({
                    code: '',
                    recovery_code: '',
                })
            }
        },

        methods: {
            toggleRecovery() {
                this.recovery ^= true

                this.$nextTick(() => {
                    if (this.recovery) {
                        this.$refs.recovery_code.focus()
                        this.form.code = '';
                    } else {
                        this.$refs.code.focus()
                        this.form.recovery_code = ''
                    }
                })
            },

            submit() {
                this.form.post(this.route('two-factor.login'))
            }
        }
    })
</script>
