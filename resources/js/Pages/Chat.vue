<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import axios from "axios";
import {usePage} from '@inertiajs/vue3';
import {ref, watch} from "vue";

const {props} = usePage();
const currentUserId = ref(props.auth.user.id);

defineProps({
    users: Object
});

const selectedUserId = ref(null);

function selectUser(userId) {
    selectedUserId.value = userId;
    getMessages();
}

function sendMessage() {
    if (!selectedUserId.value) {
        console.error("No user selected");
        return;
    }

    axios.post('/send-message', {
        body: message.value,
        receiver_id: selectedUserId.value,
    }).then(response => {
        message.value = '';
        console.log(response.data);
    }).catch(error => {
        console.error(error);
    });
}

function getMessages() {
    console.log(currentUserId.value, selectedUserId.value);
    if (!selectedUserId.value) {
        console.error("No user selected");
        return;
    }

    axios.get(`/get-messages`, {
        params: {
            receiver_id: selectedUserId.value
        }
    }).then(response => {
        console.log(response.data);
        messages.value = response.data;
    }).catch(error => {
        console.error(error);
    });
}

const messages = ref([]);
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
                        <li v-for="user in users" :key="user.id" class="user-list"
                            :class="{ 'active-chat': selectedUserId === user.id }"
                            @click="selectUser(user.id)">
                            {{ user.name }}
                        </li>
                    </ul>

                </div>
                <div class="bg-white shadow-sm w-full rounded-sm flex flex-col">
                    <div class="flex justify-between shadow-sm p-2">
                        <div class="font-bold">
                            Messages
                        </div>
                        <div>
                            <!-- Yenile Butonu -->
                            <button class="border border-gray-100 px-2 rounded-sm">Refresh</button>
                        </div>
                    </div>
                    <div v-if="!selectedUserId" class="flex justify-center items-center my-auto">
                        Please select a user to start chat!
                    </div>
                    <template v-else>
                        <!-- Mesajların bulunduğu alan -->
                        <div class="w-full flex-1 overflow-y-scroll">
                            <div v-if="messages.length === 0"
                                 class="flex justify-center items-center h-full my-auto text-gray-500">
                                Say hi to start chat! 👋
                            </div>

                            <div v-for="message in messages" :key="message.id"
                                 class="m-4">
                                <div
                                    :class="message.user_id === currentUserId ? 'flex justify-end' : 'flex justify-start'">
                                    <div
                                        :class="message.user_id === currentUserId ? 'p-4 bg-blue-500 text-white w-1/2 rounded-lg' : 'p-4 bg-gray-100 w-1/2 rounded-lg'">
                                        {{ message.body }}
                                    </div>
                                </div>
                                <div
                                    :class="message.user_id === currentUserId ? 'flex justify-end' : 'flex justify-start'">
            <span class="text-xs text-gray-500 mt-1">
                {{ message.sent_at }}
            </span>
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
                 isSendDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-600']"
                                    @click="sendMessage">
                                Send
                            </button>

                        </div>
                    </template>
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
