import api from './api'

export default {

    /**
     * Dashboard realtime
     */
    async getDashboardData() {

        const response = await api.get(
            '/active-users/dashboard'
        )

        return response.data
    },

    /**
     * Online users
     */
    async getOnlineUsers() {

        const response = await api.get(
            '/active-users/online'
        )

        return response.data
    }
}