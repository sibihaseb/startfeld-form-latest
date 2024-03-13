import http from './axios'
import type { Auth_Login, Auth_Reset_Password } from '../index'

export class authService {
    static async login(user: Auth_Login, locale = 'de') {
        await http.get('/sanctum/csrf-cookie')
        return await http.post('/login?locale=' + locale, user);
    }

    static async getAuthUser() {
        return await http.get('/api/me');
    }

    static async logout() {
        localStorage.clear();
        return http.post('/logout');
    }

    static sendPasswordResetLink(email: string, locale = 'de') {
        return new Promise((resolve, reject) => {
            http.post('/forgot-password?locale=' + locale, {email}).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response.data.errors);
            });
        });
    }

    static resetPassword(formData: Auth_Reset_Password, locale = 'de') {
        return new Promise((resolve, reject) => {
            http.post('/reset-password?locale=' + locale, formData).then(response => {
                resolve(response.data);
            }).catch(error => {
                reject(error.response.data.errors);
            });
        });
    }
}
