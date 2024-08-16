<script setup>
import {ref, watch} from "vue";
import axios from "axios";
import {useChatMessages} from "@/Composables/useChatMessages";

const props = defineProps({
    selectedUserId: Number,
    currentUserId: Number,
});

const {messages, messagesContainer, getMessages, scrollToBottom} = useChatMessages();

const message = ref('');
const isSendDisabled = ref(true);

function sendMessage() {
    if (!props.selectedUserId) {
        console.error("No user selected");
        return;
    }

    axios.post('/send-message', {
        body: message.value,
        receiver_id: props.selectedUserId,
    }).then(response => {
        message.value = '';
        console.log(response.data);
        messages.value.push(response.data);
        scrollToBottom();
    }).catch(error => {
        console.error(error);
    });
}

watch(() => props.selectedUserId, (newUserId) => {
    if (newUserId) {
        // Leave previous channel
        Echo.leave(`chat.${props.currentUserId}`);

        Echo.private(`chat.${props.currentUserId}`)
            .listen('MessageSent', (e) => {
                if (props.selectedUserId === e.message.user_id || props.selectedUserId === e.message.receiver_id) {
                    if (!messages.value.some(msg => msg.id === e.message.id)) {
                        messages.value.push(e.message);
                    }
                }
            })
            .error((error) => {
                console.error('Abonelik hatası:', error);
            });

        getMessages(newUserId, props.currentUserId);

    }
});

watch(() => message.value, (newValue) => {
    isSendDisabled.value = newValue.length < 10;
});

watch(() => messages.value, () => {
    scrollToBottom();
}, {deep: true});
</script>

<template>
    <div class="bg-white shadow-sm w-full rounded-sm flex flex-col">
        <div class="flex justify-between shadow-sm p-2">
            <div class="font-bold">
                Messages
            </div>
            <div>
                <!-- Yenile Butonu -->
                <button @click="getMessages(props.selectedUserId, props.currentUserId)"
                        class="border border-gray-100 px-2 rounded-sm">Refresh
                </button>
            </div>
        </div>
        <div v-if="!props.selectedUserId" class="flex justify-center items-center my-auto">
            Please select a user to start chat!
        </div>
        <template v-else>
            <div ref="messagesContainer" class="w-full flex-1 overflow-y-scroll">
                <div v-if="messages.length === 0"
                     class="flex justify-center items-center h-full my-auto text-gray-500">
                    Say hi to start chat! 👋
                </div>

                <div v-for="message in messages" :key="message.id"
                     class="m-4">
                    <div
                        :class="message.user_id === props.currentUserId ? 'flex justify-end' : 'flex justify-start'">
                        <div
                            :class="message.user_id === props.currentUserId ? 'p-4 bg-blue-500 text-white w-1/2 rounded-lg' : 'p-4 bg-gray-100 w-1/2 rounded-lg'">
                            {{ message.body }}
                        </div>
                    </div>
                    <div
                        :class="message.user_id === props.currentUserId ? 'flex justify-end' : 'flex justify-start'">
                        <span class="text-xs text-gray-500 mt-1">
                            {{ message.sent_at }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex space-x-2 m-4">
                <input type="text" v-model="message" class="w-full p-2 border border-gray-300 rounded-sm"
                       placeholder="Type a message..."/>
                <button :disabled="isSendDisabled"
                        :class="['bg-blue-500 text-white p-2 rounded-sm',
                 isSendDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-600']"
                        @click="sendMessage">
                    Send
                </button>
            </div>
        </template>
    </div>
</template>
