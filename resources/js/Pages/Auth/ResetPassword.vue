<template>
    <Head title="Reset Password" />

    <x-authentication-card>
        <template #logo>
            <x-authentication-card-logo />
        </template>

        <x-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <x-label for="email" value="Correo Eletrónico" />
                <x-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="password" value="Contraseña" />
                <x-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="Confirmar contraseña" />
                <x-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Restablecer la contraseña
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

        props: {
            email: String,
            token: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    token: this.token,
                    email: this.email,
                    password: '',
                    password_confirmation: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.update'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    })
</script>
