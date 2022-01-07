<template>
    <Head title="Log in" />

    <x-authentication-card>
        <template #logo>
            <x-authentication-card-logo />
        </template>

        <x-validation-errors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <x-label for="email" value="Correo Electrónico" />
                <x-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="password" value="Contraseña" />
                <x-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <x-checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Recordar Sesión</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    ¿Olvidaste tu contraseña?
                </Link>

                <x-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Iniciar Sesión
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</template>

<script>
    import { defineComponent } from 'vue'
    import XAuthenticationCard from '@/Components/AuthenticationCard.vue'
    import XAuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue'
    import XButton from '@/Components/Button.vue'
    import XInput from '@/Components/Input.vue'
    import XCheckbox from '@/Components/Checkbox.vue'
    import XLabel from '@/Components/Label.vue'
    import XValidationErrors from '@/Components/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,
            XAuthenticationCard,
            XAuthenticationCardLogo,
            XButton,
            XInput,
            XCheckbox,
            XLabel,
            XValidationErrors,
            Link,
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    })
</script>
