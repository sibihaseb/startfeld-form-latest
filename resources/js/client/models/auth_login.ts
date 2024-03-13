import type { User } from './user'
export type Auth_Login = Pick<User,  "email" | "password" | "remember">;
