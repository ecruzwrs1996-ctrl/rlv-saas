<template>

    <div
        class="container d-flex justify-content-center align-items-center vh-100"
    >

        <div
            class="card shadow p-4"
            style="width: 400px;"
        >

            <h3 class="text-center mb-4">

                RLV SaaS Login

            </h3>

            <form @submit.prevent="login">

                <div class="mb-3">

                    <label class="form-label">

                        Usuario

                    </label>

                    <input
                        v-model="form.username"
                        type="text"
                        class="form-control"
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Contraseña

                    </label>

                    <input
                        v-model="form.password"
                        type="password"
                        class="form-control"
                    >

                </div>

                <button
                    class="btn btn-dark w-100"
                    :disabled="loading"
                >

                    {{ loading ? 'Ingresando...' : 'Login' }}

                </button>

            </form>

            <div
                v-if="error"
                class="alert alert-danger mt-3"
            >

                {{ error }}

            </div>

        </div>

    </div>

</template>

<script setup>

import { reactive, ref } from 'vue'

import { useRouter } from 'vue-router'

import authService from '../../services/auth.service'

import { saveToken } from '../../utils/token'

const router = useRouter()

const loading = ref(false)

const error = ref('')

const form = reactive({

    username: '',

    password: ''

})

const login = async () => {

    try {

        loading.value = true

        error.value = ''

        const response = await authService.login(form)

        console.log(response)

       if (response.success) {

    saveToken(

        response.data.token
    )

    router.push('/')
}

    } catch (err) {

        error.value = err.response?.data?.message

            || 'Error de autenticación'
    }

    finally {

        loading.value = false
    }
}

</script>