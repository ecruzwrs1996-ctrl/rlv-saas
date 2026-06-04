<template>

<div class="filters-container">

    <div class="filter-group">

        <label>

            Search

        </label>

        <input
            v-model="localFilters.search"
            type="text"
            placeholder="Street name..."
        />

    </div>

    <div class="filter-actions">

        <button
            class="btn-search"
            @click="applyFilters"
        >

            Search

        </button>

        <button
            class="btn-clear"
            @click="clearFilters"
        >

            Clear

        </button>

    </div>

</div>

</template>

<script setup>

import {

    reactive,
    watch

} from 'vue'

const props = defineProps({

    filters: {
        type: Object,
        required: true
    }
})

const emit = defineEmits([

    'search'
])

const localFilters = reactive({

    search: ''
})

watch(

    () => props.filters,

    (newFilters) => {

        Object.assign(
            localFilters,
            newFilters
        )
    },

    {
        immediate: true,
        deep: true
    }
)

function applyFilters() {

    emit('search', {

        ...localFilters
    })
}

function clearFilters() {

    localFilters.search = ''

    applyFilters()
}

</script>

<style scoped>

.filters-container {

    display: flex;

    flex-wrap: wrap;

    gap: 20px;

    background: white;

    padding: 20px;

    border-radius: 14px;

    box-shadow:
        0 2px 10px rgba(0,0,0,0.05);
}

.filter-group {

    display: flex;

    flex-direction: column;

    gap: 8px;

    flex: 1;
}

.filter-group label {

    font-size: 14px;

    font-weight: 600;
}

.filter-group input {

    padding: 12px;

    border:
        1px solid #d1d5db;

    border-radius: 10px;

    outline: none;
}

.filter-group input:focus {

    border-color: #2563eb;
}

.filter-actions {

    display: flex;

    align-items: flex-end;

    gap: 10px;
}

.btn-search,
.btn-clear {

    border: none;

    padding: 12px 18px;

    border-radius: 10px;

    cursor: pointer;

    font-weight: 600;
}

.btn-search {

    background: #111827;

    color: white;
}

.btn-clear {

    background: #e5e7eb;
}

@media (max-width: 768px) {

    .filters-container {

        flex-direction: column;
    }

    .filter-actions {

        width: 100%;
    }

    .btn-search,
    .btn-clear {

        flex: 1;
    }
}

</style>