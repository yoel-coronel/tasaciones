<template>
    <x-form-section @submitted="updateTeamName">
        <template #title>
            Nombre del equipo
        </template>

        <template #description>
            El nombre del equipo y la información del propietario.
        </template>

        <template #form>
            <!-- Team Owner Information -->
            <div class="col-span-6">
                <x-label value="Team Owner" />

                <div class="flex items-center mt-2">
                    <img class="w-12 h-12 rounded-full object-cover" :src="team.owner.profile_photo_url" :alt="team.owner.name">

                    <div class="ml-4 leading-tight">
                        <div>{{ team.owner.name }}</div>
                        <div class="text-gray-700 text-sm">{{ team.owner.email }}</div>
                    </div>
                </div>
            </div>

            <!-- Team Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="Team Name" />

                <x-input id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            :disabled="! permissions.canUpdateTeam" />

                <x-input-error :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions v-if="permissions.canUpdateTeam">
            <x-action-message :on="form.recentlySuccessful" class="mr-3">
                Salvado.
            </x-action-message>

            <x-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Guardar
            </x-button>
        </template>
    </x-form-section>
</template>

<script>
    import { defineComponent } from 'vue'
    import XActionMessage from '@/Components/ActionMessage'
    import XButton from '@/Components/Button'
    import XFormSection from '@/Components/FormSection'
    import XInput from '@/Components/Input'
    import XInputError from '@/Components/InputError'
    import XLabel from '@/Components/Label'

    export default defineComponent({
        components: {
            XActionMessage,
            XButton,
            XFormSection,
            XInput,
            XInputError,
            XLabel,
        },

        props: ['team', 'permissions'],

        data() {
            return {
                form: this.$inertia.form({
                    name: this.team.name,
                })
            }
        },

        methods: {
            updateTeamName() {
                this.form.put(route('teams.update', this.team), {
                    errorBag: 'updateTeamName',
                    preserveScroll: true
                });
            },
        },
    })
</script>
