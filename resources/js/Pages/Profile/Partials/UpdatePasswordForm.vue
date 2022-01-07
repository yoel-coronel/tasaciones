<template>
    <x-form-section @submitted="updatePassword">
        <template #title>
            Actualiza contraseña
        </template>

        <template #description>
            Asegúrese de que su cuenta esté usando una contraseña larga y aleatoria para mantenerse seguro.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="current_password" value="Contraseña actual" />
                <x-input id="current_password" type="password" class="mt-1 block w-full" v-model="form.current_password" ref="current_password" autocomplete="current-password" />
                <x-input-error :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="password" value="Nueva contraseña" />
                <x-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" ref="password" autocomplete="new-password" />
                <x-input-error :message="form.errors.password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="password_confirmation" value="Confirmar contraseña" />
                <x-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                <x-input-error :message="form.errors.password_confirmation" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <x-action-message :on="form.recentlySuccessful" class="mr-3">
                Guardado.
            </x-action-message>

            <x-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Guardar
            </x-button>
        </template>
    </x-form-section>
</template>

<script>
    import { defineComponent } from 'vue'
    import XActionMessage from '@/Components/ActionMessage.vue'
    import XButton from '@/Components/Button.vue'
    import XFormSection from '@/Components/FormSection.vue'
    import XInput from '@/Components/Input.vue'
    import XInputError from '@/Components/InputError.vue'
    import XLabel from '@/Components/Label.vue'

    export default defineComponent({
        components: {
            XActionMessage,
            XButton,
            XFormSection,
            XInput,
            XInputError,
            XLabel,
        },

        data() {
            return {
                form: this.$inertia.form({
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                }),
            }
        },

        methods: {
            updatePassword() {
                this.form.put(route('user-password.update'), {
                    errorBag: 'updatePassword',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                    onError: () => {
                        if (this.form.errors.password) {
                            this.form.reset('password', 'password_confirmation')
                            this.$refs.password.focus()
                        }

                        if (this.form.errors.current_password) {
                            this.form.reset('current_password')
                            this.$refs.current_password.focus()
                        }
                    }
                })
            },
        },
    })
</script>
