import api from './api'

export default {

    /**
     * GET Roles
     */
    async getRoles() {

        const response =
            await api.get('/roles')

        return response.data
    },

    /**
     * CREATE Role
     */
    async createRole(data) {

        const response =
            await api.post(

                '/roles',

                data
            )

        return response.data
    },

    /**
     * UPDATE Role
     */
    async updateRole(id, data) {

        const response =
            await api.put(

                `/roles/${id}`,

                data
            )

        return response.data
    },

    /**
     * DELETE Role
     */
    async deleteRole(id) {

        const response =
            await api.delete(

                `/roles/${id}`
            )

        return response.data
    }
}
