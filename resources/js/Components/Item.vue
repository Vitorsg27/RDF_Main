<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps(['item', 'categoria']);
 
const form = useForm({
    nome: props.item.nome,
    descricao: props.item.descricao,
    preco: props.item.preco,
    categoria: props.item.categoria,
    estoque: props.item.estoque,
});
const semCategoria = computed(() => props.categoria === '');

const editing = ref(false);
</script>
 
<template>
    <div v-if="semCategoria || item.categoria == categoria" class="p-6 flex space-x-2">
        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg> -->
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-gray-800">{{ item.nome }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{ new Date(item.created_at).toLocaleString() }}</small>
                    <small v-if="item.created_at !== item.updated_at" class="text-sm text-gray-600"> &middot; edited</small>
                </div>
                <!-- <Dropdown v-if="chirp.user.id === $page.props.auth.user.id"> -->
                <Dropdown>
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                            Edit
                        </button>
                        <DropdownLink as="button" :href="route('cardapio.destroy', item.id)" method="delete">
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <form v-if="editing" @submit.prevent="form.put(route('cardapio.update', item.id), { onSuccess: () => editing = false })">
                <span>Nome do Prato</span>
                <textarea v-model="form.nome" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <span>Descrição do Prato</span>
                <textarea v-model="form.descricao" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <span>Categoria</span>
                <textarea v-model="form.categoria" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <span>Preço</span>
                <input v-model="form.preco" type="number" step="0.01" max="999.99" min="0.01" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>
                <span>Estoque</span>
                <input v-model="form.estoque" type="number" step="1" max="999" min="0" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>
                <InputError :message="form.errors.message" class="mt-2" />
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <div v-else>
                <p class="mt-4 text-lg text-gray-900">{{ item.categoria }}</p>
                <p class="mt-4 text-lg text-gray-900">{{ item.descricao }}</p>
                <p class="mt-4 text-lg text-gray-900">R$ {{ item.preco }}</p>
                <p class="mt-4 text-lg text-gray-900">estoque {{ item.estoque }}</p>
            </div>
        </div>
    </div>
</template>