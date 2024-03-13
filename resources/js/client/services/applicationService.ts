import { ApplicantTable } from '../models/ApplicantTable';
import { ApplicationStatus } from '../models/ApplicationStatus';
import http from './axios';

export class applicationService {
    static loadApplicants(page?: number, pageSize?: number, Search?: string,locale?: string) {
        return new Promise<ApplicantTable>((resolve, reject) => {
            http.get('/api/applicants',{ params: {
                Search: Search,
                pageSize: pageSize,
                page: page,
                locale: locale
            }}).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }

    static async update(token: string, formData: FormData,locale?: string) {
        return new Promise<ApplicationStatus>((resolve, reject) => {
            http.post('/api/application/'+token+'/approve?locale='+locale, formData).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error);
            });
        });
    }

    static delete(token: string, locale?: string) {
        return new Promise((resolve, reject) => {
            http.delete('/api/application/'+token+'/destroy?locale=' + locale).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }

    static async downloadFormPdf(token: string) {
        return new Promise<any>((resolve, reject) => {
            http.get('/api/download/'+token+'/form',{ responseType: 'blob' }).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error);
            });
        });
    }
}
