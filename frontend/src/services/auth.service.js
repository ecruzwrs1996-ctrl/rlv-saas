import axios from 'axios'

const API_URL = 'http://localhost:8080/api/auth'

export default {

    /**
     * Login
     */
    async login(credentials) {

        const response = await axios.post(

            `${API_URL}/login`,
            credentials
        )

        /**
         * Save token + user
         */
        if (response.data?.data?.token) {

            localStorage.setItem(

                'token',

                response.data.data.token
            )

            localStorage.setItem(

                'user',

                JSON.stringify(
                    response.data.data.user
                )
            )
        }

        return response.data
    },

    /**
 * Logout
 */
async logout() {

    const token = this.getToken()

    if (token) {

        try {

            await axios.post(

                `${API_URL}/logout`,

                {},

                {

                    headers: {

                        Authorization: `Bearer ${token}`
                    }
                }
            )

        } catch (error) {

            console.error('Logout error', error)
        }
    }

    localStorage.removeItem('token')

    localStorage.removeItem('user')
},

    /**
     * Get token
     */
    getToken() {

        return localStorage.getItem('token')
    },

    /**
     * Get user
     */
    getUser() {

        const user = localStorage.getItem('user')

        return user ? JSON.parse(user) : null
    },

    /**
     * Is authenticated
     */
    isAuthenticated() {

        return !!localStorage.getItem('token')
    }
}