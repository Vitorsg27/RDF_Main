<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pedido from '@/Components/Pedido.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps(['pedidos']);

const form = useForm({
    itens: [{
        nome: "",
        quantidade: 1,
        preco: 0,
    }],
    mesa_id: "",
});

const adicionarItemVazio = () => {
    form.itens.push({ nome: "", quantidade: 1, preco: 0 });
};

const removerItem = (index) => {
    form.itens.splice(index, 1);
};

const atualizarPreco = (index, produtos) => {
    const produtoSelecionado = produtos.find(produto => produto.nome === form.itens[index].nome);

    if (produtoSelecionado) {
        form.itens[index].preco = produtoSelecionado.preco;
    }
};

const categoriaSelecionada = ref('1');
const editing = ref(false);
</script>
 
<template>
    <Head title="Pedidos" />

    <AuthenticatedLayout>
        <div>Index Pedido</div>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form v-if="editing" class="bg-white shadow-sm rounded-lg p-4"
                @submit.prevent="form.post(route('pedido.store'), { onSuccess: () => { form.reset(); editing = false; } })">
                <div v-for="(item, index) in form.itens" :key="index" class="mt-4">
                    <select v-model="item.nome" @change="atualizarPreco(index, produtos)" required placeholder="Nome prato"
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
                    <span>Observação</span>
                    <input v-model="item.observacao" placeholder="..."
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        type="text" />
                    <button @click="removerItem(index)" class="mt-2">Remover Item</button>
                </div>
                <button @click="adicionarItemVazio" class="mt-4">Adicionar Item</button>
                <select v-model="form.mesa_id" required
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="" disabled selected hidden>Selecione a mesa</option>
                    <option v-for="mesa in mesas" :key="mesa.id" :value="mesa.id">
                        {{ mesa.id }}
                    </option>
                </select>

                <InputError :message="form.errors.message" class="mt-2" />
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Salvar</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <PrimaryButton v-if="editing == false" @click="editing = true" class="mt-4 ml-4">Nova Comanda</PrimaryButton>
            <select v-model="categoriaSelecionada"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-6">
                <option value="">Todos as Comandas</option>
                <option :value="1">
                    {{ "Comandas em aberto" }}
                </option>
                <option :value="0">
                    {{ "Comandas fechados" }}
                </option>
            </select>
            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Pedido v-for="pedido in pedidos" :key="pedido.id" :pedido="pedido"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>