<template>

    <div class="modal-overlay">

        <div class="modal-container">

            <div class="modal-header">

                <h2>

                    {{ isEdit ? 'Editar Usuario' : 'Nuevo Usuario' }}

                </h2>

                <button
                    class="close-btn"
                    @click="$emit('close')"
                >
                    X
                </button>

            </div>

<form @submit.prevent="saveUser">

    <div class="form-grid">

        <!-- Username -->

        <div class="form-group">

            <label>Username</label>

            <input
                v-model="form.username"
                type="text"
                required
            />

        </div>

        <!-- Email -->

        <div class="form-group">

            <label>Email</label>

            <input
                v-model="form.email"
                type="email"
                required
            />

        </div>

        <!-- Name -->

        <div class="form-group">

            <label>Name</label>

            <input
                v-model="form.name"
                type="text"
                required
            />

        </div>

        <!-- Role -->

        <div class="form-group">

            <label>Role</label>

<select v-model="form.Role_id">

    <option
        v-if="currentUser?.Role_id == 1"
        value="1"
    >
        SYS
    </option>

    <option
        v-if="currentUser?.Role_id == 1"
        value="2"
    >
        ADM
    </option>

    <option value="3">
        GUA
    </option>

</select>

        </div>

        <!-- Password -->

        <div class="form-group">

            <label>Password</label>

            <input
                v-model="form.password"
                type="password"
                :required="!isEdit"
            />

        </div>

        <!-- Confirm -->

        <div class="form-group">

            <label>Confirm Password</label>

            <input
                v-model="form.confirmPassword"
                type="password"
                :required="!isEdit"
            />

        </div>

    </div>

    <!-- Status -->

    <div class="form-group">

        <label>Status</label>

        <select v-model="form.status">

            <option value="ACTIVE">
                ACTIVE
            </option>

            <option value="INACTIVE">
                INACTIVE
            </option>

        </select>

    </div>

    <!-- Error -->

    <div
        v-if="errorMessage"
        class="error-message"
    >

        {{ errorMessage }}

    </div>

    <!-- Actions -->

    <div class="modal-actions">

        <button
            type="button"
            class="cancel-btn"
            @click="$emit('close')"
        >

            Cancelar

        </button>

        <button
            type="submit"
            class="save-btn"
        >

            Guardar

        </button>

    </div>

</form>

        </div>

    </div>

</template>

<script setup>

import { reactive, computed } from 'vue'

import usersService from '@/services/users.service'
import authService from '@/services/auth.service'

const props = defineProps({

    user: {

        type: Object,

        default: null
    }
})

const emit = defineEmits([

    'close',
    'saved'
])

const currentUser =
    authService.getUser()

const isEdit = computed(() => {

    return props.user !== null
})

const form = reactive({

    username: props.user?.username || '',

    name: props.user?.name || '',

    email: props.user?.email || '',

    password: '',
    confirmPassword: '',

    Role_id: props.user?.Role_id || '3',

    status: props.user?.status || 'ACTIVE'
})

const errorMessage = computed(() => {

    if (!form.username) {

        return 'Usuario requerido'
    }

    if (!form.name) {

        return 'Nombre requerido'
    }


    if (!form.email) {

        return 'Email requerido'
    }

       if (

    form.password !==
    form.confirmPassword

) {

    return 'Passwords do not match'
}

    return ''
})

/**
 * Save
 */
const saveUser = async () => {

    if (errorMessage.value) {

        return
    }

    try {

        const payload = {

            username: form.username,

            name: form.name,

            email: form.email,

            Role_id: form.Role_id,

            status: form.status
        }

        /**
         * Password optional on edit
         */
        if (form.password) {

            payload.password = form.password
        }

        if (isEdit.value) {

            await usersService.updateUser(

                props.user.Id_user,
                payload
            )

        } else {

            await usersService.createUser(

                payload
            )
        }

        emit('saved')

    } catch (error) {

        console.error(error)
    }
}

</script>

<style scoped>

.modal-overlay {

    position: fixed;

    inset: 0;

    background: rgba(0,0,0,0.5);

    display: flex;

    justify-content: center;

    align-items: center;

    z-index: 1000;
}

.modal-container {

    width: 720px;

    max-width: 95%;

    background: white;

    border-radius: 16px;

    padding: 28px;
}

.form-grid {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 18px;
}

.form-group {

    display: flex;

    flex-direction: column;

    gap: 8px;

    margin-bottom: 18px;
}

.form-group label {

    font-size: 14px;

    font-weight: 600;

    color: #374151;
}

.form-group input,
.form-group select {

    padding: 12px 14px;

    border: 1px solid #d1d5db;

    border-radius: 10px;

    font-size: 14px;

    transition: 0.2s;
}

.form-group input:focus,
.form-group select:focus {

    outline: none;

    border-color: #2563eb;

    box-shadow:
        0 0 0 3px
        rgba(37,99,235,.15);
}

.modal-actions {

    display: flex;

    justify-content: flex-end;

    gap: 12px;

    margin-top: 24px;
}

.cancel-btn,
.save-btn {

    padding: 12px 18px;

    border: none;

    border-radius: 10px;

    font-weight: 600;

    cursor: pointer;
}

.cancel-btn {

    background: #9ca3af;

    color: white;
}

.save-btn {

    background: #2563eb;

    color: white;
}

.error-message {

    color: #dc2626;

    font-size: 14px;

    margin-top: 10px;
}

@media (max-width: 768px) {

    .form-grid {

        grid-template-columns: 1fr;
    }
}

.modal-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 20px;
}

.close-btn {

    border: none;

    background: transparent;

    font-size: 18px;

    cursor: pointer;
}

.form-group {

    display: flex;

    flex-direction: column;

    margin-bottom: 16px;
}

.form-group input,
.form-group select {

    padding: 12px;

    border: 1px solid #ccc;

    border-radius: 8px;
}

.modal-actions {

    display: flex;

    justify-content: flex-end;

    gap: 12px;

    margin-top: 20px;
}

.cancel-btn {

    background: #9e9e9e;

    color: white;
}

.save-btn {

    background: #1565c0;

    color: white;
}

.error-message {

    color: #d32f2f;

    margin-top: 10px;
}

</style>