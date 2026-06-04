import api from './api'

export default {

    /**
     * Dashboard stats
     */
    async getStats() {

        const response =
            await api.get(
                '/dashboard/stats'
            )

        return response.data
    },

    /**
     * Dashboard activity
     */
    async getActivity() {

        const response =
            await api.get(
                '/dashboard/activity'
            )

        return response.data
    },

/**
 * Activity timeline
 */
async getActivityTimeline() {

    const response =
        await api.get(
            '/dashboard/activity-timeline'
        )

    return response.data
}

}