<template>
    <div>
        <!-- Generate API Token -->
        <x-form-section @submitted="createApiToken">
            <template #title>
                Crear token de API
            </template>

            <template #description>
                Los tokens de API permiten que los servicios de terceros se autentiquen con nuestra aplicación en su nombre.
            </template>

            <template #form>
                <!-- Token Name -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="name" value="Name" />
                    <x-input id="name" type="text" class="mt-1 block w-full" v-model="createApiTokenForm.name" autofocus />
                    <x-input-error :message="createApiTokenForm.errors.name" class="mt-2" />
                </div>

                <!-- Token Permissions -->
                <div class="col-span-6" v-if="availablePermissions.length > 0">
                    <x-label for="permissions" value="Permissions" />

                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="permission in availablePermissions" :key="permission">
                            <label class="flex items-center">
                                <x-checkbox :value="permission" v-model:checked="createApiTokenForm.permissions"/>
                                <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </template>

            <template #actions>
                <x-action-message :on="createApiTokenForm.recentlySuccessful" class="mr-3">
                    Created.
                </x-action-message>

                <x-button :class="{ 'opacity-25': createApiTokenForm.processing }" :disabled="createApiTokenForm.processing">
                    Create
                </x-button>
            </template>
        </x-form-section>

        <div v-if="tokens.length > 0">
            <x-section-border />

            <!-- Manage API Tokens -->
            <div class="mt-10 sm:mt-0">
                <x-action-section>
                    <template #title>
                        Administrar tokens de API
                    </template>

                    <template #description>
                        Puede eliminar cualquiera de sus tokens existentes si ya no los necesita.
                    </template>

                    <!-- API Token List -->
                    <template #content>
                        <div class="space-y-6">
                            <div class="flex items-center justify-between" v-for="token in tokens" :key="token.id">
                                <div>
                                    {{ token.name }}
                                </div>

                                <div class="flex items-center">
                                    <div class="text-sm text-gray-400" v-if="token.last_used_ago">
                                        Usado por última vez {{ token.last_used_ago }}
                                    </div>

                                    <button class="cursor-pointer ml-6 text-sm text-gray-400 underline"
                                        @click="manageApiTokenPermissions(token)"
                                        v-if="availablePermissions.length > 0"
                                    >
                                        Permisos
                                    </button>

                                    <button class="cursor-pointer ml-6 text-sm text-red-500" @click="confirmApiTokenDeletion(token)">
                                        Borrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </x-action-section>
            </div>
        </div>

        <!-- Token Value Modal -->
        <x-dialog-modal :show="displayingToken" @close="displayingToken = false">
            <template #title>
                API Token
            </template>

            <template #content>
                <div>
                    Copie su nuevo token de API. Por su seguridad, no se volverá a mostrar.
                </div>

                <div class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500" v-if="$page.props.jetstream.flash.token">
                    {{ $page.props.jetstream.flash.token }}
                </div>
            </template>

            <template #footer>
                <x-secondary-button @click="displayingToken = false">
                    Cerrar
                </x-secondary-button>
            </template>
        </x-dialog-modal>

        <!-- API Token Permissions Modal -->
        <x-dialog-modal :show="managingPermissionsFor" @close="managingPermissionsFor = null">
            <template #title>
                Permisos de token de API
            </template>

            <template #content>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div v-for="permission in availablePermissions" :key="permission">
                        <label class="flex items-center">
                            <x-checkbox :value="permission" v-model:checked="updateApiTokenForm.permissions"/>
                            <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
                        </label>
                    </div>
                </div>
            </template>

            <template #footer>
                <x-secondary-button @click="managingPermissionsFor = null">
                    Cancelar
                </x-secondary-button>

                <x-button class="ml-3" @click="updateApiToken" :class="{ 'opacity-25': updateApiTokenForm.processing }" :disabled="updateApiTokenForm.processing">
                    Guardar
                </x-button>
            </template>
        </x-dialog-modal>

        <!-- Delete Token Confirmation Modal -->
        <x-confirmation-modal :show="apiTokenBeingDeleted" @close="apiTokenBeingDeleted = null">
            <template #title>
                eliminar API Token
            </template>

            <template #content>
                ¿Está seguro de que desea eliminar este token de API?
            </template>

            <template #footer>
                <x-secondary-button @click="apiTokenBeingDeleted = null">
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="ml-3" @click="deleteApiToken" :class="{ 'opacity-25': deleteApiTokenForm.processing }" :disabled="deleteApiTokenForm.processing">
                    Eliminar
                </x-danger-button>
            </template>
        </x-confirmation-modal>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import XActionMessage from '@/Jetstream/ActionMessage.vue'
    import XActionSection from '@/Jetstream/ActionSection.vue'
    import XButton from '@/Jetstream/Button.vue'
    import XConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
    import XDangerButton from '@/Jetstream/DangerButton.vue'
    import XDialogModal from '@/Jetstream/DialogModal.vue'
    import XFormSection from '@/Jetstream/FormSection.vue'
    import XInput from '@/Jetstream/Input.vue'
    import XCheckbox from '@/Jetstream/Checkbox.vue'
    import XInputError from '@/Jetstream/InputError.vue'
    import XLabel from '@/Jetstream/Label.vue'
    import XSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import XSectionBorder from '@/Jetstream/SectionBorder.vue'

    export default defineComponent({
        components: {
            XActionMessage,
            XActionSection,
            XButton,
            XConfirmationModal,
            XDangerButton,
            XDialogModal,
            XFormSection,
            XInput,
            XCheckbox,
            XInputError,
            XLabel,
            XSecondaryButton,
            XSectionBorder,
        },

        props: [
            'tokens',
            'availablePermissions',
            'defaultPermissions',
        ],

        data() {
            return {
                createApiTokenForm: this.$inertia.form({
                    name: '',
                    permissions: this.defaultPermissions,
                }),

                updateApiTokenForm: this.$inertia.form({
                    permissions: []
                }),

                deleteApiTokenForm: this.$inertia.form(),

                displayingToken: false,
                managingPermissionsFor: null,
                apiTokenBeingDeleted: null,
            }
        },

        methods: {
            createApiToken() {
                this.createApiTokenForm.post(route('api-tokens.store'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.displayingToken = true
                        this.createApiTokenForm.reset()
                    }
                })
            },

            manageApiTokenPermissions(token) {
                this.updateApiTokenForm.permissions = token.abilities

                this.managingPermissionsFor = token
            },

            updateApiToken() {
                this.updateApiTokenForm.put(route('api-tokens.update', this.managingPermissionsFor), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => (this.managingPermissionsFor = null),
                })
            },

            confirmApiTokenDeletion(token) {
                this.apiTokenBeingDeleted = token
            },

            deleteApiToken() {
                this.deleteApiTokenForm.delete(route('api-tokens.destroy', this.apiTokenBeingDeleted), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => (this.apiTokenBeingDeleted = null),
                })
            },
        },
    })
</script>
