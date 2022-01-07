<template>
    <Head title="Register" />

    <x-authentication-card>
        <template #logo>
            <x-authentication-card-logo />
        </template>

        <x-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <x-label for="name" value="Nombres y Apellidos" />
                <x-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="Correo Electrónico" />
                <x-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>

            <div class="mt-4">
                <x-label for="password" value="Contraseña" />
                <x-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="Confirmar Contraseña" />
                <x-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <x-label for="terms">
                    <div class="flex items-center">
                        <x-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                        </div>
                    </div>
                </x-label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    ¿Ya registrado?
                </Link>

                <x-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrar
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

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    })
</script>
