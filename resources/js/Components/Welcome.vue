<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <x-application-logo class="block h-12 w-auto" />
            </div>

            </div>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">

        </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import XApplicationLogo from '@/Components/ApplicationLogo.vue'

    export default defineComponent({
        components: {
            XApplicationLogo,
        },
    })
</script>
