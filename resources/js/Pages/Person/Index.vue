<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { router, useForm } from '@inertiajs/vue3'
import ModalPerson from '../../Components/ModalPerson.vue'
import { ref } from 'vue'
import Swal from 'sweetalert2'

defineProps({
    people: { type: Object }
})

const modal = ref(false)
let op = ref(-1)

const form = useForm({})

const openModal = opValue => {
    op = opValue
    modal.value = true
}

const closeModal = () => {
    op = -1
    modal.value = false
}

const confirmed = () => {
    router.reload()
}

const editar = () => {}

const eliminar = (id, name) => {
    const swal = Swal.mixin({
        buttonsStyling: true
    })

    swal.fire({
        title: 'Seguro que desea eliminar la persona ' + name,
        text: 'Se perdera la persona',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"> </i> Si, eliminar',
        cancelButtonText: '<i class="fa-solid fa-ban"> </i> Cancelar'
    }).then(result => {
        if (result.isConfirmed) {
            form.delete(route('people.destroy', id))
        }
    })
}
</script>

<template>
    <AppLayout title="Personas">
        <template #header>
            <div class="container mx-auto bg-white w-full flex">
                <h1><i class="fa fa-users"></i> Personas</h1>
                <button
                    @click="openModal(0)"
                    class="ml-2 h-8 px-3 rounded bg-green-500 text-white"
                >
                    <i class="fa-solid fa-circle-plus"></i> Añadir
                </button>
            </div>
        </template>

        <div class="px-12 py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4">
                        <table class="w-full table-auto border-collapse border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300">Apellido</th>
                                    <th class="border border-gray-300">Nombre</th>
                                    <th class="border border-gray-300">Fecha nacimiento</th>
                                    <th class="border border-gray-300">Celular</th>
                                    <th class="border border-gray-300">Estado Civil</th>
                                    <th class="border border-gray-300">JUbicación</th>
                                    <th class="border border-gray-300">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(person, i) in people"
                                    :key="person.id"
                                >
                                    <td class="border border-gray-300 p-1">{{ person.last_name }}</td>
                                    <td class="border border-gray-300 p-1">{{ person.first_name }}</td>
                                    <td class="border border-gray-300 p-1 text-center">{{ person.birthdate }}</td>
                                    <td class="border border-gray-300 p-1 text-center">{{ person.phone }}</td>
                                    <td class="border border-gray-300 p-1 text-center">{{ person.civil_status }}</td>
                                    <td class="border border-gray-300 p-1 text-center">
                                        {{
                                            `${person.latitude}, ${person.longitude}`
                                        }}
                                    </td>
                                    <td class="border border-gray-300 p-1 text-center">
                                        <button
                                            @click="openModal(person.id)"
                                            class="bg-yellow-500 py-1 px-2 text-white rounded"
                                        >
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button
                                            @click="
                                                eliminar(
                                                    person.id,
                                                    person.first_name
                                                )
                                            "
                                            class="ml-1 bg-red-500 py-1 px-2 text-white rounded"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
    <ModalPerson
        :isOpen="modal"
        :op="op"
        @close="closeModal"
        @confirmed="confirmed"
    ></ModalPerson>
</template>
