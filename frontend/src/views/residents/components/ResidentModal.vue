<template>

<div class="modal-overlay">

    <div class="modal-container">

        <!-- Header -->

        <div class="modal-header">

            <div>

                <h2>

                    {{
                        isEdit
                            ? 'Edit Resident'
                            : 'New Resident'
                    }}

                </h2>

                <p>

                    Residential management form

                </p>

            </div>

            <button
                class="btn-close"
                @click="$emit('close')"
            >
                ✕
            </button>

        </div>

        <!-- Form -->

        <form
            class="resident-form"
            @submit.prevent="submitForm"
        >

            <!-- Street -->

            <div class="form-group">

                <label>

                    Street *

                </label>

                <select v-model="form.Id_street">

                    <option value="">

                        Select Street

                    </option>

                    <option
                        v-for="street in streets"
                        :key="street.Id_street"
                        :value="street.Id_street"
                    >

                        {{ street.name }}

                    </option>

                </select>

            </div>

            <!-- Resident Name -->

            <div class="form-group">

                <label>

                    Resident Name *

                </label>

                <input
                    v-model="form.resident_name"
                    type="text"
                    placeholder="Resident full name"
                />

            </div>

            <!-- Owner -->

            <div class="form-group">

                <label>

                    Owner Name

                </label>

                <input
                    v-model="form.owner_name"
                    type="text"
                    placeholder="Owner full name"
                />

            </div>

            <!-- House -->

            <div class="grid-3">

                <div class="form-group">

                    <label>

                        House *

                    </label>

                    <input
                        v-model="form.house_number"
                        type="text"
                    />

                </div>

                <div class="form-group">

                    <label>

                        Lot

                    </label>

                    <input
                        v-model="form.lot"
                        type="text"
                    />

                </div>

                <div class="form-group">

                    <label>

                        Block

                    </label>

                    <input
                        v-model="form.block"
                        type="text"
                    />

                </div>

            </div>

            <!-- Phones -->

            <div class="grid-3">

                <div class="form-group">

                    <label>

                        Phone 1

                    </label>

                    <input
                        v-model="form.phone_1"
                        type="text"
                    />

                </div>

                <div class="form-group">

                    <label>

                        Phone 2

                    </label>

                    <input
                        v-model="form.phone_2"
                        type="text"
                    />

                </div>

                <div class="form-group">

                    <label>

                        Phone 3

                    </label>

                    <input
                        v-model="form.phone_3"
                        type="text"
                    />

                </div>

            </div>

            <!-- Email -->

            <div class="form-group">

                <label>

                    Email

                </label>

                <input
                    v-model="form.email"
                    type="email"
                />

            </div>

            <!-- Status -->

            <div class="form-group">

                <label>

                    Status

                </label>

                <select v-model="form.status">

                    <option value="ACTIVE">

                        ACTIVE

                    </option>

                    <option value="INACTIVE">

                        INACTIVE

                    </option>

                </select>

            </div>

            <!-- Notes -->

            <div class="form-group">

                <label>

                    Notes

                </label>

                <textarea
                    v-model="form.notes"
                    rows="4"
                />
            </div>

            <!-- Errors -->

            <div
                v-if="errorMessage"
                class="error-box"
            >

                {{ errorMessage }}

            </div>

            <!-- Actions -->

            <div class="modal-actions">

                <button
                    type="button"
                    class="btn-cancel"
                    @click="$emit('close')"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="btn-save"
                    :disabled="loading"
                >

                    {{
                        loading
                            ? 'Saving...'
                            : (
                                isEdit
                                    ? 'Update'
                                    : 'Create'
                            )
                    }}

                </button>

            </div>

        </form>

    </div>

</div>

</template>

<script setup>

import {

    reactive,
    computed,
    watch,
    ref

} from 'vue'

import residentsService from '@/services/residents.service'

const props = defineProps({

    resident: {
        type: Object,
        default: null
    },

    streets: {
        type: Array,
        default: () => []
    }
})

const emit = defineEmits([

    'close',
    'saved'
])

const loading = ref(false)

const errorMessage = ref('')

const form = reactive({

    Id_street: '',

    resident_name: '',

    owner_name: '',

    house_number: '',

    lot: '',

    block: '',

    status: 'ACTIVE',

    phone_1: '',

    phone_2: '',

    phone_3: '',

    email: '',

    notes: ''
})

const isEdit = computed(() => {

    return !!props.resident
})

watch(

    () => props.resident,

    (resident) => {

        if (resident) {

            Object.assign(form, {

                Id_street:
                    resident.Id_street,

                resident_name:
                    resident.resident_name,

                owner_name:
                    resident.owner_name,

                house_number:
                    resident.house_number,

                lot:
                    resident.lot,

                block:
                    resident.block,

                status:
                    resident.status,

                phone_1:
                    resident.phone_1,

                phone_2:
                    resident.phone_2,

                phone_3:
                    resident.phone_3,

                email:
                    resident.email,

                notes:
                    resident.notes
            })
        }
    },

    {
        immediate: true
    }
)

function validateForm() {

    if (!form.Id_street) {

        errorMessage.value =
            'Street is required'

        return false
    }

    if (!form.resident_name) {

        errorMessage.value =
            'Resident name is required'

        return false
    }

    if (!form.house_number) {

        errorMessage.value =
            'House number is required'

        return false
    }

    errorMessage.value = ''

    return true
}

async function submitForm() {

    if (!validateForm()) {

        return
    }

    loading.value = true

    try {

        if (isEdit.value) {

            await residentsService.updateResident(

                props.resident.Id_resident,

                form
            )

        } else {

            await residentsService.createResident(
                form
            )
        }

        emit('saved')

    } catch (error) {

        console.error(error)

        errorMessage.value =
            error?.response?.data?.message ||
            'Error saving resident'

    } finally {

        loading.value = false
    }
}

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

    z-index: 999;
}

.modal-container {

    background: white;

    width: 95%;

    max-width: 900px;

    border-radius: 18px;

    padding: 24px;

    max-height: 90vh;

    overflow-y: auto;

    box-shadow:
        0 10px 30px rgba(0,0,0,0.15);
}

.modal-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 24px;
}

.modal-header h2 {

    margin: 0;
}

.modal-header p {

    margin-top: 6px;

    color: #6b7280;
}

.btn-close {

    border: none;

    background: transparent;

    font-size: 22px;

    cursor: pointer;
}

.resident-form {

    display: flex;

    flex-direction: column;

    gap: 18px;
}

.grid-3 {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 18px;
}

.form-group {

    display: flex;

    flex-direction: column;

    gap: 8px;
}

.form-group label {

    font-size: 14px;

    font-weight: 600;

    color: #374151;
}

.form-group input,
.form-group select,
.form-group textarea {

    padding: 12px;

    border:
        1px solid #d1d5db;

    border-radius: 10px;

    outline: none;

    transition: 0.2s;

    font-size: 14px;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {

    border-color: #2563eb;
}

.error-box {

    background: #fee2e2;

    color: #991b1b;

    padding: 14px;

    border-radius: 10px;
}

.modal-actions {

    display: flex;

    justify-content: flex-end;

    gap: 14px;

    margin-top: 10px;
}

.btn-cancel,
.btn-save {

    border: none;

    padding: 12px 20px;

    border-radius: 10px;

    cursor: pointer;

    font-weight: 600;
}

.btn-cancel {

    background: #e5e7eb;
}

.btn-save {

    background: #111827;

    color: white;
}

.btn-save:disabled {

    opacity: 0.6;

    cursor: not-allowed;
}

@media (max-width: 768px) {

    .grid-3 {

        grid-template-columns: 1fr;
    }

    .modal-container {

        width: 98%;

        padding: 18px;
    }

    .modal-actions {

        flex-direction: column;
    }

    .btn-cancel,
    .btn-save {

        width: 100%;
    }
}

</style>