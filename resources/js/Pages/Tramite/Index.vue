<template>
    <app-layout title="Trámites">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trámites
            </h2>
        </template>
        <div class="py-6">
            <div class="mx-auto sm:px-6 lg:px-8">

                <div class="shadow bg-white  overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nombre
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Propetario
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Última modificación
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tamaño del Archivo
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(person,idx) in people" :key="idx" class="cursor-pointer shadow-sm border hover:bg-gray-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">

                                                <div class="flex-shrink-0 h-10 w-10" v-html="viewIcon(person.type)">

                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ person.name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ person.email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ person.title }}</div>
                                            <div class="text-sm text-gray-500">{{ person.department }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                              </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ person.role }}
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <welcome />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Components/Welcome.vue'
const icons = [
    {
        name:`Carpeta`,
        format:'path',
        image: '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>',
    },
    {
        name:`Documento`,
        format:'txt',
        image: '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
    },
    {
        name:`PDF`,
        format:'pdf',
        image: '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>',
    }
]
const people = [
    {
        name: 'Expediente 201225',
        title: 'yo',
        department: 'Lima',
        role: '-',
        email: 'Portafolio',
        type:'path',
        image:
            '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>',
    },
    {
        name: 'Expediente 201226',
        title: 'yo',
        department: 'Lima',
        role: '-',
        email: 'Portafolio',
        type:'pdf',
        image:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
    },
    {
        name: 'Expediente 201227',
        title: 'yo',
        department: 'Lima',
        role: '-',
        email: 'Portafolio',
        type:'txt',
        image:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
    },
    // More people...
]
export default defineComponent({
    props:{
        datos:Object,
    },
    components: {
        AppLayout,
        Welcome,
    },
    setup() {
        return {
            people,
            icons,
        }
    },
    methods:{
        viewIcon(value){
            let result = [];
            if (value){
                result = this.icons.filter(item =>item.format.toLowerCase().includes(value.toLowerCase()) || item.name.toLowerCase().includes(value.toLowerCase()))
            }
            if (result.length>0){
                return result[0]['image'];
            }
            return '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>';
        }
    }
})
</script>
