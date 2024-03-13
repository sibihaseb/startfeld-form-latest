import { defineStore } from "pinia";
import Cookies from "js-cookie";
import router from "../router";
import type { User ,Auth_Login } from "../client";
import { authService } from "../client";

const getLoggedInUserAuthenticatedFromCookies = (): boolean | null => {
    return JSON.parse(Cookies.get("is_authenticated") || "null") as
        | boolean
        | null;
};

export const useAuthStore = defineStore({
    id: "auth",
    state: () => ({
        isAuthenticated: getLoggedInUserAuthenticatedFromCookies(),
        user: null as User | null,
    }),
    getters: {
        loggedIn: (state) => state.isAuthenticated != null,
        me: (state) => state.user,
    },
    actions: {
        login(loginForm: Auth_Login, locale = "de") {
            return new Promise<void>((resolve, reject) => {
                authService.login(loginForm,locale)
                    .then((response) => {
                        let responseResult = JSON.parse(response.config.data);
                        let rememberMe: boolean = responseResult.remember;
                        Cookies.set("is_authenticated", "true", {
                            secure: (import.meta.env.VITE_COOKIES_SECURE =
                                "false" ? false : true),
                                expires: rememberMe ? 365 : null
                        }
                        );
                        this.setIsAuthenticated(true);
                        resolve();
                    })
                    .catch(function (error: Object) {
                        reject(error);
                        router.push({ name: "login" });
                    });
            });
        },
        authUser() {
            return new Promise<void>((resolve, reject) => {
                authService.getAuthUser()
                    .then((response) => {
                        this.setUser(response.data);
                        resolve();
                    })
                    .catch((error) => {
                        if(error.response.status == 401)
                        {
                            Cookies.remove("is_authenticated");
                            this.setIsAuthenticated(false);
                        }
                        reject(error.response);
                    });
            });
        },

        logoutUser() {
            return new Promise<void>((resolve, reject) => {
                authService.logout()
                    .then((response) => {
                        Cookies.remove("is_authenticated");
                        this.setIsAuthenticated(false);
                        resolve();
                    })
                    .catch((error) => {
                        Cookies.remove("is_authenticated");
                        this.setIsAuthenticated(false);
                        reject(error.response);
                    });
            });
        },

        setUser(u: User) {
            this.user = u;
        },

        setIsAuthenticated(auth: boolean) {
            this.isAuthenticated = auth;
        },

        getUser() {
            this.authUser();
        },
    },
});
