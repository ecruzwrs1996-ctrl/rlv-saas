<template>

    <table class="users-table">

        <thead>

            <tr>

                <th v-if="showIdColumn">ID</th>

                <th>Usuario</th>

                <th>Nombre</th>

                <th>Email</th>

                <th>Rol</th>

                <th>Estatus</th>

                <th>Acciones</th>

            </tr>

        </thead>

        <tbody>

            <tr
                v-for="user in users"
                :key="user.Id_user"
            >

                <td v-if="showIdColumn">
                    {{ user.Id_user }}
                </td>

                <td>
                    {{ user.username }}
                </td>

                <td>
                    {{ user.name }}
                </td>

                <td>
                    {{ user.email }}
                </td>

                <td>

                    <span
                        class="role-badge"
                        :class="roleClass(user.Role_id)"
                    >

                        {{ roleName(user.Role_id) }}

                    </span>

                </td>

                <td>

                    <span
                        class="status-badge"
                        :class="user.status"
                    >

                        {{ user.status }}

                    </span>

                </td>

                <td class="actions">

                    <button
                        class="edit-btn"
                        @click="$emit('edit', user)"
                    >
                        Editar
                    </button>

                    <button
                        class="delete-btn"
                        @click="$emit('delete', user)"
                    >
                        Eliminar
                    </button>

                </td>

            </tr>

        </tbody>

    </table>

</template>

<script setup>

defineProps({

    users: {

        type: Array,

        required: true
    }
})

/**
 * Role name
 */
const roleName = (roleId) => {

    switch (parseInt(roleId)) {

        case 1:
            return 'SYS'

        case 2:
            return 'ADM'

        case 3:
            return 'GUA'

        default:
            return 'N/A'
    }
}

/**
 * Role class
 */
const roleClass = (roleId) => {

    switch (parseInt(roleId)) {

        case 1:
            return 'sys'

        case 2:
            return 'adm'

        case 3:
            return 'gua'

        default:
            return ''
    }
}

</script>

<style scoped>

.users-table {

    width: 100%;

    border-collapse: collapse;

    background: white;
}

.users-table th,
.users-table td {

    padding: 14px;

    border-bottom: 1px solid #ddd;

    text-align: left;
}

.users-table th {

    background: #f5f5f5;
}

.actions {

    display: flex;

    gap: 10px;
}

button {

    padding: 8px 12px;

    border: none;

    cursor: pointer;

    border-radius: 6px;
}

.edit-btn {

    background: #1976d2;

    color: white;
}

.delete-btn {

    background: #d32f2f;

    color: white;
}

.role-badge,
.status-badge {

    padding: 6px 10px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: bold;
}

.sys {

    background: #000;

    color: white;
}

.adm {

    background: #1565c0;

    color: white;
}

.gua {

    background: #2e7d32;

    color: white;
}

.ACTIVE {

    background: #2e7d32;

    color: white;
}

.INACTIVE {

    background: #757575;

    color: white;
}

</style>