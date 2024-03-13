
import type { ApplicantProfile, ApplicationStatus } from '../index';
import http from './axios'

export class applicantService {
    static createApplicant(applicant: FormData, locale?: string) {
        return new Promise<ApplicantProfile>((resolve, reject) => {
            http.post('/api/createapplicant?locale=' + locale, applicant).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }

    static loadApplicant(token: string, locale = 'de') {
        return new Promise<ApplicantProfile>((resolve, reject) => {
            http.get('/api/applicant/'+token+'?locale=' + locale).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }

    static loadApplicationStatus(token: string, locale = 'de') {
        return new Promise<ApplicationStatus>((resolve, reject) => {
            http.get('/api/loadApplicationStatus/'+token+'?locale=' + locale).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }

    static updateApplicant(applicant: FormData, token: string, locale?: string) {
        return new Promise<ApplicantProfile>((resolve, reject) => {
            http.post('/api/applicant/'+token+'/update?locale=' + locale, applicant).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }
}
