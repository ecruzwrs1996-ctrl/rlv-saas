<template>

<div
    class="sidebar"
    :class="{ collapsed }"
>

    <!-- Top -->

    <div>

        <!-- Logo -->

        <div class="sidebar-logo">

            <button
                class="collapse-btn"
                @click="toggleSidebar"
            >

                <PanelLeftClose
                    v-if="!collapsed"
                    :size="20"
                />

                <PanelLeftOpen
                    v-else
                    :size="20"
                />

            </button>

            <div
                v-if="!collapsed"
                class="logo-text"
            >

                <h2>RLV</h2>

                <span>
                    Access System
                </span>

            </div>

        </div>

        <!-- Navigation -->

        <nav class="sidebar-nav">

            <!-- Dashboard -->

            <RouterLink
                v-if="canViewDashboard"
                to="/dashboard"
                class="nav-item"
                :class="{
                    active:
                    isActive('/dashboard')
                }"
            >

                <LayoutDashboard
                    :size="20"
                />

                <span v-if="!collapsed">
                    Dashboard
                </span>

            </RouterLink>

            <!-- Streets -->

            <RouterLink
                v-if="canViewStreets"
                to="/streets"
                class="nav-item"
                :class="{
                    active:
                    isActive('/streets')
                }"
            >

                <Map
                    :size="20"
                />

                <span v-if="!collapsed">
                    Streets
                </span>

            </RouterLink>

            <!-- Residents -->

            <RouterLink
                v-if="canViewResidents"
                to="/residents"
                class="nav-item"
                :class="{
                    active:
                    isActive('/residents')
                }"
            >

                <Users
                    :size="20"
                />

                <span v-if="!collapsed">
                    Residents
                </span>

            </RouterLink>

            <!-- Directory -->

            <RouterLink
                to="/directory"
                class="nav-item"
                :class="{
                    active:
                    isActive('/directory')
                }"
            >

                <BookUser
                    :size="20"
                />

                <span v-if="!collapsed">
                    Directory
                </span>

            </RouterLink>

            <!-- Audit -->

            <RouterLink
                v-if="canViewAudit"
                to="/audit"
                class="nav-item"
                :class="{
                    active:
                    isActive('/audit')
                }"
            >

                <ShieldCheck
                    :size="20"
                />

                <span v-if="!collapsed">
                    Audit
                </span>

            </RouterLink>

            <!-- Active Users -->

            <RouterLink
                v-if="canViewActiveUsers"
                to="/active-users"
                class="nav-item"
                :class="{
                    active:
                    isActive('/active-users')
                }"
            >

                <Activity
                    :size="20"
                />

                <span v-if="!collapsed">
                    Active Users
                </span>

            </RouterLink>

            <!-- Users -->

            <RouterLink
                v-if="canViewUsers"
                to="/users"
                class="nav-item"
                :class="{
                    active:
                    isActive('/users')
                }"
            >

                <UserCog
                    :size="20"
                />

                <span v-if="!collapsed">
                    Users
                </span>

            </RouterLink>


            
<RouterLink
    v-if="canViewSettings"
    to="/roles"
    class="nav-item"
    :class="{
        active:
        isActive('/roles')
    }"
>

    <UserCog
        :size="20"
    />

    <span v-if="!collapsed">

        Configuraciones

    </span>

</RouterLink>



        </nav>

    </div>

    <!-- Footer -->

    <div class="sidebar-footer">

        <div
            v-if="!collapsed"
            class="user-info"
        >

            <strong>
                Welcome:
                {{ user?.username }}

            </strong>

            <small>

                Role:
                {{ roleName }}

            </small>

        </div>

        <button
            class="btn-logout"
            @click="logout"
        >

            <LogOut :size="18" />

            <span v-if="!collapsed">
                Logout
            </span>

        </button>

    </div>

</div>

</template>

<script setup>

import {
    ref,
    computed
} from 'vue'

import {
    useRouter,
    useRoute
} from 'vue-router'

import authService from '@/services/auth.service'

import {

    LayoutDashboard,
    Map,
    Users,
    BookUser,
    ShieldCheck,
    Activity,
    UserCog,
    LogOut,
    PanelLeftClose,
    PanelLeftOpen

} from 'lucide-vue-next'

const router = useRouter()

const route = useRoute()

const user = authService.getUser()

const collapsed = ref(false)

/**
 * Roles
 */

const isSYS =
    computed(() =>
        user?.Role_id == 1
    )

const isADM =
    computed(() =>
        user?.Role_id == 2
    )

const isGUA =
    computed(() =>
        user?.Role_id == 3
    )

/**
 * Permissions
 */

const canViewDashboard =
    computed(() =>
        !isGUA.value
    )

const canViewStreets =
    computed(() =>
        !isGUA.value
    )

const canViewResidents =
    computed(() =>
        !isGUA.value
    )

const canViewUsers =
    computed(() =>
        isSYS.value ||
        isADM.value
    )

const canViewAudit =
    computed(() =>
        isSYS.value
    )

const canViewActiveUsers =
    computed(() =>
        isSYS.value ||
        isADM.value
    )

const canViewSettings =
    computed(() =>
        isSYS.value ||
        isADM.value
    )


/**
 * Role label
 */

const roleName =
    computed(() => {

        if (isSYS.value)
            return 'SYS'

        if (isADM.value)
            return 'ADM'

        return 'GUA'
    })

/**
 * Sidebar
 */

function toggleSidebar()
{
    collapsed.value =
        !collapsed.value
}

/**
 * Logout
 */

async function logout()
{
    await authService.logout()

    router.push('/login')
}

/**
 * Active route
 */

function isActive(path)
{
    return route.path === path
}

</script>

<style scoped>

.sidebar {

    width: 260px;

    min-height: 100vh;

    background: #111827;

    color: white;

    display: flex;

    flex-direction: column;

    justify-content: space-between;

    padding: 20px 16px;

    transition: 0.25s ease;
}

.sidebar.collapsed {

    width: 82px;
}

.sidebar-logo {

    display: flex;

    align-items: center;

    gap: 14px;

    margin-bottom: 40px;
}

.logo-text h2 {

    margin: 0;

    font-size: 22px;
}

.logo-text span {

    font-size: 12px;

    color: #9ca3af;
}

.collapse-btn {

    border: none;

    background: #1f2937;

    color: white;

    width: 42px;

    height: 42px;

    border-radius: 10px;

    cursor: pointer;

    display: flex;

    align-items: center;

    justify-content: center;
}

.sidebar-nav {

    display: flex;

    flex-direction: column;

    gap: 10px;
}

.nav-item {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 14px;

    border-radius: 12px;

    color: #d1d5db;

    text-decoration: none;

    transition: 0.2s;
}

.nav-item:hover {

    background: #1f2937;
}

.nav-item.active {

    background: #2563eb;

    color: white;
}

.sidebar.collapsed .nav-item {

    justify-content: center;
}

.sidebar-footer {

    display: flex;

    flex-direction: column;

    gap: 16px;
}

.user-info {

    display: flex;

    flex-direction: column;

    gap: 4px;
}

.user-info small {

    color: #9ca3af;
}

.btn-logout {

    border: none;

    padding: 12px;

    border-radius: 10px;

    background: #dc2626;

    color: white;

    cursor: pointer;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 10px;
}

@media (max-width: 768px) {

    .sidebar {

        position: fixed;

        z-index: 999;
    }
}

</style>