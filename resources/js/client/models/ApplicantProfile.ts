import { ApplicantCurrentStatus } from "./ApplicantCurrentStatus";
import { ApplicantGender } from "./ApplicantGender";
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
    country?: string;
    phone: string;
    about_us: ApplicantCurrentStatus;
    current_status_other?: string;
    gender: ApplicantGender;
    applicant_status?: {
        id: number;
        applicant_id: number;
        status: ApplicantCurrentStatus,
        created_at: Date,
    };
    applicant_answer?: QuestionAnswer[];
};

