<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {usePage} from '@inertiajs/vue3';
import {onMounted, ref} from "vue";
import UserList from "@/Components/UserList.vue";
import MessageContainer from "@/Components/MessageContainer.vue";

const {props} = usePage();
defineProps({
    users: Object,
});

const time = ref('');
const currentUserId = ref(props.auth.user.id);
const selectedUserId = ref(null);

function selectUser(userId) {
    selectedUserId.value = userId;
}

onMounted(() => {
    Echo.channel('time-messages')
        .listen('TimeMessageSent', (e) => {
            time.value = e.messageText;
        });
});
</script>

<template>
    <Head title="Chat"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Chat</h2>
            <span>
                {{ time }}
            </span>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex space-x-4 h-[500px]">
                <UserList :users="users" :selectedUserId="selectedUserId" @selectUser="selectUser"/>
                <MessageContainer :selectedUserId="selectedUserId"
                                  :currentUserId="Number(currentUserId)"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
