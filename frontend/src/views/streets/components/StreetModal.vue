<template>

<div class="modal-overlay">

    <div class="modal-container">

        <!-- Header -->

        <div class="modal-header">

            <div>

                <h2>

                    {{
                        isEdit
                            ? 'Edit Street'
                            : 'New Street'
                    }}

                </h2>

                <p>

                    Residential streets catalog

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
            class="street-form"
            @submit.prevent="submitForm"
        >

            <div class="form-group">

                <label>

                    Street Name *

                </label>

                <input
                    v-model="form.name"
                    type="text"
                    placeholder="Street name"
                />

            </div>

            <!-- Error -->

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

import streetsService
from '@/services/streets.service'

const props = defineProps({

    street: {
        type: Object,
        default: null
    }
})

const emit = defineEmits([

    'close',
    'saved'
])

const loading = ref(false)

const errorMessage = ref('')

const form = reactive({

    name: ''
})

const isEdit = computed(() => {

    return !!props.street
})

watch(

    () => props.street,

    (street) => {

        if (street) {

            Object.assign(form, {

                name: street.name
            })
        }
    },

    {
        immediate: true
    }
)

function validateForm() {

    if (!form.name) {

        errorMessage.value =
            'Street name is required'

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

            await streetsService.updateStreet(

                props.street.Id_street,

                form
            )

        } else {

            await streetsService.createStreet(
                form
            )
        }

        emit('saved')

    } catch (error) {

        console.error(error)

        errorMessage.value =
            error?.response?.data?.message ||
            'Error saving street'

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

    max-width: 600px;

    border-radius: 18px;

    padding: 24px;

    box-shadow:
        0 10px 30px rgba(0,0,0,0.15);
}

.modal-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 24px;
}

.modal-header p {

    color: #6b7280;

    margin-top: 6px;
}

.btn-close {

    border: none;

    background: transparent;

    font-size: 22px;

    cursor: pointer;
}

.street-form {

    display: flex;

    flex-direction: column;

    gap: 20px;
}

.form-group {

    display: flex;

    flex-direction: column;

    gap: 8px;
}

.form-group label {

    font-size: 14px;

    font-weight: 600;
}

.form-group input {

    padding: 12px;

    border:
        1px solid #d1d5db;

    border-radius: 10px;

    outline: none;
}

.form-group input:focus {

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