import type {User} from './user'
export type UserTable = {
data: Array<User>,
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
