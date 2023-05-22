<script setup>
import { reactive } from 'vue';
import TextInput from './TextInput.vue';

const emit = defineEmits(['close']);

defineProps({
    person: { type: Object, default: () => ({}) },
    isOpen: {
        type: Boolean,
        default: false
    },
    op: {
        type: String,
        default: ''
    },
    title: {
        type: String,
        default: ''
    }
})

const form = reactive({
    identification: '',
    first_name: '',
    last_name: '',
    birthdate: '',
    phone: '',
    civil_status: '',
    latitude: '',
    longitude: '',
    error: { type: Object, default: () => ({}) },
    processing: false,
});

const save = () => {
    form.processing = true;

    axios.post(route('people.store'), {
        identification: form.identification,
        first_name: form.first_name,
        last_name: form.last_name,
        birthdate: form.birthdate,
        phone: form.phone,
        civil_status: form.civil_status,
        latitude: form.latitude,
        longitude: form.longitude,
    }).then(() => {
        form.processing = false;

        close();
        // form.reset();
        nextTick().then(() => emit('confirmed'));

    }).catch(error => {
        form.processing = false;
        form.error = error.response.data.errors;
        // passwordInput.value.focus();
    });
}

const update = () => {
    var id = document.getElementById('id2').value;
    // form.put(route('people.update', id));
}

const close = () => {
    emit('close');
};
</script>

<template>
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div v-show="isOpen" class="
            absolute
            inset-0
            flex
            items-center
            justify-center
            bg-gray-700 bg-opacity-50
          ">
                <div class="max-w-2xl p-6 bg-white rounded-md shadow-xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl">{{ title }}</h3>
                        <svg @click="close" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-900 cursor-pointer"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="mt-4">
                        <form @submit.prevent="(op === '1' ? save() : update())" class="w-2xl">

                            <TextInput :id="'id' + op" type="hidden" name="id" v-model="form.id"></TextInput>

                            <input v-model="form.identification" type="text" class="mt-1 block w-2xl" placeholder="Cédula"
                                minlength="10" maxlength="10" />
                            <InputError :message="form.error.identification" class="mt-2" />

                            <TextInput v-model="form.first_name" type="text" class="mt-1 block w-full"
                                placeholder="Nombre" />
                            <InputError :message="form.error.first_name" class="mt-2" />

                            <TextInput v-model="form.last_name" type="text" class="mt-1 block w-full"
                                placeholder="Apellido" />
                            <InputError :message="form.error.last_name" class="mt-2" />

                            <TextInput v-model="form.birthdate" type="date" class="mt-1 block w-full"
                                placeholder="Fecha de nacimiento" />
                            <InputError :message="form.error.birthdate" class="mt-2" />

                            <input v-model="form.phone" type="text" class="mt-1 block w-full" placeholder="Celular"
                                minlength="10" maxlength="10" />
                            <InputError :message="form.error.phone" class="mt-2" />

                            <select v-model="form.civil_status" class="mt-1 block w-full">
                                <option value="">Seleccione</option>
                                <option value="Soltero">Soltero</option>
                                <option value="Casado">Casado</option>
                                <option value="Divorciado">Divorciado</option>
                                <option value="Viudo">Viudo</option>
                            </select>
                            <InputError :message="form.error.civil_status" class="mt-2" />

                            <input v-model="form.latitude" type="text" class="mt-1 block w-full" placeholder="Latitud"
                                minlength="1" maxlength="15" />
                            <InputError :message="form.error.latitude" class="mt-2" />

                            <input v-model="form.longitude" type="text" class="mt-1 block w-full" placeholder="Longitud"
                                minlength="1" maxlength="15" />
                            <InputError :message="form.error.longitude" class="mt-2" />

                            <div class="flex justify-end mt-4">
                                <button class="px-6 py-2 ml-2 text-blue-100 bg-blue-600 rounded">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>