<template>

<div class="filters-container">

    <!-- Module -->

    <div class="filter-group">

        <label>

            Module

        </label>

        <input
            v-model="localFilters.module"
            type="text"
            placeholder="Module Name..."
        />

    </div>

    <!-- Action -->

    <div class="filter-group">

        <label>

            Action

        </label>

        <select
            v-model="localFilters.action_type"
        >

            <option value="">

                All Actions

            </option>

            <option value="CREATE">

                CREATE

            </option>

            <option value="UPDATE">

                UPDATE

            </option>

            <option value="DELETE">

                DELETE

            </option>

            <option value="LOGIN">

                LOGIN

            </option>

            <option value="LOGOUT">

                LOGOUT

            </option>

        </select>

    </div>

    <!-- User ID 

    <div class="filter-group">

        <label>

            User ID

        </label>

        <input
            v-model="localFilters.Id_user"
            type="number"
            placeholder="User ID"
        />

    </div> -->

    <!-- Username -->

<div class="filter-group">

    <label>

        User

    </label>

    <input
        v-model="localFilters.username"
        type="text"
        placeholder="Username or name"
    />

</div>

    <!-- Start Date -->

    <div class="filter-group">

        <label>

            Start Date

        </label>

        <input
            v-model="localFilters.start_date"
            type="date"
        />

    </div>

    <!-- End Date -->

    <div class="filter-group">

        <label>

            End Date

        </label>

        <input
            v-model="localFilters.end_date"
            type="date"
        />

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

import { reactive, watch } from 'vue'

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

    module: '',
    action_type: '',
    username: '',
    start_date: '',
    end_date: ''
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

    localFilters.module = ''

    localFilters.action_type = ''

    localFilters.username = ''

    localFilters.start_date = ''

    localFilters.end_date = ''

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

    padding: 12px;

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

    align-items: flex-end;

    gap: 12px;
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

    color: #111827;
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

        justify-content: stretch;
    }

    .btn-search,
    .btn-clear {

        flex: 1;
    }
}

</style>