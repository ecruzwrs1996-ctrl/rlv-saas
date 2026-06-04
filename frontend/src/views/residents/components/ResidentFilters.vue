<template>

<div class="filters-container">

    <!-- Resident -->

    <div class="filter-group">

        <label>

            Resident Name

        </label>

        <input
            v-model="localFilters.resident_name"
            type="text"
            placeholder="Search resident..."
            @keyup.enter="applyFilters"
        />

    </div>

    <!-- Owner -->

    <div class="filter-group">

        <label>

            Owner Name

        </label>

        <input
            v-model="localFilters.owner_name"
            type="text"
            placeholder="Search owner..."
            @keyup.enter="applyFilters"
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

        </select>

    </div>

    <!-- Actions -->

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
    },

    streets: {

        type: Array,

        default: () => []
    }
})

const emit = defineEmits([

    'search'
])

const localFilters = reactive({

    resident_name: '',

    owner_name: '',

    Id_street: '',

    status: ''
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

    localFilters.resident_name = ''

    localFilters.owner_name = ''

    localFilters.Id_street = ''

    localFilters.status = ''

    applyFilters()
}

</script>

<style scoped>

.filters-container {

    display: flex;

    flex-wrap: wrap;

    gap: 20px;

    align-items: flex-end;

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

    min-width: 220px;

    flex: 1;
}

.filter-group label {

    font-size: 14px;

    font-weight: 600;

    color: #374151;
}

.filter-group input,
.filter-group select {

    height: 46px;

    padding: 0 12px;

    border: 1px solid #d1d5db;

    border-radius: 10px;

    font-size: 14px;

    outline: none;

    transition: 0.2s;
}

.filter-group input:focus,
.filter-group select:focus {

    border-color: #2563eb;
}

.filter-actions {

    display: flex;

    gap: 12px;
}

.btn-search,
.btn-clear {

    height: 46px;

    border: none;

    padding: 0 18px;

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

    color: #111827;
}

@media (max-width: 768px) {

    .filters-container {

        flex-direction: column;

        align-items: stretch;
    }

    .filter-group {

        width: 100%;
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