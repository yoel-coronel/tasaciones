<template>
    <x-form-section @submitted="updateProfileInformation">
        <template #title>
            Información del perfil
        </template>

        <template #description>
            Actualice la información de perfil y la dirección de correo electrónico de su cuenta.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4" v-if="$page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <x-label for="photo" value="Foto" />

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="! photoPreview">
                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          :style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                    Seleccione una nueva foto
                </x-secondary-button>

                <x-secondary-button type="button" class="mt-2" @click.prevent="deletePhoto" v-if="user.profile_photo_path">
                    Quitar foto
                </x-secondary-button>

                <x-input-error :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="Nombres y Apellidos" />
                <x-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <x-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="email" value="Correo Electrónico" />
                <x-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <x-input-error :message="form.errors.email" class="mt-2" />
            </div>
            <!-- Empresa -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="email" value="Empresa" />
                <x-select id="store_id" type="select" :datos="empresas" :id="id" :name="nombre" class="mt-1 block w-full" v-model="form.store_id" />
                <x-input-error :message="form.errors.email" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <x-action-message :on="form.recentlySuccessful" class="mr-3">
                Guardado
            </x-action-message>

            <x-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Guardar
            </x-button>
        </template>
    </x-form-section>
</template>

<script>
    import { defineComponent } from 'vue'
    import XButton from '@/Components/Button.vue'
    import XFormSection from '@/Components/FormSection.vue'
    import XInput from '@/Components/Input.vue'
    import XSelect from '@/Components/Select.vue'
    import XInputError from '@/Components/InputError.vue'
    import XLabel from '@/Components/Label.vue'
    import XActionMessage from '@/Components/ActionMessage.vue'
    import XSecondaryButton from '@/Components/SecondaryButton.vue'

    export default defineComponent({
        components: {
            XActionMessage,
            XButton,
            XFormSection,
            XInput,
            XSelect,
            XInputError,
            XLabel,
            XSecondaryButton,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    name: this.user.name,
                    email: this.user.email,
                    store_id:this.user.store_id,
                    photo: null,
                }),
                empresas:[],
                photoPreview: null,
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true,
                    onSuccess: () => (this.clearPhotoFileInput()),
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const photo = this.$refs.photo.files[0];

                if (! photo) return;

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(photo);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.photoPreview = null;
                        this.clearPhotoFileInput();
                    },
                });
            },

            clearPhotoFileInput() {
                if (this.$refs.photo?.value) {
                    this.$refs.photo.value = null;
                }
            },
        },
        mounted() {
            axios.get('/recursos/empresas').then(data => {
               this.empresas = data.data;
            })
        }
    })
</script>
