<template>

<div
    v-if="visible"
    class="modal-overlay"
>

    <div class="modal-container">

        <div class="modal-header">

            <h2>

                {{ isEdit
                    ? 'Edit Role'
                    : 'Create Role'
                }}

            </h2>

        </div>

        <div class="modal-body">

            <!-- Name -->

            <div class="form-group">

                <label>

                    Role Name

                </label>

                <input
                    v-model="form.name"
                    type="text"
                    maxlength="3"
                    placeholder="SYS"
                />

            </div>

            <!-- Description -->

            <div class="form-group">

                <label>

                    Description

                </label>

                <input
                    v-model="form.description"
                    type="text"
                    placeholder="Administrator"
                />

            </div>

        </div>

        <div class="modal-footer">

            <button
                class="btn-cancel"
                @click="$emit('close')"
            >

                Cancel

            </button>

            <button
                class="btn-save"
                @click="submit"
            >

                Save

            </button>

        </div>

    </div>

</div>

</template>

<script setup>

import {

    reactive,

    watch,

    computed

} from 'vue'

const props = defineProps({

    visible: Boolean,

    role: {

        type: Object,

        default: null
    }
})

const emit = defineEmits([

    'close',

    'save'
])

const form = reactive({

    name: '',

    description: ''
})

const isEdit =
    computed(() =>
        !!props.role
    )

watch(

    () => props.role,

    (value) => {

        if (value) {

            form.name =
                value.name

            form.description =
                value.description

        }

        else {

            form.name = ''

            form.description = ''
        }
    },

    {
        immediate: true
    }
)

function submit()
{
    emit('save', {

        ...form
    })
}

</script>

<style scoped>

.modal-overlay {

    position: fixed;

    inset: 0;

    background:
        rgba(0,0,0,0.5);

    display: flex;

    justify-content: center;

    align-items: center;

    z-index: 999;
}

.modal-container {

    width: 420px;

    background: white;

    border-radius: 14px;

    padding: 24px;

    display: flex;

    flex-direction: column;

    gap: 20px;
}

.form-group {

    display: flex;

    flex-direction: column;

    gap: 8px;
}

.form-group input {

    padding: 12px;

    border: 1px solid #d1d5db;

    border-radius: 10px;
}

.modal-footer {

    display: flex;

    justify-content: flex-end;

    gap: 12px;
}

.btn-save {

    border: none;

    background: #111827;

    color: white;

    padding: 10px 16px;

    border-radius: 10px;

    cursor: pointer;
}

.btn-cancel {

    border: none;

    background: #e5e7eb;

    padding: 10px 16px;

    border-radius: 10px;

    cursor: pointer;
}

</style>