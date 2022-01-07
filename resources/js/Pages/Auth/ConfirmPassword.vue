<template>
    <Head title="Secure Area" />

    <x-authentication-card>
        <template #logo>
            <x-authentication-card-logo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Esta es un área segura de la aplicación. Confirme su contraseña antes de continuar.
        </div>

        <x-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <x-label for="password" value="Correo Electrónico" />
                <x-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <x-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirmar
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
            XValidationErrors
        },

        data() {
            return {
                form: this.$inertia.form({
                    password: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.confirm'), {
                    onFinish: () => this.form.reset(),
                })
            }
        }
    })
</script>
