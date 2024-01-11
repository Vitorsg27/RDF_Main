<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pedido from '@/Components/Pedido.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps(['items', 'produtos', 'mesas']);

const form = useForm({
    itens: {
        nome: "",
        quantidade: 0,
        preco: 0,
    },
    mesa_id: 0,
});

const editing = ref(false);
</script>
 
<template>
    <Head title="Pedidos" />

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form v-if="editing"
                @submit.prevent="form.post(route('pedido.store'), { onSuccess: () => { form.reset(); editing = false; } })">
                <select v-model="form.itens.nome" required placeholder="Nome prato"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="" disabled selected hidden>Selecione um produto</option>
                    <option v-for="produto in produtos" :key="produto.id" :value="produto.nome">
                        {{ produto.nome }}
                    </option>
                </select>
                <select v-model="form.mesa_id" required
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="" disabled selected hidden>Selecione a mesa</option>
                    <option v-for="mesa in mesas" :key="mesa.id" :value="mesa.id">
                        {{ mesa.id }}
                    </option>
                </select>
                <input v-model="form.itens.quantidade" placeholder="Preço" required
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    type="number" step="1" min="1"/>
                <input v-model="form.itens.preco" placeholder="Preço" required
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    type="number" step="0.01" min="0.01"/>
                <InputError :message="form.errors.message" class="mt-2" />
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Salvar</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <PrimaryButton v-if="editing == false" @click="editing = true" class="mt-4 ml-4">Novo Pedido</PrimaryButton>
            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Pedido v-for="item in items" :key="item.id" :item="item" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>