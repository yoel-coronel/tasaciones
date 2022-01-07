<template>
    <Head title="Email Verification" />

    <x-authentication-card>
        <template #logo>
            <x-authentication-card-logo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Gracias por registrarte! Antes de comenzar, ¿podría verificar su dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar? Si no recibió el correo electrónico, con gusto le enviaremos otro.
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent" >
            Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionó durante el registro.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <x-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reenviar correo electrónico de verificación
                </x-button>

                <Link :href="route('logout')" method="post" as="button" class="underline text-sm text-gray-600 hover:text-gray-900">Cerrar sesión</Link>
            </div>
        </form>
    </x-authentication-card>
</template>

<script>
    import { defineComponent } from 'vue'
    import XAuthenticationCard from '@/Components/AuthenticationCard.vue'
    import XAuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue'
    import XButton from '@/Components/Button.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,
            XAuthenticationCard,
            XAuthenticationCardLogo,
            XButton,
            Link,
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form()
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('verification.send'))
            },
        },

        computed: {
            verificationLinkSent() {
                return this.status === 'verification-link-sent';
            }
        }
    })
</script>
