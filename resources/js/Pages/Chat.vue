<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {ref, watch} from "vue";

const message = ref('');
const isSendDisabled = ref(true);

watch(message, (newValue) => {
    isSendDisabled.value = newValue.length < 10;
});
</script>

<template>
    <Head title="Chat"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Chat</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex space-x-4 h-[500px]">
                <div class="bg-white shadow-sm w-1/4 rounded-sm">
                    <div class="shadow-sm p-2 font-bold">
                        Users
                    </div>

                    <ul class="p-2">
                        <li class="user-list active-chat">
                            Barış Bideratan
                        </li>
                        <li class="user-list">
                            İsa Öztaş
                        </li>
                        <li class="user-list">
                            Haluk Ünal
                        </li>
                        <li class="user-list">
                            Selin Poyraz
                        </li>
                    </ul>

                </div>
                <div class="bg-white shadow-sm w-full rounded-sm flex flex-col">
                    <div class="flex justify-between shadow-sm p-2">
                        <div class="font-bold">
                            Messages
                        </div>
                        <div>
                            <!--                        Yenile Butonu -->
                            <button class="border border-gray-100 px-2 rounded-sm">Refresh</button>
                        </div>
                    </div>
                    <!-- Mesajların bulunduğu alan -->
                    <div class="w-full flex-1 overflow-y-scroll">
                        <!-- Sağda yer alacak mesajlar için -->
                        <div class="flex justify-end">
                            <div class="m-4 p-4 bg-blue-500 text-white w-1/2 rounded-lg">Lorem ipsum dolor sit amet
                            </div>
                        </div>
                        <!-- Solda yer alacak mesajlar için -->
                        <div class="flex justify-start">
                            <div class="m-4 p-4 bg-gray-100 w-1/2 rounded-lg">Lorem ipsum dolor sit amet</div>
                        </div>
                        <div class="flex justify-end">
                            <div class="m-4 p-4 bg-blue-500 text-white w-1/2 rounded-lg">Lorem ipsum dolor sit amet
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="m-4 p-4 bg-blue-500 text-white w-1/2 rounded-lg">Lorem ipsum dolor sit amet
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="m-4 p-4 bg-blue-500 text-white w-1/2 rounded-lg">Lorem ipsum dolor sit amet
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="m-4 p-4 bg-blue-500 text-white w-1/2 rounded-lg">Lorem ipsum dolor sit amet
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="m-4 p-4 bg-blue-500 text-white w-1/2 rounded-lg">Lorem ipsum dolor sit amet
                            </div>
                        </div>
                    </div>
                    <!-- Mesaj yazma alanı -->
                    <div class="flex space-x-2 m-4">
                        <input type="text" v-model="message" class="w-full p-2 border border-gray-300 rounded-sm"
                               placeholder="Type a message..."/>
                        <!-- Gönder butonu -->
                        <button :disabled="isSendDisabled"
                                :class="['bg-blue-500 text-white p-2 rounded-sm',
                 isSendDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-600']">
                            Send
                        </button>

                    </div>
                </div>


            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.user-list {
    @apply py-2 px-4 bg-white text-gray-700 rounded-sm mb-2 hover:bg-gray-100 transition cursor-pointer;
}

.active-chat {
    @apply bg-blue-500 text-white hover:bg-blue-600 rounded-sm;
}
</style>
