<script setup>
defineProps(['users', 'selectedUserId']);

const emit = defineEmits(['selectUser']);

function selectUser(userId) {
    emit('selectUser', userId);
}
</script>


<template>
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
</template>


<style scoped>
.user-list {
    @apply py-2 px-4 bg-white text-gray-700 rounded-sm mb-2 hover:bg-gray-100 transition cursor-pointer;
}

.active-chat {
    @apply bg-blue-500 text-white hover:bg-blue-600 rounded-sm;
}
</style>
