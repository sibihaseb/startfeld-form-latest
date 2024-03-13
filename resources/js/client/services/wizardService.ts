import http from './axios'
import type { Question } from '../models/Question';
import { QuestionAnswer } from '../models/QuestionAnswer';
import { AdminPrivateNote } from '../models/AdminPrivateNote';
export class wizardService {
    static async loadWizard(token?: string | string[],locale?: string) {
        const tokenCheck = token === undefined ? "" : token;
        return new Promise<Question[]>((resolve, reject) => {
            http.get('/api/loadwizard/'+tokenCheck,{ params: {locale: locale}}).then(response => {
                resolve(response.data.data);
            }).catch(error => {
                reject(error);
            });
        });
    }

    static async loadAdminNotes(token: string,locale?: string) {
        return new Promise<AdminPrivateNote[]>((resolve, reject) => {
            http.get('/api/loadNotes/'+token,{ params: {locale: locale}}).then(response => {
                resolve(response.data.data);
            }).catch(error => {
                reject(error);
            });
        });
    }

    static saveAnswers(answers: FormData, token: string, flag?: string, locale?: string) {
        return new Promise<void>((resolve, reject) => {
            http.post('/api/save/'+token+'/answers?locale=' + locale+'&flag='+flag, answers).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }

    static saveAnswerFiles(answers: FormData, token: string) {
        return new Promise<QuestionAnswer[]>((resolve, reject) => {
            let headers = { "Content-Type": "multipart/form-data" };
            http.post('/api/save/'+token+'/files', answers,{headers}).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }
}
