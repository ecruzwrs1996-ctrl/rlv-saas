import api from './api'

export default {

    /**
     * Get users
     */
    async getUsers(params = {}) {

        const response = await api.get(

            '/users',

            {
                params: {

                    page:
                        params.page || 1,

                    perPage:
                        params.perPage || 5,

                    search:
                        params.search || '',

                    Role_id:
                        params.role || ''
                }
            }
        )

        return response.data
    },

    /**
     * Create user
     */
    async createUser(data) {

        const response = await api.post(

            '/users',
            data
        )

        return response.data
    },

    /**
     * Update user
     */
    async updateUser(id, data) {

        const response = await api.put(

            `/users/${id}`,
            data
        )

        return response.data
    },

    /**
     * Delete user
     */
    async deleteUser(id) {

        const response = await api.delete(

            `/users/${id}`
        )

        return response.data
    }
}