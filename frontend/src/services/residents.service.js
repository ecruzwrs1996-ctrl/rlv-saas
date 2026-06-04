import api from './api'

export default {

  async getResidents(params = {}) {

    const response = await api.get(

        '/residents',

        {
            params: {

                page:
                    params.page || 1,

                perPage:
                    params.perPage || 5,

                resident_name:
                    params.resident_name || '',

                owner_name:
                    params.owner_name || '',

                Id_street:
                    params.Id_street || '',

                status:
                    params.status || ''
            }
        }
    )

    return response.data
},

    async getResident(id) {

        const response = await api.get(`/residents/${id}`)

        return response.data
    },

    async createResident(data) {

        const response = await api.post('/residents', data)

        return response.data
    },

    async updateResident(id, data) {

        const response = await api.put(`/residents/${id}`, data)

        return response.data
    },

    async deleteResident(id) {

        const response = await api.delete(`/residents/${id}`)

        return response.data
    },

    async getStreets() {

    const response = await api.get(

        '/streets',

        {
            params: {

                page: 1,

                perPage: 999
            }
        }
    )

    return response.data
}
}