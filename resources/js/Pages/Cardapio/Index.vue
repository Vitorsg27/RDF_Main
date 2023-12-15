<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Item from '@/Components/Item.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps(['items', 'categorias']);

const form = useForm({
    nome: '',
    descricao: '',
    categoria: '',
    preco: '',
});

const categoriaSelecionada = ref('');

</script>
 
<template>
    <Head title="Cardapio" />

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('cardapio.store'), { onSuccess: () => form.reset() })">
                <textarea v-model="form.nome" placeholder="Nome prato"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-1"></textarea>
                <textarea v-model="form.descricao" placeholder="Descrição do prato"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-1"></textarea>
                <textarea v-model="form.categoria" placeholder="Categoria do prato"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-1"></textarea>
                <input v-model="form.preco" placeholder="Preço"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    type="number" step="0.01" />
                <InputError :message="form.errors.message" class="mt-2" />
                <PrimaryButton class="mt-4">Salvar</PrimaryButton>
            </form>
            <label for="categoria">Selecione uma categoria:</label>
            <select v-model="categoriaSelecionada">
                <option value="">Todas as Categorias</option>
                <option v-for="categoria in categorias" :key="categoria" :value="categoria">
                    {{ categoria }}
                </option>
            </select>
            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Item v-for="item in items" :key="item.id" :item="item" :categoria="categoriaSelecionada"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>