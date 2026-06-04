import api from './api'

export default {

    async getStreets(params = {}) {

        const response = await api.get(
            '/streets',
            {
                params
            }
        )

        return response.data
    },

    async createStreet(data) {

        const response = await api.post(
            '/streets',
            data
        )

        return response.data
    },

    async updateStreet(id, data) {

        const response = await api.put(
            `/streets/${id}`,
            data
        )

        return response.data
    },

    async deleteStreet(id) {

        const response = await api.delete(
            `/streets/${id}`
        )

        return response.data
    }
}