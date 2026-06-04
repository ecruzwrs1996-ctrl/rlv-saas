<template>

<div class="filters-container">

    <!-- Resident -->

    <div class="filter-group">

        <label>

            Resident

        </label>

        <input
            v-model="localFilters.resident_name"
            type="text"
            placeholder="Resident name..."
        />

    </div>

    <!-- Owner -->

    <div class="filter-group">

        <label>

            Owner

        </label>

        <input
            v-model="localFilters.owner_name"
            type="text"
            placeholder="Owner name..."
        />

    </div>

    <!-- Lot -->

    <div class="filter-group">

        <label>

            Lot

        </label>

        <input
            v-model="localFilters.lot"
            type="text"
            placeholder="Lot..."
        />

    </div>

    <!-- Block -->

    <div class="filter-group">

        <label>

            Block

        </label>

        <input
            v-model="localFilters.block"
            type="text"
            placeholder="Block..."
        />

    </div>

    <!-- Street -->

    <div class="filter-group">

        <label>

            Street

        </label>

        <select
            v-model="localFilters.Id_street"
        >

            <option value="">

                All Streets

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

    <!-- Status -->

    <div class="filter-group">

        <label>

            Status

        </label>

        <select
            v-model="localFilters.status"
        >

            <option value="">

                All Status

            </option>

            <option value="ACTIVE">

                ACTIVE

            </option>

            <option value="INACTIVE">

                INACTIVE

            </option>

            <option value="SUSPENDED">

                SUSPENDED

            </option>

        </select>

    </div>

    <!-- Actions -->

    <div class="filter-actions">

        <button
            class="btn-search"
            @click="applyFilters"
        >

            Buscar

        </button>

        <button
            class="btn-clear"
            @click="clearFilters"
        >

            Limpiar

        </button>

        <button
            class="btn-export"
            @click="exportReport"
        >

            Export CSV

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
    },

    streets: {

        type: Array,

        default: () => []
    }
})

const emit = defineEmits([

    'search',

    'clear',

    'export'
])

/**
 * Local filters
 */

const localFilters = reactive({

    resident_name: '',

    owner_name: '',

    lot: '',

    block: '',

    Id_street: '',

    status: ''
})

/**
 * Sync props
 */

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

/**
 * Search
 */

function applyFilters()
{
    emit(

        'search',

        {

            ...localFilters
        }
    )
}

/**
 * Clear
 */

function clearFilters()
{
    localFilters.resident_name = ''

    localFilters.owner_name = ''

    localFilters.lot = ''

    localFilters.block = ''

    localFilters.Id_street = ''

    localFilters.status = ''

    emit('clear')
}

/**
 * Export
 */

function exportReport()
{
    emit(

        'export',

        {

            ...localFilters
        }
    )
}

</script>

<style scoped>

.filters-container {

    display: flex;

    flex-wrap: wrap;

    gap: 20px;

    background: white;

    padding: 22px;

    border-radius: 18px;

    box-shadow:
        0 4px 14px rgba(0,0,0,0.05);
}

.filter-group {

    display: flex;

    flex-direction: column;

    gap: 8px;

    flex: 1;

    min-width: 220px;
}

.filter-group label {

    font-size: 14px;

    font-weight: 600;

    color: #374151;
}

.filter-group input,
.filter-group select {

    padding: 12px 14px;

    border: 1px solid #d1d5db;

    border-radius: 10px;

    outline: none;

    font-size: 14px;

    transition: 0.2s;
}

.filter-group input:focus,
.filter-group select:focus {

    border-color: #2563eb;

    box-shadow:
        0 0 0 3px rgba(37,99,235,0.1);
}

.filter-actions {

    display: flex;

    align-items: flex-end;

    gap: 12px;

    flex-wrap: wrap;
}

.btn-search,
.btn-clear,
.btn-export {

    border: none;

    padding: 12px 18px;

    border-radius: 10px;

    cursor: pointer;

    font-weight: 600;

    transition: 0.2s;
}

.btn-search {

    background: #111827;

    color: white;
}

.btn-clear {

    background: #e5e7eb;

    color: #111827;
}

.btn-export {

    background: #16a34a;

    color: white;
}

@media (max-width: 768px) {

    .filters-container {

        flex-direction: column;
    }

    .filter-group {

        width: 100%;
    }

    .filter-actions {

        width: 100%;
    }

    .btn-search,
    .btn-clear,
    .btn-export {

        flex: 1;
    }
}

</style>