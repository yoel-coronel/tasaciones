<template>
    <x-form-section @submitted="createTeam">
        <template #title>
            Detalles del equipo
        </template>

        <template #description>
            Crea un nuevo equipo para colaborar con otros en proyectos.
        </template>

        <template #form>
            <div class="col-span-6">
                <x-label value="Team Owner" />

                <div class="flex items-center mt-2">
                    <img class="object-cover w-12 h-12 rounded-full" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">

                    <div class="ml-4 leading-tight">
                        <div>{{ $page.props.user.name }}</div>
                        <div class="text-sm text-gray-700">{{ $page.props.user.email }}</div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="Nombre del equipo" />
                <x-input id="name" type="text" class="block w-full mt-1" v-model="form.name" autofocus />
                <x-input-error :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <x-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Crear
            </x-button>
        </template>
    </x-form-section>
</template>

<script>
    import { defineComponent } from 'vue'
    import XButton from '@/Components/Button.vue'
    import XFormSection from '@/Components/FormSection.vue'
    import XInput from '@/Components/Input.vue'
    import XInputError from '@/Components/InputError.vue'
    import XLabel from '@/Components/Label.vue'

    export default defineComponent({
        components: {
            XButton,
            XFormSection,
            XInput,
            XInputError,
            XLabel,
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                })
            }
        },

        methods: {
            createTeam() {
                this.form.post(route('teams.store'), {
                    errorBag: 'createTeam',
                    preserveScroll: true
                });
            },
        },
    })
</script>
