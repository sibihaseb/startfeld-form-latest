import { ApplicationStatusType } from "./ApplicationStatusType";

export type ApplicationStatus = {
    id: number;
    applicant_id: number;
    status: ApplicationStatusType;
};
