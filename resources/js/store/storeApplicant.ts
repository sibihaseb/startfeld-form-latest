import { defineStore } from "pinia";
import { ApplicantProfile } from "../client";

export const useApplicantStore = defineStore({
    id: "applicant",
    state: () => ({
        token: null as string | null
    }),
    getters: {
        applicantToken: (state) => state.token
    },
    actions: {

        setApplicant(token: string) {
                this.token = token;
        },

        resetApplicant() {
            this.token = null;
        },

    },
});
