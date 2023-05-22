<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import ModalPerson from '../../Components/ModalPerson.vue';
import { ref } from 'vue';
import Swal from 'sweetalert2';

defineProps({
    people: { type: Object }
});

const modal = ref(false);

const form = useForm({});

const openModal = () => {
    modal.value = true;
};

const closeModal = () => {
    modal.value = false;
};

const editar = () => { }

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
        cancelButtonText: '<i class="fa-solid fa-ban"> </i> Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('people.destroy', id))
        }
    })

    // axios.delete(route('people.destroyed/' + id)).then(() => {
    //     close();
    //     nextTick().then(() => emit('confirmed'));

    // }).catch(error => {
    //     form.error = error.response.data.errors;
    //     // passwordInput.value.focus();
    // });
}
</script>

<template>
    <AppLayout title="Personas">
        <template #header>
            <div class="container mx-auto bg-white w-full flex">
                <h1><i class="fa fa-users"></i> Personas</h1>
                <button @click="openModal" class="ml-2 h-8 px-3 rounded bg-green-500 text-white">
                    <i class="fa-solid fa-circle-plus"></i> Añadir
                </button>
            </div>
        </template>

        <div class="px-12 py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4">

                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th>Apellido</th>
                                    <th>Nombre</th>
                                    <th>Fecha de nacimiento</th>
                                    <th>Celular</th>
                                    <th>Estado Civil</th>
                                    <th>JUbicación</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="person, i in people" :key="person.id">
                                    <td>{{ person.last_name }}</td>
                                    <td>{{ person.first_name }}</td>
                                    <td>{{ person.birthdate }}</td>
                                    <td>{{ person.phone }}</td>
                                    <td>{{ person.civil_status }}</td>
                                    <td>{{ `${person.latitude}, ${person.longitude}` }}</td>
                                    <td>
                                        <button @click="editar" class="bg-yellow-500 p-1 rounded">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button @click="eliminar(person.id, person.first_name)"
                                            class="ml-1 bg-red-500 p-1 rounded">
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
    <ModalPerson :isOpen="modal" :op="'1'" :title="'Añadir Persona'" @close="closeModal"></ModalPerson>
    <ModalPerson :isOpen="modal" :op="'2'" :title="'Editar Persona'" @close="closeModal"></ModalPerson>
</template>