<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps(['pedido', 'produtos', 'mesas']);

const form = useForm({
    itens: JSON.parse(props.pedido.itens),
    mesa_id: props.pedido.mesa_id,
});

const adicionarItemVazio = () => {
    form.itens.push({ nome: "", quantidade: 0, preco: 0 });
};

const removerItem = (index) => {
    form.itens.splice(index, 1);
};

const editing = ref(false);
</script>
 
<template>
    <div class="p-6 flex space-x-2">
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-gray-800">ID: {{ pedido.id }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{ new Date(pedido.created_at).toLocaleString() }}</small>
                    <small v-if="pedido.created_at !== pedido.updated_at" class="text-sm text-gray-600"> &middot;
                        edited</small>
                </div>
                <Dropdown>
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button
                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out"
                            @click="editing = true">
                            Edit
                        </button>
                        <DropdownLink as="button" :href="route('pedido.destroy', pedido.id)" method="delete">
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <form v-if="editing"
                @submit.prevent="form.put(route('pedido.update', pedido.id), { onSuccess: () => editing = false })">
                <div v-for="(item, index) in form.itens" :key="index" class="mt-4">
                    <select v-model="item.nome" required placeholder="Nome prato"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="" disabled selected hidden>Selecione um produto</option>
                        <option v-for="produto in produtos" :key="produto.id" :value="produto.nome">
                            {{ produto.nome }}
                        </option>
                    </select>
                    <span>quantidade</span>
                    <input v-model="item.quantidade" placeholder="Quantidade" required
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        type="number" step="1" min="1" />
                    <span>preço</span>
                    <input v-model="item.preco" placeholder="Preço" required
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        type="number" step="0.01" min="0.01" />
                    <button @click="removerItem(index)" class="mt-2 class=inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Remover Item</button>
                </div>
                <div class="space-x-2">
                    <button @click="adicionarItemVazio" class="mt-6 class=inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Adicionar Item</button>
                </div>
                <div class="mt-4">Mesa</div>
                <select v-model="form.mesa_id" required
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="pedido.mesa_id" disabled selected hidden>Selecione a mesa</option>
                    <option v-for="mesa in mesas" :key="mesa.id" :value="mesa.id">
                        {{ mesa.id }}
                    </option>
                </select>
                <InputError :message="form.errors.message" class="mt-2" />
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <div v-else>
                <p class="mt-4 text-lg text-gray-900">Itens do Pedido:</p>
                <ul>
                    <li v-for="(item, index) in form.itens" :key="index">
                        {{ item.nome }} - Quantidade: {{ item.quantidade }} - Preço: {{ item.preco }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>