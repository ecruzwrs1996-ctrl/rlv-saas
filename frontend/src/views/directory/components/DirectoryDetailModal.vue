<template>

<div class="modal-overlay">

    <div class="modal-container">

        <!-- Header -->

        <div class="modal-header">

            <div>

                <h2>

                    Resident Detail

                </h2>

                <p>

                    Residential directory information

                </p>

            </div>

            <button
                class="btn-close"
                @click="$emit('close')"
            >

                ✕

            </button>

        </div>

        <!-- Body -->

        <div class="modal-body">

            <!-- Resident -->

            <div class="detail-card">

                <span class="label">

                    Resident

                </span>

                <strong>

                    {{
                        resident.resident_name
                    }}

                </strong>

            </div>

            <!-- Owner -->

            <div class="detail-card">

                <span class="label">

                    Owner

                </span>

                <strong>

                    {{
                        resident.owner_name
                        || '-'
                    }}

                </strong>

            </div>

            <!-- Street -->

            <div class="detail-card">

                <span class="label">

                    Street

                </span>

                <strong>

                    {{
                        resident.street_name
                    }}

                </strong>

            </div>

            <!-- House -->

            <div class="detail-card">

                <span class="label">

                    House

                </span>

                <strong>

                    Lot:
                    {{ resident.lot }}

                    |

                    Block:
                    {{ resident.block }}

                </strong>

            </div>

            <!-- Phone 1 -->

            <div class="detail-card">

                <span class="label">

                    Phone 1

                </span>

                <strong>

                    {{
                        resident.phone_1
                        || '-'
                    }}

                </strong>

            </div>

            <!-- Phone 2 -->

            <div class="detail-card">

                <span class="label">

                    Phone 2

                </span>

                <strong>

                    {{
                        resident.phone_2
                        || '-'
                    }}

                </strong>

            </div>

            <!-- Status -->

            <div class="detail-card">

                <span class="label">

                    Status

                </span>

                <span
                    class="status-badge"
                    :class="resident.status"
                >

                    {{ resident.status }}

                </span>

            </div>

            <!-- Created -->

            <div class="detail-card">

                <span class="label">

                    Created At

                </span>

                <strong>

                    {{
                        resident.created_at
                        || '-'
                    }}

                </strong>

            </div>

        </div>

        <!-- Footer -->

        <div class="modal-footer">

            <button
                class="btn-close-footer"
                @click="$emit('close')"
            >

                Close

            </button>

        </div>

    </div>

</div>

</template>

<script setup>

defineProps({

    resident: {

        type: Object,

        required: true
    }
})

defineEmits([

    'close'
])

</script>

<style scoped>

.modal-overlay {

    position: fixed;

    inset: 0;

    background:
        rgba(0,0,0,0.5);

    display: flex;

    align-items: center;

    justify-content: center;

    z-index: 9999;

    padding: 20px;
}

.modal-container {

    width: 100%;

    max-width: 700px;

    background: white;

    border-radius: 20px;

    overflow: hidden;

    box-shadow:
        0 10px 30px rgba(0,0,0,0.15);
}

.modal-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 24px;

    border-bottom:
        1px solid #f3f4f6;
}

.modal-header h2 {

    margin: 0;

    font-size: 24px;
}

.modal-header p {

    margin-top: 6px;

    color: #6b7280;

    font-size: 14px;
}

.btn-close {

    border: none;

    background: transparent;

    font-size: 20px;

    cursor: pointer;
}

.modal-body {

    padding: 24px;

    display: grid;

    grid-template-columns:
        repeat(
            auto-fit,
            minmax(220px, 1fr)
        );

    gap: 18px;
}

.detail-card {

    display: flex;

    flex-direction: column;

    gap: 8px;

    padding: 18px;

    border-radius: 14px;

    background: #f9fafb;
}

.label {

    font-size: 13px;

    font-weight: 700;

    color: #6b7280;

    text-transform: uppercase;

    letter-spacing: 0.5px;
}

.status-badge {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    width: fit-content;

    padding: 6px 12px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 700;
}

.status-badge.ACTIVE {

    background: #dcfce7;

    color: #166534;
}

.status-badge.INACTIVE {

    background: #fee2e2;

    color: #991b1b;
}

.modal-footer {

    padding: 20px 24px;

    border-top:
        1px solid #f3f4f6;

    display: flex;

    justify-content: flex-end;
}

.btn-close-footer {

    border: none;

    background: #111827;

    color: white;

    padding: 12px 18px;

    border-radius: 10px;

    cursor: pointer;

    font-weight: 600;
}

@media (max-width: 768px) {

    .modal-body {

        grid-template-columns: 1fr;
    }
}

</style>