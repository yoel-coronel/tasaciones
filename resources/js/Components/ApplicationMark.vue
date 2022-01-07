<template>
    <Link :href="'/'">
        <img :src="'/img/logo.png'" class="w-12 h-12">
    </Link>
</template>
<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        Link,
    },
})
</script>
