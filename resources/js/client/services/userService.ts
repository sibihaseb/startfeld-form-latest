import type { User } from '../models/user';
import type { UserTable } from '../models/user_table';
import http from './axios'

export class userService {
    static async getAll(locale?: string,page?: number, pageSize?: number, Search?: string, orderBy?: string) {
        return new Promise<UserTable>((resolve, reject) => {
            http.get('/api/users',{ params: {
                Search: Search,
                pageSize: pageSize,
                page: page,
                locale: locale
            }}).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error);
            });
        });
    }

    static create(user: FormData, locale?: string) {
        return new Promise<void>((resolve, reject) => {
            let headers = { "Content-Type": "multipart/form-data" };
            http.post('/api/users?locale=' + locale, user,{headers}).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }

    static get(id: number, locale = 'de') {
        return new Promise<User>((resolve, reject) => {
            http.get('/api/users/'+id+'?locale=' + locale).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }

    static update(user: FormData, id: number, locale?: string) {
        return new Promise<User>((resolve, reject) => {
            let headers = { "Content-Type": "multipart/form-data" };
            http.post('/api/users/'+id+'?locale=' + locale, user,{headers}).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }

    static updateNotification(notification: FormData, id: number, locale?: string) {
        return new Promise<User>((resolve, reject) => {
            let headers = { "Content-Type": "multipart/form-data" };
            http.post('/api/user/'+id+'/notification?locale=' + locale, notification,{headers}).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }

    static delete(id: number, locale?: string) {
        return new Promise((resolve, reject) => {
            http.delete('/api/users/'+id+'?locale=' + locale).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response);
            });
        });
    }


}

