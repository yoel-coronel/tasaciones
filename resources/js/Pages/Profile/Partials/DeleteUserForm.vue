<template>
    <x-action-section>
        <template #title>
            Borrar cuenta
        </template>

        <template #description>
            Elimina permanentemente tu cuenta.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán permanentemente. Antes de eliminar su cuenta, descargue cualquier dato o información que desee conservar.
            </div>

            <div class="mt-5">
                <x-danger-button @click="confirmUserDeletion">
                    Borrar cuenta
                </x-danger-button>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <x-dialog-modal :show="confirmingUserDeletion" @close="closeModal">
                <template #title>
                    Borrar cuenta
                </template>

                <template #content>
                    ¿Estás seguro de que deseas eliminar tu cuenta? Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán permanentemente. Ingrese su contraseña para confirmar que desea eliminar permanentemente su cuenta.

                    <div class="mt-4">
                        <x-input type="password" class="mt-1 block w-3/4" placeholder="Password"
                                    ref="password"
                                    v-model="form.password"
                                    @keyup.enter="deleteUser" />

                        <x-input-error :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <x-secondary-button @click="closeModal">
                        Cancelar
                    </x-secondary-button>

                    <x-danger-button class="ml-3" @click="deleteUser" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Borrar cuenta
                    </x-danger-button>
                </template>
            </x-dialog-modal>
        </template>
    </x-action-section>
</template>

<script>
    import { defineComponent } from 'vue'
    import XActionSection from '@/Components/ActionSection.vue'
    import XDialogModal from '@/Components/DialogModal.vue'
    import XDangerButton from '@/Components/DangerButton.vue'
    import XInput from '@/Components/Input.vue'
    import XInputError from '@/Components/InputError.vue'
    import XSecondaryButton from '@/Components/SecondaryButton.vue'

    export default defineComponent({
        components: {
            XActionSection,
            XDangerButton,
            XDialogModal,
            XInput,
            XInputError,
            XSecondaryButton,
        },

        data() {
            return {
                confirmingUserDeletion: false,

                form: this.$inertia.form({
                    password: '',
                })
            }
        },

        methods: {
            confirmUserDeletion() {
                this.confirmingUserDeletion = true;

                setTimeout(() => this.$refs.password.focus(), 250)
            },

            deleteUser() {
                this.form.delete(route('current-user.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => this.closeModal(),
                    onError: () => this.$refs.password.focus(),
                    onFinish: () => this.form.reset(),
                })
            },

            closeModal() {
                this.confirmingUserDeletion = false

                this.form.reset()
            },
        },
    })
</script>
