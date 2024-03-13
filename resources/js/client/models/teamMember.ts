import type { ApplicantProfile } from "./ApplicantProfile";

export type TeamMemberProfile = Omit<ApplicantProfile, "id" | "token">;
