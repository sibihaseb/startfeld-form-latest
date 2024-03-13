export type User = {
    id: number;
    firstname?: string;
    lastname?: string;
    email: string;
    password?: string,
    notification?: boolean;
    role?: string;
    remember?: boolean
};
