<template>
    <div class="flex space-x-2 m-4">
        <input type="text" v-model="message" class="w-full p-2 border border-gray-300 rounded-sm"
               placeholder="Type a message..." @keyup.enter="sendMessage" />
        <button :disabled="isSendDisabled"
                :class="['bg-blue-500 text-white p-2 rounded-sm',
                         isSendDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-600']"
                @click="sendMessage">
            Send
        </button>
    </div>
</template>

<script setup>
import {ref, watch} from 'vue';

const message = ref('');
const isSendDisabled = ref(true);

watch(message, (newValue) => {
    isSendDisabled.value = newValue.length < 10;
});

defineProps(['selectedUserId']);
const emit = defineEmits(['sendMessage']);

function sendMessage() {
    if (!selectedUserId.value) {
        console.error("No user selected");
        return;
    }

    emit('sendMessage', message.value);
    message.value = '';  // Gönderim sonrası input alanını temizle
}
</script>
