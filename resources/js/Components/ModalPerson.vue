<script setup>
import { reactive } from 'vue'
import DialogModal from './DialogModal.vue'
import TextInput from './TextInput.vue'
import InputError from './InputError.vue'

const emit = defineEmits(['close', 'confirmed'])

defineProps({
    person: { type: Object, default: () => ({}) },
    isOpen: {
        type: Boolean,
        default: false
    },
    op: Number
})

const initialState = {
    identification: '',
    first_name: '',
    last_name: '',
    birthdate: '',
    phone: '',
    civil_status: '',
    latitude: '',
    longitude: '',
    error: { type: Object, default: () => ({}) },
    processing: false
}

const form = reactive({ ...initialState })

const resetForm = () => {
    Object.assign(form, initialState)
}

const save = () => {
    form.processing = true

    axios
        .post(route('people.store'), {
            identification: form.identification,
            first_name: form.first_name,
            last_name: form.last_name,
            birthdate: form.birthdate,
            phone: form.phone,
            civil_status: form.civil_status,
            latitude: form.latitude,
            longitude: form.longitude
        })
        .then(() => {
            form.processing = false

            close()
            resetForm()
            emit('confirmed')
        })
        .catch(error => {
            form.processing = false

            Object.keys(error.response.data.errors).forEach(key => {
                form.error[key] = error.response.data.errors[key][0]
            })
        })
}

const update = () => {
    var id = document.getElementById('id2').value
    // form.put(route('people.update', id));
}

const close = () => {
    emit('close')
}
</script>

<template>
    <DialogModal :show="isOpen" maxWidth="lg" @close="close">
        <template #title>
            {{ `${op > 0 ? 'Editar' : 'Añadir'} persona` }}
        </template>
        <template #content>
            <div class="mt-4">
                <form
                    @submit.prevent="op > 1 ? update() : save()"
                    class="w-2xl"
                >
                    <TextInput
                        :id="'id' + op"
                        type="hidden"
                        name="id"
                        v-model="form.id"
                    ></TextInput>

                    <TextInput
                        v-model="form.identification"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Cédula"
                        minlength="10"
                        maxlength="10"
                    />
                    <InputError
                        :message="form.error.identification"
                        class="mt-2"
                    />

                    <TextInput
                        v-model="form.first_name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Nombre"
                    />
                    <InputError :message="form.error.first_name" class="mt-2" />

                    <TextInput
                        v-model="form.last_name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Apellido"
                    />
                    <InputError :message="form.error.last_name" class="mt-2" />

                    <TextInput
                        v-model="form.birthdate"
                        type="date"
                        class="mt-1 block w-full"
                        placeholder="Fecha de nacimiento"
                    />
                    <InputError :message="form.error.birthdate" class="mt-2" />

                    <TextInput
                        v-model="form.phone"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Celular"
                        minlength="10"
                        maxlength="10"
                    />
                    <InputError :message="form.error.phone" class="mt-2" />

                    <select
                        v-model="form.civil_status"
                        class="mt-1 block w-full rounded border-gray-300"
                    >
                        <option value="">Seleccione</option>
                        <option value="Soltero">Soltero</option>
                        <option value="Casado">Casado</option>
                        <option value="Divorciado">Divorciado</option>
                        <option value="Viudo">Viudo</option>
                    </select>
                    <InputError
                        :message="form.error.civil_status"
                        class="mt-2"
                    />

                    <TextInput
                        v-model="form.latitude"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Latitud"
                        minlength="1"
                        maxlength="15"
                    />
                    <InputError :message="form.error.latitude" class="mt-2" />

                    <TextInput
                        v-model="form.longitude"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Longitud"
                        minlength="1"
                        maxlength="15"
                    />
                    <InputError :message="form.error.longitude" class="mt-2" />
                </form>
            </div>
        </template>
        <template #footer>
            <button class="px-6 py-2 ml-2 text-blue-100 bg-blue-600 rounded">
                Guardar
            </button>
        </template>
    </DialogModal>
</template>
