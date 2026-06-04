<template>

    <header class="topbar">

        <div>

            Sistema Residencial RLV
        </div>

        <div class="user-info">

            {{ user?.username }}

            <button @click="logout">

                Logout

            </button>
        </div>

    </header>

</template>

<script setup>

import { ref, onMounted } from 'vue'

import { useRouter } from 'vue-router'

import authService from '@/services/auth.service'

const router = useRouter()

const user = ref(null)

onMounted(() => {

    user.value = authService.getUser()
})

const logout = async () => {

    await authService.logout()

    router.push('/login')
}

</script>

<style scoped>

.topbar {

    height: 70px;

    background: white;

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 0 20px;

    border-bottom: 1px solid #ddd;
}

.user-info {

    display: flex;

    align-items: center;

    gap: 15px;
}

button {

    padding: 8px 14px;

    cursor: pointer;
}

</style>