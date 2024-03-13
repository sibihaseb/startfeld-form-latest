import type { ApplicantProfile } from "./ApplicantProfile";
export type ApplicantTable = {
data: Array<ApplicantProfile>,
links?: {
    first: string,
    last: string,
    next: string,
    prev: string,
},
meta?:{
    current_page: number,
    per_page: number,
    total:number,
    last_page: number,
}
};
