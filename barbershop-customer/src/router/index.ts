import { useUserStore } from "@/stores/user";
import { createRouter, createWebHistory } from "vue-router";
import Swal from "sweetalert2";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "home",
            component: () => import("../views/HomeView.vue")
        },
        {
            path: "/schedule",
            name: "schedule",
            component: () => import("../views/ScheduleView.vue"),
            meta: { requiresAuth: true }
        },
        {
            path: "/profile",
            name: "profile",
            component: () => import("../views/ProfileView.vue"),
            meta: { requiresAuth: true }
        },
        {
            path: "/signin",
            name: "signin",
            component: () => import("../views/SignInView.vue"),
            meta: { requiresGuest: true }
        },
        {
            path: "/signup",
            name: "signup",
            component: () => import("../views/SignUpView.vue"),
            meta: { requiresGuest: true }
        },
        {
            path: "/:pathMatch(.*)*",
            name: "notfound",
            component: () => import("../views/NotFoundView.vue")
        },
    ]
})

router.beforeEach(async (to, from, next) => {

    const userStore = useUserStore();

    const isAuth = userStore.isAuthenticated;
    const currentUser = userStore.user;

    if (to.meta.requiresGuest && isAuth) {
        return next({ name: "home" });
    }

    if (to.meta.requiresAuth && !isAuth) {
        return next({ name: "signin" });
    }

    if (to.name === "schedule" && currentUser?.has_pending_schedule) {
        Swal.fire({
            icon: "info",
            title: "Attention",
            text: "You already have a pending appointment.",
        });

        return next({ name: "profile" });
    }

    next();
});

export default router