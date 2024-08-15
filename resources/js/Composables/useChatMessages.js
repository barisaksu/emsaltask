import { ref, nextTick } from "vue";
import axios from "axios";

export function useChatMessages() {
    const messages = ref([]);
    const messagesContainer = ref(null);

    function getMessages(selectedUserId, currentUserId) {
        if (!selectedUserId) {
            console.error("No user selected");
            return;
        }

        axios.get(`/get-messages`, {
            params: {
                receiver_id: selectedUserId,
            },
        })
            .then((response) => {
                messages.value.splice(0, messages.value.length, ...response.data);
                scrollToBottom();
            })
            .catch((error) => {
                console.error(error);
            });
    }

    function scrollToBottom() {
        nextTick(() => {
            if (messagesContainer.value) {
                messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
            }
        });
    }

    return {
        messages,
        messagesContainer,
        getMessages,
        scrollToBottom,
    };
}
