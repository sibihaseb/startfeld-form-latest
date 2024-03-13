import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from '../store';
import type { RouteLocationNormalized } from 'vue-router';
import DefaultLayout from '../layout/DefaultLayout.vue';
import DashboardLayout from '../layout/DashboardLayout.vue';

let tempAdminUrl: string;
const BeforeAuthGuard = async (to: RouteLocationNormalized, from: RouteLocationNormalized, next: Function) => {
    const authStore = useAuthStore();

    if(authStore.isAuthenticated) {
        if(authStore.user === null)
        {
            await authStore.authUser();
        }
        next({name: 'application'});
    }
    else{
        next();
    }

}

const AuthGuard = async (to: RouteLocationNormalized, from: RouteLocationNormalized, next: Function) => {
    const authStore = useAuthStore();
    if (authStore.isAuthenticated && authStore.user === null) {
        await authStore.authUser();
    }
    if (authStore.isAuthenticated) {
        next();
    } else {
        next({ name: 'login' })
    }
}

const SuperadminGuard = async (to: RouteLocationNormalized, from: RouteLocationNormalized, next: Function) => {
    const authStore = useAuthStore();

    if(authStore.isAuthenticated && authStore.user === null) {
        await authStore.authUser();
    }
    if (authStore.isAuthenticated && authStore.me?.role === "superadmin") {
        next();
        return;
    }
    next('/');
}

const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_BASE_URL),
    routes: [
        {
            path: "/:token?",
            name: "wizard",
            // route level code-splitting
            // this generates a separate chunk (Login.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/wizard.vue"),
            meta: {
                layout: DefaultLayout,
            }
        },
        {
            path: "/login",
            name: "login",
            // route level code-splitting
            // this generates a separate chunk (Login.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/auth/login.vue"),
            beforeEnter: BeforeAuthGuard,
            meta: {
                layout: DefaultLayout,
            }
        },
        {
            path: "/forgot-password",
            name: "forgot_password",
            // route level code-splitting
            // this generates a separate chunk (Login.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/auth/forgotPassword.vue"),
            beforeEnter: BeforeAuthGuard,
            meta: {
                layout: DefaultLayout,
            }
        },
        {
            path: "/reset/password/:token",
            name: "reset_password",
            // route level code-splitting
            // this generates a separate chunk (Login.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/auth/resetPassword.vue"),
            beforeEnter: BeforeAuthGuard,
            meta: {
                layout: DefaultLayout,
            }
        },
        {
            path: "/admin/usermanagement",
            name: "user_management",
            // route level code-splitting
            // this generates a separate chunk (Login.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/admin/usermanagement/userManagement.vue"),
            beforeEnter: SuperadminGuard,
            meta: {
                layout: DashboardLayout,
            }
        },
        {
            path: "/admin/users/:user_id/edit",
            name: "edit_user",
            // route level code-splitting
            // this generates a separate chunk (Login.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/admin/usermanagement/createOrEditUser.vue"),
            beforeEnter: SuperadminGuard,
            meta: {
                layout: DashboardLayout,
            }
        },
        {
            path: "/admin/users/create",
            name: "create_user",
            // route level code-splitting
            // this generates a separate chunk (Login.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/admin/usermanagement/createOrEditUser.vue"),
            beforeEnter: SuperadminGuard,
            meta: {
                layout: DashboardLayout,
            }
        },
        {
            path: "/application",
            name: "application",
            // route level code-splitting
            // this generates a separate chunk (Login.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/admin/application/application.vue"),
            beforeEnter: AuthGuard,
            meta: {
                layout: DashboardLayout,
            }
        },
        {
            path: "/profile",
            name: "profile",
            // route level code-splitting
            // this generates a separate chunk (Login.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/admin/profileSetting.vue"),
            beforeEnter: AuthGuard,
            meta: {
                layout: DashboardLayout,
            }
        },
        {
            path: "/application/view/:token",
            name: "application_view",
            // route level code-splitting
            // this generates a separate chunk (Login.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/admin/application/editViewApplication.vue"),
            beforeEnter: AuthGuard,
            meta: {
                layout: DashboardLayout,
            }
        },
        {
            path: "/application/edit/:token",
            name: "application_edit",
            // route level code-splitting
            // this generates a separate chunk (Login.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/admin/application/editViewApplication.vue"),
            beforeEnter: AuthGuard,
            meta: {
                layout: DashboardLayout,
            }
        },
        {
            path: "/404",
            name: "404",
            // route level code-splitting
            // this generates a separate chunk (Login.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/helpers/404.vue"),
            meta: {
                layout: DefaultLayout,
            }
        },
    ]
});

router.beforeEach(async (to, from) => {
    const authStore = useAuthStore();
    if(to.name === "application_view" && to.params.token && authStore.me?.id === undefined)
    {
        tempAdminUrl = to.fullPath;
    }
    if(tempAdminUrl && authStore.me?.id)
    {
        router.push(tempAdminUrl);
        tempAdminUrl = "";
    }
  })

export default router;
