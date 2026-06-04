import api from './api'

export default {

    /**
     * Obtener auditoría
     */
    async getAuditLogs(params = {}) {

        const response = await api.get(

            '/audit',

            {
                params
            }
        )

        return response.data
    },

    /**
     * Export XLSX
     */
    async exportAudit() {

        const response = await api.get(

            '/audit/export',

            {
                responseType: 'blob'
            }
        )

        return response
    },

    /**
     * Descargar auditoría XLSX
     */
    async downloadAuditExport()
    {
        try {

            const response =
                await api.get(

                    '/audit/export',

                    {
                        responseType: 'blob'
                    }
                )

            /**
             * Filename
             */
            let filename =
                'AuditReport.xlsx'

            const disposition =
                response.headers[
                    'content-disposition'
                ]

            if (disposition) {

                const match =
                    disposition.match(
                        /filename="?([^"]+)"?/
                    )

                if (
                    match &&
                    match[1]
                ) {

                    filename =
                        match[1]
                }
            }

            /**
             * Blob
             */
            const blob =
                new Blob(

                    [response.data],

                    {
                        type:
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    }
                )

            /**
             * Download
             */
            const url =
                window.URL.createObjectURL(
                    blob
                )

            const link =
                document.createElement(
                    'a'
                )

            link.href = url

            link.download =
                filename

            document.body
                .appendChild(link)

            link.click()

            link.remove()

            window.URL
                .revokeObjectURL(
                    url
                )

        } catch (error) {

            console.error(error)

            throw error
        }
    },

    /**
     * Purge auditoría
     */
    async purgeAudit() {

        const response =
            await api.post(
                '/audit/purge'
            )

        return response.data
    }
}