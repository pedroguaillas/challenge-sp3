<script setup>
import DialogModal from './DialogModal.vue'
import TextInput from './TextInput.vue'
import InputError from './InputError.vue'

const emit = defineEmits(['close', 'save'])

defineProps({
    person: { type: Object, default: () => ({}) },
    errorPerson: { type: Object, default: () => ({}) },
    isOpen: { type: Boolean, default: false }
})

const close = () => {
    emit('close')
}

const save = () => {
    emit('save')
}
</script>

<template>
    <DialogModal :show="isOpen" maxWidth="lg" @close="close">
        <template #title>
            {{ `${person.id === undefined ? 'Añadir' : 'Editar'} persona` }}
        </template>
        <template #content>
            <div class="mt-4">
                <form
                    @submit.prevent="
                        person.id === undefined ? save() : update()
                    "
                    class="w-2xl"
                >
                    <TextInput
                        :id="'id' + op"
                        type="hidden"
                        name="id"
                        v-model="person.id"
                    ></TextInput>

                    <TextInput
                        v-model="person.identification"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Cédula"
                        minlength="10"
                        maxlength="10"
                    />
                    <InputError
                        :message="errorPerson.identification"
                        class="mt-2"
                    />

                    <TextInput
                        v-model="person.first_name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Nombre"
                    />
                    <InputError
                        :message="errorPerson.first_name"
                        class="mt-2"
                    />

                    <TextInput
                        v-model="person.last_name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Apellido"
                    />
                    <InputError :message="errorPerson.last_name" class="mt-2" />

                    <TextInput
                        v-model="person.birthdate"
                        type="date"
                        class="mt-1 block w-full"
                        placeholder="Fecha de nacimiento"
                    />
                    <InputError :message="errorPerson.birthdate" class="mt-2" />

                    <TextInput
                        v-model="person.phone"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Celular"
                        minlength="10"
                        maxlength="10"
                    />
                    <InputError :message="errorPerson.phone" class="mt-2" />

                    <select
                        v-model="person.civil_status"
                        class="mt-1 block w-full rounded border-gray-300"
                    >
                        <option value="">Seleccione</option>
                        <option value="Soltero">Soltero</option>
                        <option value="Casado">Casado</option>
                        <option value="Divorciado">Divorciado</option>
                        <option value="Viudo">Viudo</option>
                    </select>
                    <InputError
                        :message="errorPerson.civil_status"
                        class="mt-2"
                    />

                    <TextInput
                        v-model="person.latitude"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Latitud"
                        minlength="1"
                        maxlength="15"
                    />
                    <InputError :message="errorPerson.latitude" class="mt-2" />

                    <TextInput
                        v-model="person.longitude"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Longitud"
                        minlength="1"
                        maxlength="15"
                    />
                    <InputError :message="errorPerson.longitude" class="mt-2" />
                </form>
            </div>
        </template>
        <template #footer>
            <button
                @click="save"
                class="px-6 py-2 ml-2 text-blue-100 bg-blue-600 rounded"
            >
                Guardar
            </button>
        </template>
    </DialogModal>
</template>
