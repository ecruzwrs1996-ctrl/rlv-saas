import api from './api'

export default {

    /**
     * Directory search
     */
    async searchResidents(params = {})
    {
        const response = await api.get(

            '/directory',

            {
                params
            }
        )

        return response.data
    },

    /**
     * Streets
     */
    async getStreets()
    {
        const response =
            await api.get('/streets')

        return response.data
    },

    /**
     * Export CSV
     */
    async exportDirectory(params = {})
    {
        try {

            const response =
                await api.get(

                    '/directory/export',

                    {

                        params,

                        responseType: 'blob'
                    }
                )

            /**
             * Download
             */

            const blob =
                new Blob(

                    [response.data],

                    {
                        type: 'text/csv'
                    }
                )

            const url =
                window.URL.createObjectURL(blob)

            const link =
                document.createElement('a')

            link.href = url

            /**
             * Filename
             */

            const disposition =
                response.headers[
                    'content-disposition'
                ]

            let filename =
                'directory.csv'

            if (disposition) {

                const match =
                    disposition.match(
                        /filename="?([^"]+)"?/
                    )

                if (match?.[1]) {

                    filename = match[1]
                }
            }

            link.setAttribute(
                'download',
                filename
            )

            document.body.appendChild(link)

            link.click()

            link.remove()

            window.URL.revokeObjectURL(url)

        } catch (error) {

            console.error(error)
        }
    }
}