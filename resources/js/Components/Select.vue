<template>
    <select id="countries"
            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="select" >
        <option value="">--SELECCIONE--</option>
        <option v-for="item in datos" :key="item.id" :value="item.id" v-text="item.nombre"></option>
    </select>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            modelValue:Object,
            datos:Array,
        },

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.select.focus()
            }
        }
    })
</script>
