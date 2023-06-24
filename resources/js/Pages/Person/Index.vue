<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { router, useForm } from '@inertiajs/vue3'
import ModalPerson from '../../Components/ModalPerson.vue'
import { reactive, ref } from 'vue'
import Swal from 'sweetalert2'

defineProps({
    people: { type: Array, default: () => [] }
})

const processing = ref(false)
const modal = ref(false)

const initialStatePerson = {
    identification: '',
    first_name: '',
    last_name: '',
    birthdate: '',
    phone: '',
    civil_status: '',
    latitude: '',
    longitude: ''
}

const person = reactive({ ...initialStatePerson })
const errorPerson = reactive({ ...initialStatePerson })

const resetForm = () => {
    Object.assign(person, initialStatePerson)
}
const resetFormError = () => {
    Object.assign(errorPerson, initialStatePerson)
}

const save = () => {
    processing.value = true

    if (person.id === undefined) {
        axios
            .post(route('people.store'), person)
            .then(() => {
                processing.value = false

                toggle()
                resetForm()
                console.log(person)
                router.reload({ only: ['people'] })
            })
            .catch(error => {
                processing.value = false

                Object.keys(error.response.data.errors).forEach(key => {
                    errorPerson[key] = error.response.data.errors[key][0]
                })
            })
    } else {
        form.put(route('people.update', person.id), person)
            .then(() => {
                processing.value = false

                toggle()
                resetForm()
                router.reload({ only: ['people'] })
            })
            .catch(error => {
                processing.value = false

                Object.keys(error.response.data.errors).forEach(key => {
                    errorPerson[key] = error.response.data.errors[key][0]
                })
            })
    }
}

const form = useForm({})

const toggle = () => {
    modal.value = !modal.value
}

const openModal = () => {
    resetForm()
    resetFormError()
    modal.value = !modal.value
}

const editar = per => {
    Object.keys(per).forEach(key => {
        person[key] = per[key]
    })
    modal.value = true
}

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
                    @click="openModal"
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
                        <table
                            class="w-full table-auto border-collapse border border-gray-300"
                        >
                            <thead>
                                <tr>
                                    <th class="border border-gray-300">
                                        Apellido
                                    </th>
                                    <th class="border border-gray-300">
                                        Nombre
                                    </th>
                                    <th class="border border-gray-300">
                                        Fecha nacimiento
                                    </th>
                                    <th class="border border-gray-300">
                                        Celular
                                    </th>
                                    <th class="border border-gray-300">
                                        Estado Civil
                                    </th>
                                    <th class="border border-gray-300">
                                        JUbicación
                                    </th>
                                    <th class="border border-gray-300">
                                        Acción
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, i) in people" :key="item.id">
                                    <td class="border border-gray-300 p-1">
                                        {{ item.last_name }}
                                    </td>
                                    <td class="border border-gray-300 p-1">
                                        {{ item.first_name }}
                                    </td>
                                    <td
                                        class="border border-gray-300 p-1 text-center"
                                    >
                                        {{ item.birthdate }}
                                    </td>
                                    <td
                                        class="border border-gray-300 p-1 text-center"
                                    >
                                        {{ item.phone }}
                                    </td>
                                    <td
                                        class="border border-gray-300 p-1 text-center"
                                    >
                                        {{ item.civil_status }}
                                    </td>
                                    <td
                                        class="border border-gray-300 p-1 text-center"
                                    >
                                        {{
                                            `${item.latitude}, ${item.longitude}`
                                        }}
                                    </td>
                                    <td
                                        class="border border-gray-300 p-1 text-center"
                                    >
                                        <button
                                            @click="editar(item)"
                                            class="bg-yellow-500 py-1 px-2 text-white rounded"
                                        >
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button
                                            @click="
                                                eliminar(
                                                    item.id,
                                                    item.first_name
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
        :person="person"
        :errorPerson="errorPerson"
        @close="toggle"
        @save="save"
    ></ModalPerson>
</template>
