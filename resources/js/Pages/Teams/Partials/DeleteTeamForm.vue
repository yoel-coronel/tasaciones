<template>
    <x-action-section>
        <template #title>
            Eliminar equipo
        </template>

        <template #description>
            Elimina definitivamente este equipo.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Una vez que se elimina un equipo, todos sus recursos y datos se eliminarán de forma permanente. Antes de eliminar este equipo, descargue cualquier dato o información sobre este equipo que desee conservar.
            </div>

            <div class="mt-5">
                <x-danger-button @click="confirmTeamDeletion">
                    Eliminar equipo
                </x-danger-button>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <x-confirmation-modal :show="confirmingTeamDeletion" @close="confirmingTeamDeletion = false">
                <template #title>
                    Eliminar equipo
                </template>

                <template #content>
                    ¿Estás seguro de que deseas eliminar este equipo? Una vez que se elimina un equipo, todos sus recursos y datos se eliminarán de forma permanente.
                </template>

                <template #footer>
                    <x-secondary-button @click="confirmingTeamDeletion = false">
                        Cancelar
                    </x-secondary-button>

                    <x-danger-button class="ml-3" @click="deleteTeam" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Eliminar equipo
                    </x-danger-button>
                </template>
            </x-confirmation-modal>
        </template>
    </x-action-section>
</template>

<script>
    import { defineComponent } from 'vue'
    import XActionSection from '@/Components/ActionSection.vue'
    import XConfirmationModal from '@/Components/ConfirmationModal.vue'
    import XDangerButton from '@/Components/DangerButton.vue'
    import XSecondaryButton from '@/Components/SecondaryButton.vue'

    export default defineComponent({
        props: ['team'],

        components: {
            XActionSection,
            XConfirmationModal,
            XDangerButton,
            XSecondaryButton,
        },

        data() {
            return {
                confirmingTeamDeletion: false,
                deleting: false,

                form: this.$inertia.form()
            }
        },

        methods: {
            confirmTeamDeletion() {
                this.confirmingTeamDeletion = true
            },

            deleteTeam() {
                this.form.delete(route('teams.destroy', this.team), {
                    errorBag: 'deleteTeam'
                });
            },
        },
    })
</script>
