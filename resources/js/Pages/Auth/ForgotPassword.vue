<template>
    <Head title="Forgot Password" />

    <x-authentication-card>
        <template #logo>
            <x-authentication-card-logo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            ¿Olvidaste tu contraseña? No hay problema. Simplemente háganos saber su dirección de correo electrónico y le enviaremos un enlace para restablecer la contraseña que le permitirá elegir una nueva.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <x-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <x-label for="email" value="Correo Electrónico" />
                <x-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Correo electrónico enlace de restablecimiento de contraseña
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</template>

<script>
    import { defineComponent } from 'vue'
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

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.email'))
            }
        }
    })
</script>
