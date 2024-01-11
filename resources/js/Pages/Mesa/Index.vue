<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Mesa from '@/Components/Mesa.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps(['mesas']);

const form = useForm({
    disponivel: true,
});

const editing = ref(false);
</script>
 
<template>
    <Head title="Mesas" />

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form v-if="editing"
                @submit.prevent="form.post(route('mesa.store'), { onSuccess: () => { form.reset(); editing = false; } })">
                <select v-model="form.disponivel">
                    <option :key="'True'" :value="true">
                        {{ 'true' }}
                    </option>
                    <option :key="'False'" :value="false">
                        {{ 'false' }}
                    </option>
                </select>
                <InputError :message="form.errors.message" class="mt-2" />
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Salvar</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <PrimaryButton v-if="editing == false" @click="editing = true" class="mt-4 ml-4">Nova Mesa</PrimaryButton>
            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Mesa v-for="mesa in mesas" :key="mesa.id" :mesa="mesa" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>