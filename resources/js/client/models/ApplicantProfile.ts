import { ApplicantCurrentStatus } from "./ApplicantCurrentStatus";
import { QuestionAnswer } from "./QuestionAnswer";

export type ApplicantProfile = {
    id: number;
    token?: string;
    surname: string;
    firstname: string;
    address: string,
    zip: string;
    city: string,
    email: string;
    title?: string;
    phone: string;
    training?: string;
    current_status: ApplicantCurrentStatus;
    current_status_other?: string;
    applicant_status?: {
        id: number;
        applicant_id: number;
        status: ApplicantCurrentStatus,
        created_at: Date,
    };
    applicant_answer?: QuestionAnswer[];
};

